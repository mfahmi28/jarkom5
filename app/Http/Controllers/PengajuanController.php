<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\PengajuanProduk;
use App\Models\Produk;
use App\Models\Cabang;

class PengajuanController extends Controller
{
    public function index()
    {
        $userCabangId = Auth::user()->cabang_id;
        $produkList = Produk::select('id', 'kode', 'nama')->orderBy('nama', 'ASC')->get();
        $cabangList = Cabang::select('id', 'kode', 'nama')->orderBy('nama', 'ASC')->get();

        $fetchPengajuan = Pengajuan::select([
                'pengajuan.kode',
                'pengajuan.tanggal',
                'pengajuan.tipe',
                'users.name AS user_created',
                'cabang.nama AS cabang',
                'pengajuan.keterangan',
                'pengajuan.status'
            ])
            ->when(!empty($userCabangId), function($query) use($userCabangId) {
                $query->where('pengajuan.cabang_id', $userCabangId);
            })
            ->leftJoin('users', 'users.id', 'pengajuan.user_created_id')
            ->leftJoin('cabang', 'cabang.id', 'pengajuan.cabang_id')
            ->orderBy('pengajuan.created_at', 'DESC')
            ->paginate(10);

        $pagination = $fetchPengajuan->links('pagination::tailwind');

        $pengajuanList = [];
        foreach($fetchPengajuan as $pengajuan) {
            $pengajuanList[] = (object) [
                'kode' => $pengajuan->kode,
                'tanggal' => date('d M Y', strtotime($pengajuan->tanggal)),
                'tipe' => $pengajuan->tipe,
                'user_created' => $pengajuan->user_created,
                'cabang' => $pengajuan->cabang,
                'keterangan' => $pengajuan->keterangan ?? '',
                'status' => $pengajuan->status
            ];
        }

        return view('pengajuan.index', compact('produkList', 'cabangList', 'pengajuanList', 'pagination'));
    }

    public function getPengajuanDetail(Request $request)
    {
        $request->validate([
            'pengajuan_kode' => 'required'
        ]);

        $fetchPengajuan = Pengajuan::select([
                'pengajuan.kode',
                'pengajuan.tanggal',
                'pengajuan.tipe',
                'users.name AS user_created',
                'cabang.nama AS cabang',
                'pengajuan.keterangan',
                'pengajuan.status'
            ])
            ->where('pengajuan.kode', $request->pengajuan_kode)
            ->leftJoin('users', 'users.id', 'pengajuan.user_created_id')
            ->leftJoin('cabang', 'cabang.id', 'pengajuan.cabang_id')
            ->first();

        $fetchPengajuanProduk = PengajuanProduk::select([
                'produk.nama',
                'pengajuan_produk.qty'
            ])
            ->where('pengajuan_kode', $request->pengajuan_kode)
            ->leftJoin('produk', 'produk.id', 'pengajuan_produk.produk_id')
            ->get();

        $produkList = [];
        foreach($fetchPengajuanProduk as $produk) {
            $produkList[] = [
                'nama' => $produk->nama,
                'qty' => $produk->qty
            ];
        }

        $pengajuanDetail = [
            'kode' => $fetchPengajuan->kode,
            'tanggal' => date('d M Y', strtotime($fetchPengajuan->tanggal)),
            'tipe' => $fetchPengajuan->tipe,
            'user_created' => $fetchPengajuan->user_created,
            'cabang' => $fetchPengajuan->cabang,
            'keterangan' => $fetchPengajuan->keterangan ?? '',
            'status' => $fetchPengajuan->status,
            'produk_list' => $produkList
        ];

        return response()->json([
            'status' => 'OK',
            'pengajuan_detail' => $pengajuanDetail
        ]);
    }

    public function addPengajuan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'cabang_id' => 'required',
            'produk_list' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            $pengajuanKode = 'PNG-'.date('ymd').rand(0000, 9999);
            $produkList = [];

            Pengajuan::insert([
                    'kode' => $pengajuanKode,
                    'tanggal' => $request->tanggal,
                    'tipe' => 'ORDER',
                    'user_created_id' => Auth::user()->id,
                    'cabang_id' => $request->cabang_id,
                    'keterangan' => !empty($request->keterangan) ? $request->keterangan : null,
                    'status' => 'PENDING',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            foreach($request->produk_list as $produk) {
                $produkList[] = [
                    'pengajuan_kode' => $pengajuanKode,
                    'produk_id' => $produk['produk_id'],
                    'qty' => $produk['qty'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }

            PengajuanProduk::insert($produkList);

            DB::commit();
            return response()->json(['status' => 'OK']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Gagal Menambah Data!'
            ]);
        }
    }

    public function confirmPengajuan(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'status' => 'required'
        ]);

        $updatePengajuan = Pengajuan::where('kode', $request->kode)->update([
                'status' => $request->status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $updatePengajuan ? 'OK' : 'FAIL',
            'message' => $updatePengajuan ? '' : 'Gagal Mengubah Data!'
        ]);
    }

    public function deletePengajuan(Request $request)
    {
        $request->validate([
            'pengajuan_kode' => 'required'
        ]);

        DB::beginTransaction();
        try {
            Pengajuan::where('kode', $request->pengajuan_kode)->delete();
            PengajuanProduk::where('pengajuan_kode', $request->pengajuan_kode)->delete();

            DB::commit();
            return response()->json(['status' => 'OK']);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Gagal Menghapus Data'
            ]);
        }
    }
}
