<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategoriList = KategoriProduk::select('id', 'nama', 'keterangan')
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('kategori-produk.index', compact('kategoriList'));
    }

    public function getKategoriDetail(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required'
        ]);

        $kategoriDetail = KategoriProduk::select('id', 'nama', 'keterangan')
            ->where('id', $request->kategori_id)
            ->first();

        if(empty($kategoriDetail)) {
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Kategori Tidak Ditemukan!'
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'kategori_detail' => $kategoriDetail
        ]);
    }

    public function addKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $addKategori = KategoriProduk::insert([
            'nama' => $request->nama,
            'keterangan' => !empty($request->keterangan) ? $request->keterangan : null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
            'status' => $addKategori ? 'OK' : 'FAIL',
            'message' => $addKategori ? 'Berhasil Menambah Data!' : 'Gagal Menambah Data!'
        ]);
    }

    public function editKategori(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama' => 'required'
        ]);

        $editKategori = KategoriProduk::where('id', $request->kategori_id)
            ->update([
                'nama' => $request->nama,
                'keterangan' => !empty($request->keterangan) ? $request->keterangan : null,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $editKategori ? 'OK' : 'FAIL',
            'message' => $editKategori ? 'Berhasil Mengubah Data!' : 'Gagal Mengubah Data!'
        ]);
    }

    public function deleteKategori(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required'
        ]);

        $deleteKategori = KategoriProduk::where('id', $request->kategori_id)->delete();

        return response()->json([
            'status' => $deleteKategori ? 'OK' : 'FAIL',
            'message' => $deleteKategori ? 'Berhasil Menghapus Data!' : 'Gagal Menghapus Data!'
        ]);
    }
}
