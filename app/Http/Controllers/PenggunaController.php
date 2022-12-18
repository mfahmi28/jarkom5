<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Cabang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    /**
     * View Users List
     *
     **/
    public function index()
    {
        $users = User::query()->orderBy('updated_at', 'DESC')->paginate(10);
        $roles = Role::all();
        $supplierList = Supplier::all();
        $cabangList = Cabang::all();

        return view('pengguna.index', compact('users', 'roles', 'supplierList', 'cabangList'));
    }

    public function getUserDetail(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required'
        ]);

        $user = User::query()
            ->find($request->pengguna_id);

        if(empty($user)) {
            return response()->json([
                'status' => 'FAIL',
                'message' => 'User Tidak Ditemukan!'
            ]);
        }

        return response()->json([
            'status' => 'OK',
            'user_detail' => $user->toArray()
        ]);
    }

    public function addUser(Request $request)
    {
        $validates = [
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|alpha_num',
            'password' => 'required|alpha_num',
            'role_id' => 'required|exists:roles,id'
        ];

        if($request->role_id == 3) {
            $validates['supplier_id'] = 'required';
        } else if($request->role_id == 4) {
            $validates['cabang_id'] = 'required';
        }

        $request->validate($validates);

        $addUser = User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'username' => Str::lower($request->username),
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'cabang_id' => !empty($request->cabang_id) ? $request->cabang_id : null,
                'supplier_id' => !empty($request->supplier_id) ? $request->supplier_id : null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => $addUser ? 'OK' : 'FAIL',
            'message' => $addUser ? 'Berhasil Menambah Data!' : 'Gagal Menambah Data!'
        ]);
    }

    public function editUser(Request $request)
    {
        $validates = [
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|alpha_num',
            'password' => 'nullable|alpha_num',
            'role_id' => 'required|exists:roles,id',
            'pengguna_id' => 'required|exists:users,id'
        ];

        if($request->role_id == 3) {
            $validates['supplier_id'] = 'required';
        } else if($request->role_id == 4) {
            $validates['cabang_id'] = 'required';
        }

        $request->validate($validates);

        $updates = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => Str::lower($request->username),
            'role_id' => $request->role_id,
            'cabang_id' => !empty($request->cabang_id) ? $request->cabang_id : null,
            'supplier_id' => !empty($request->supplier_id) ? $request->supplier_id : null
        ];

        if ($request->password && !empty($request->password)) {
            $updates['password'] = bcrypt($request->password);
        }

        $editUser = User::find($request->pengguna_id)->update($updates);

        return response()->json([
            'status' => $editUser ? 'OK' : 'FAIL',
            'message' => $editUser ? 'Berhasil Mengubah Data!' : 'Gagal Mengubah Data!'
        ]);
    }

    public function deleteUser(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:users,id'
        ]);

        $deleteUser = User::find($request->pengguna_id)->delete();

        return response()->json([
            'status' => $deleteUser ? 'OK' : 'FAIL',
            'message' => $deleteUser ? 'Berhasil Menghapus Data!' : 'Gagal Menghapus Data!'
        ]);
    }
}
