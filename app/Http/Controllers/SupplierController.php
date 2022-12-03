<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplierList = Supplier::select('id', 'kode', 'nama', 'telepon', 'alamat')
            ->orderBy('updated_at', 'DESC')
            ->paginate(10);

        return view('supplier.index', compact('supplierList'));
    }

    public function getSupplierDetail(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required'
        ]);

        $supplierDetail = Supplier::select('id', 'kode', 'nama', 'telepon', 'alamat')
            ->where('id', $request->supplier_id)
            ->first();

        if(empty($supplierDetail)) {
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Kategori Tidak Ditemukan!'
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'supplier_detail' => $supplierDetail
        ]);
    }

    public function addSupplier(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ]);

        $addSupplier = Supplier::insert([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $addSupplier ? 'OK' : 'FAIL',
            'message' => $addSupplier ? 'Berhasil Menambah Data!' : 'Gagal Menambah Data!'
        ]);
    }

    public function editSupplier(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ]);

        $editSupplier = Supplier::where('id', $request->supplier_id)
            ->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'telepon' => $request->telepon,
                'alamat' => $request->alamat,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $editSupplier ? 'OK' : 'FAIL',
            'message' => $editSupplier ? 'Berhasil Mengubah Data!' : 'Gagal Mengubah Data!'
        ]);
    }

    public function deleteSupplier(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required'
        ]);

        $deleteSupplier = Supplier::where('id', $request->supplier_id)->delete();

        return response()->json([
            'status' => $deleteSupplier ? 'OK' : 'FAIL',
            'message' => $deleteSupplier ? 'Berhasil Menghapus Data!' : 'Gagal Menghapus Data!'
        ]);
    }
}
