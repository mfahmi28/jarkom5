<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    public function index()
    {
        $cabangList = Cabang::select('id', 'kode', 'nama', 'telepon', 'alamat')
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('cabang.index', compact('cabangList'));
    }

    public function getCabangDetail(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required'
        ]);

        $cabangDetail = Cabang::select('id', 'kode', 'nama', 'telepon', 'alamat')
            ->where('id', $request->cabang_id)
            ->first();

        if(empty($cabangDetail)) {
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Kategori Tidak Ditemukan!'
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'cabang_detail' => $cabangDetail
        ]);
    }

    public function addCabang(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ]);

        $addCabang = Cabang::insert([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $addCabang ? 'OK' : 'FAIL',
            'message' => $addCabang ? 'Berhasil Menambah Data!' : 'Gagal Menambah Data!'
        ]);
    }

    public function editCabang(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ]);

        $editCabang = Cabang::where('id', $request->cabang_id)
            ->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $editCabang ? 'OK' : 'FAIL',
            'message' => $editCabang ? 'Berhasil Mengubah Data!' : 'Gagal Mengubah Data!'
        ]);
    }

    public function deleteCabang(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required'
        ]);

        $deleteCabang = Cabang::where('id', $request->cabang_id)->delete();

        return response()->json([
            'status' => $deleteCabang ? 'OK' : 'FAIL',
            'message' => $deleteCabang ? 'Berhasil Menghapus Data!' : 'Gagal Menghapus Data!'
        ]);
    }
}