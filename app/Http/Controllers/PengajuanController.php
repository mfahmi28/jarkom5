<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\PengajuanProduk;
use App\Models\Produk;
use App\Models\Cabang;
use App\Models\Transaksi;
use App\Models\TransaksiProduk;
use App\Models\TransaksiProdukLog;

class PengajuanController extends Controller
{
    public function index()
    {
        $userCabangId = Auth::user()->cabang_id;
        $produkList = Produk::select('id', 'kode', 'nama')->orderBy('nama', 'ASC')->get();
        $cabangList = Cabang::select('id', 'kode', 'nama')->orderBy('nama', 'ASC')->get();
        $transaksiKodeReturList = TransaksiProdukLog::leftJoin('transaksi_produk', 'transaksi_produk.id', 'transaksi_produk_log.transaksi_produk_id')
            ->leftJoin('transaksi', 'transaksi.id', 'transaksi_produk.transaksi_id')
            ->where('transaksi_produk_log.status', 'RETUR')
            ->groupBy('transaksi.order_code')
            ->pluck('transaksi.order_code')
            ->toArray();

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

        return view('pengajuan.index', compact('produkList', 'cabangList', 'pengajuanList', 'transaksiKodeReturList', 'pagination'));
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
        $validates = [
            'tipe' => 'required',
            'tanggal' => 'required',
            'produk_list' => 'required|array'
        ];

        if($request->tipe == 'ORDER') {
            $validates['cabang_id'] = 'required';
        } else if($request->tipe == 'RETUR') {
            $validates['transaksi_kode'] = 'required';
        }

        $request->validate($validates);

        DB::beginTransaction();
        try {
            $pengajuanKode = 'PNG-'.date('ymd').rand(0000, 9999);
            $tipe = $request->tipe;
            $tanggal = $request->tanggal;
            $cabangId = $request->cabang_id;
            $transaksiKodeRef = null;
            $produkList = [];

            if($request->tipe == 'RETUR') {
                $transaksiDetail = Transaksi::where('order_code', $request->transaksi_kode)->first();
                if(empty($transaksiDetail)) {
                    return response()->json([
                        'status' => 'FAIL',
                        'message' => 'Transaksi Sebelumnya Tidak Ditemukan!'
                    ]);
                }

                $transaksiKodeRef = $transaksiDetail->order_code;
                $cabangId = $transaksiDetail->cabang_id;

                foreach($request->produk_list as $produk) {
                    TransaksiProdukLog::leftJoin('transaksi_produk', 'transaksi_produk.id', 'transaksi_produk_log.transaksi_produk_id')
                        ->where('transaksi_produk.transaksi_id', $transaksiDetail->id)
                        ->where('transaksi_produk.produk_id', $produk['produk_id'])
                        ->where('transaksi_produk_log.status', 'RETUR')
                        ->update(['status' => 'RETUR_PROSES']);
                }
            }

            Pengajuan::insert([
                    'kode' => $pengajuanKode,
                    'tanggal' => $tanggal,
                    'tipe' => $tipe,
                    'user_created_id' => Auth::user()->id,
                    'cabang_id' => $cabangId,
                    'keterangan' => !empty($request->keterangan) ? $request->keterangan : null,
                    'status' => 'PENDING',
                    'order_code_ref' => $transaksiKodeRef,
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

        $pengajuanDetail = Pengajuan::where('kode', $request->kode)->first();
        if(empty($pengajuanDetail)) {
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Pengajuan Tidak Ditemukan!'
            ]);
        }

        $pengajuanProdukList = PengajuanProduk::where('pengajuan_kode', $pengajuanDetail->kode)->get();

        DB::beginTransaction();
        try {
            $updatePengajuan = Pengajuan::where('kode', $request->kode)->update([
                    'status' => $request->status,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

            if($pengajuanDetail->tipe == 'RETUR') {
                $transaksiDetail = Transaksi::where('order_code', $pengajuanDetail->order_code_ref)->first();
                if(empty($transaksiDetail)) {
                    return response()->json([
                        'status' => 'FAIL',
                        'message' => 'Transaksi Sebelumnya Tidak Ditemukan!'
                    ]);
                }

                if($request->status == 'APPROVED') {
                    $transaksi = Transaksi::create([
                        'status' => 0,
                        'order_code' => 'TRX-'.date('ymd').rand(0000, 9999),
                        'tipe' => 'RETUR',
                        'supplier_id' => $transaksiDetail->supplier_id,
                        'cabang_id' => $transaksiDetail->cabang_id,
                        'maker_id' => Auth::user()->id,
                        'tax' => 0,
                        'sort_subtotal' => 0,
                        'estimated_date' => Carbon::now()->addDays(Transaksi::EXPIRED_DAYS)->toDateString(),
                        'expired_date' => Carbon::now()->addDays(Transaksi::EXPIRED_DAYS)->toDateString(),
                        'order_code_ref' => $pengajuanDetail->order_code_ref,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
    
                    foreach($pengajuanProdukList as $pengajuanProduk) {
                        TransaksiProduk::insert([
                            'transaksi_id' => $transaksi->id,
                            'produk_id' => $pengajuanProduk->produk_id,
                            'qty' => $pengajuanProduk->qty,
                            'locked_price' => 0,
                            'locked_total' => 0
                        ]);
                    }
                } else {
                    foreach($pengajuanProdukList as $pengajuanProduk) {
                        TransaksiProdukLog::leftJoin('transaksi_produk', 'transaksi_produk.id', 'transaksi_produk_log.transaksi_produk_id')
                            ->where('transaksi_produk.transaksi_id', $transaksiDetail->id)
                            ->where('transaksi_produk.produk_id', $pengajuanProduk->produk_id)
                            ->where('transaksi_produk_log.status', 'RETUR_PROSES')
                            ->update(['status' => 'RETUR']);
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'OK',
                'message' => ''
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Gagal Mengubah Data!'
            ]);
        }
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

    public function getProdukReturList(Request $request)
    {
        $request->validate([
            'transaksi_kode' => 'required'
        ]);

        $produkList = TransaksiProdukLog::select([
                'transaksi_produk.produk_id AS id',
                'transaksi_produk_log.qty'
            ])
            ->leftJoin('transaksi_produk', 'transaksi_produk.id', 'transaksi_produk_log.transaksi_produk_id')
            ->leftJoin('transaksi', 'transaksi.id', 'transaksi_produk.transaksi_id')
            ->where('transaksi.order_code', $request->transaksi_kode)
            ->where('transaksi_produk_log.status', 'RETUR')
            ->get();

        return response()->json([
            'status' => 'OK',
            'produk_list' => $produkList
        ]);
    }
}
