<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        $userSupplierId = Auth::user()->supplier_id;

        $supplierList = Supplier::select('id', 'kode', 'nama')
            ->orderby('nama', 'ASC')
            ->get();

        $kategoriList = KategoriProduk::select('id', 'nama')
            ->orderBy('nama', 'ASC')
            ->get();

        $fetchProduk = Produk::select([
                'produk.id',
                'suppliers.nama AS supplier',
                'produk.kode',
                'produk.nama',
                'kategori_produk.nama AS kategori_produk',
                'produk.harga_per_qty',
                'produk.satuan'
            ])
            ->when(!empty($userSupplierId), function($query) use($userSupplierId) {
                $query->where('supplier_id', $userSupplierId);
            })
            ->leftJoin('suppliers', 'suppliers.id', 'produk.supplier_id')
            ->leftJoin('kategori_produk', 'kategori_produk.id', 'produk.kategori_produk_id')
            ->orderBy('produk.updated_at', 'DESC')
            ->paginate(10);

        $pagination = $fetchProduk->links('pagination::tailwind');

        $produkList = [];
        foreach($fetchProduk as $produk) {
            $produkList[] = (object) [
                'id' => $produk->id,
                'supplier' => $produk->supplier,
                'kode' => $produk->kode,
                'nama' => $produk->nama,
                'kategori_produk' => $produk->kategori_produk,
                'harga_per_qty' => floatval($produk->harga_per_qty),
                'satuan' => $produk->satuan
            ];
        }

        return view('produk.index', compact('produkList', 'pagination', 'supplierList', 'kategoriList'));
    }

    public function getProdukDetail(Request $request)
    {
        $request->validate([
            'produk_id' => 'required'
        ]);

        $fetchProduk = Produk::select('id', 'supplier_id', 'kategori_produk_id AS kategori_id', 'kode', 'nama', 'harga_per_qty', 'satuan')
            ->where('id', $request->produk_id)
            ->first();

        $produkDetail = [
            'id' => $fetchProduk->id,
            'supplier_id' => $fetchProduk->supplier_id,
            'kategori_id' => $fetchProduk->kategori_id,
            'kode' => $fetchProduk->kode,
            'nama' => $fetchProduk->nama,
            'harga_per_qty' => floatval($fetchProduk->harga_per_qty),
            'satuan' => $fetchProduk->satuan
        ];

        if(empty($produkDetail)) {
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Kategori Tidak Ditemukan!'
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'produk_detail' => $produkDetail
        ]);
    }

    public function addProduk(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'kategori_id' => 'required',
            'harga_per_qty' => 'required',
            'satuan' => 'required'
        ]);

        $addProduk = Produk::insert([
                'supplier_id' => $request->supplier_id,
                'kode' => $request->kode,
                'nama' => $request->nama,
                'kategori_produk_id' => $request->kategori_id,
                'harga_per_qty' => $request->harga_per_qty,
                'satuan' => $request->satuan,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $addProduk ? 'OK' : 'FAIL',
            'message' => $addProduk ? 'Berhasil Menambah Data!' : 'Gagal Menambah Data!'
        ]);
    }

    public function editProduk(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'supplier_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'kategori_id' => 'required',
            'harga_per_qty' => 'required',
            'satuan' => 'required'
        ]);

        $editProduk = Produk::where('id', $request->produk_id)
            ->update([
                'supplier_id' => $request->supplier_id,
                'kode' => $request->kode,
                'nama' => $request->nama,
                'kategori_produk_id' => $request->kategori_id,
                'harga_per_qty' => $request->harga_per_qty,
                'satuan' => $request->satuan,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $editProduk ? 'OK' : 'FAIL',
            'message' => $editProduk ? 'Berhasil Mengubah Data!' : 'Gagal Mengubah Data!'
        ]);
    }

    public function deleteProduk(Request $request)
    {
        $request->validate([
            'produk_id' => 'required'
        ]);

        $deleteProduk = Produk::where('id', $request->produk_id)->delete();

        return response()->json([
            'status' => $deleteProduk ? 'OK' : 'FAIL',
            'message' => $deleteProduk ? 'Berhasil Menghapus Data!' : 'Gagal Menghapus Data!'
        ]);
    }

    public function searchProduks(Request $request)
    {
        $search_query = $request->input('q') ?? '';
        $search_limit = $request->input('l') ?? 5;
        $fetchProduk = Produk::select('id', 'kode', 'nama', 'supplier_id', 'harga_per_qty')
            ->where(DB::raw('lower(nama)'), 'like', '%' . strtolower($search_query) . '%');
        if ($request->input('s')) {
            $fetchProduk = $fetchProduk->where('supplier_id', intval($request->input('s')));
        }
        $fetchProduk = $fetchProduk->limit($search_limit)->get();
        return response()->json($fetchProduk);
    }
}
