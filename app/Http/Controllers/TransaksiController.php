<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiProduk;
use App\Models\TransaksiProdukLog;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = Transaksi::query();
        $supplierList = Supplier::all();
        $cabangList = Cabang::all();

        //todo index by permission
        //todo estimated red when exceed est date

        if ($user->inRole('supplier')) {
            if ($user->supplier) {
                $transactions = $transactions->where('supplier_id', $user->supplier->id);
            } else {
                return redirect(url('/'));
            }
        } else if($user->inRole('admin-cabang')) {
            if ($user->cabang_id) {
                $transactions = $transactions->where('cabang_id', $user->cabang_id);
            } else {
                return redirect(url('/'));
            }
        }

        $transactions = $transactions->orderBy('updated_at', 'DESC')->paginate(10);

        return view('transaksi.index', compact('transactions', 'supplierList', 'cabangList'));
    }

    public function getTransaksiDetail(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'transaksi_id' => 'required'
        ]);

        $transaksi = Transaksi::with('transaksi_produks');

        if ($user->inRole('supplier')) { //prevent supplier to get other's Transaction
            if ($user->supplier && $user->supplier->id) {
                $transaksi = $transaksi->where('supplier_id', $user->supplier->id);
            } else {
                return response()->json([
                    'status' => 'FAIL',
                    'message' => 'Transasksi Tidak Ditemukan!'
                ]);
            }
        }

        if(empty($transaksi)) {
            return response()->json([
                'status' => 'FAIL',
                'message' => 'Transasksi Tidak Ditemukan!'
            ]);
        }

        $transaksi = $transaksi->find($request->transaksi_id)->append(['total', 'subtotal']);

        return response()->json([
            'status' => 'OK',
            'transaksi_detail' => $transaksi->toArray()
        ]);
    }

    public function addTransaksi(Request $request)
    {
        $user = Auth::user();

        $validates = [
            // 'order_code' => 'required',
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
            // 'order_code' => $request->input('order_code'),
            'order_code' => 'TRX-'.date('ymd').rand(0000, 9999),
            'supplier_id' => $request->input('supplier_id'),
            'cabang_id' => $request->input('cabang_id'),
            'maker_id' => $user->id,
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
            $sub_total += (intval($product->harga_per_qty) * intval($productList[$product->id]["qty"]));
            $new_products[] = [
                "transaksi_id" => $transaksi->id,
                "produk_id" => $product->id,
                "qty" => intval($productList[$product->id]["qty"]),
                "locked_price" => intval($product->harga_per_qty),
                "locked_total" => (intval($product->harga_per_qty) * intval($productList[$product->id]["qty"]))
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

    public function approve($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->update(['status' => 1]);

        return response()->json([
            'status' => 'OK',
            'message' => 'Berhasil Mengubah Data!'
        ]);
    }

    public function reject($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->update(['status' => 2]);

        return response()->json([
            'status' => 'OK',
            'message' => 'Berhasil Mengubah Data!'
        ]);
    }

    public function ship($id)
    {
        $user = Auth::user();
        if ($user->supplier) {
            $transaksi = Transaksi::find($id);
            $transaksi->update(['status' => 3]);
        }

        return response()->json([
            'status' => 'OK',
            'message' => 'Berhasil Mengubah Data!'
        ]);
    }

    public function recieve(Request $request, $id)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::find($id);
            $transaksi->update([
                'status' => 4,
                'reciever_id' => $user->id,
                'recieved_at' => now()->toDateTimeString()
            ]);
            
            $transaksiProdukLogInsert = [];
            foreach($request->produk_retur_list as $produkRetur) {
                $transaksiProduk = TransaksiProduk::where('id', $produkRetur['transaksi_produk_id'])->first();

                if($produkRetur['qty_retur'] > 0) {
                    $qtyRetur = $produkRetur['qty_retur'];
                    if($qtyRetur > $transaksiProduk->qty) {
                        $qtyRetur = $transaksiProduk->qty;
                    }

                    $transaksiProdukLogInsert[] = [
                        'transaksi_produk_id' => $transaksiProduk->id,
                        'qty' => $transaksiProduk->qty-$qtyRetur,
                        'status' => 'STOK',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $transaksiProdukLogInsert[] = [
                        'transaksi_produk_id' => $transaksiProduk->id,
                        'qty' => $qtyRetur,
                        'status' => 'RETUR',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                } else {
                    $transaksiProdukLogInsert[] = [
                        'transaksi_produk_id' => $transaksiProduk->id,
                        'qty' => $transaksiProduk->qty,
                        'status' => 'STOK',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            }

            TransaksiProdukLog::insert($transaksiProdukLogInsert);
            DB::commit();
            return response()->json([
                'status' => 'OK',
                'message' => 'Berhasil Mengubah Data!'
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'OK',
                'message' => 'Gagal Mengubah Data!'
            ]);
        }
    }

    public function delete($id)
    {
        $user = Auth::user();
        $transaksi = Transaksi::find($id);
        if ($transaksi && ($user->InRole("admin|admin-cabang"))) {
            $transaksi->delete();
            return response()->json([
                'status' => 'OK',
                'message' => 'Berhasil Menghapus Data!'
            ]);
        }
        return response()->json([
            'status' => 'FAIL',
            'message' => 'Gagal Menghapus Data!'
        ]);
    }
}
