<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Produk;
use App\Models\Transaksi;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * View Users List
     *
     **/
    public function index()
    {
        $transactions = Transaksi::query()->orderBy('updated_at', 'DESC')->paginate(10);
        $supplierList = Supplier::all();
        $cabangList = Cabang::all();

        return view('transaksi.index', compact('transactions', 'supplierList', 'cabangList'));
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

    public function addTransaksi(Request $request)
    {
        $validates = [
            'order_code' => 'required',
            'supplier_id' => 'required|exists:suppliers,id',
            'cabang_id' => 'required|exists:cabang,id',
            'description' => 'required|string',
            'estimated_date' => 'required|date|after:today',
            'produk_list' => 'required',
            'produk_list.*.id' => 'required|exists:produk,id',
            'produk_list.*.qty' => 'required|integer|min:1',
        ];

        $request->validate($validates);

        $transaksi = Transaksi::create([
            'status' => 0,
            'order_code' => $request->input('order_code'),
            'supplier_id' => $request->input('supplier_id'),
            'cabang_id' => $request->input('cabang_id'),
            'maker_id' => Auth::user()->id,
            'description' => $request->input('description'),
            'tax' => Transaksi::DEFAULT_TAX,
            // 'sort_subtotal' => $request->input('order_code'),
            'estimated_date' => Carbon::now()->addDays(Transaksi::EXPIRED_DAYS)->toDateString(),
            'expired_date' => Carbon::now()->addDays(Transaksi::EXPIRED_DAYS)->toDateString(),
        ]);

        $productList = $request->get("produk_list");
        $productsId = array_map(function ($v) { return $v['id']; }, $productList);
        $products = Produk::whereIn('id', $productsId)->get();

        $sub_total = Transaksi::DEFAULT_TAX;
        $new_products = [];
        foreach ($products as $product) {
            $sub_total += (intval($product->harga) * intval($productList[$product->id]["qty"]));
            $new_products[] = [
                "transaksi_id" => $transaksi->id,
                "produk_id" => $product->id,
                "qty" => intval($productList[$product->id]["qty"]),
                "locked_price" => intval($product->harga),
                "locked_total" => (intval($product->harga) * intval($productList[$product->id]["qty"]))
            ];
        }

        $transaksi->transaksi_produks()->createMany($new_products);
        $transaksi->sort_subtotal = $sub_total;
        $transaksi->save();

        return response()->json([
            'status' => $transaksi ? 'OK' : 'FAIL',
            'message' => $transaksi ? 'Berhasil Menambah Data!' : 'Gagal Menambah Data!'
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
