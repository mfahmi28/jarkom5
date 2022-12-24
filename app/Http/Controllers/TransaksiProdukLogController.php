<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\TransaksiProdukLog;

class TransaksiProdukLogController extends Controller
{
    public function index()
    {
        $cabangId = Auth::user()->cabang_id ?? '';

        $transaksiProdukLogList = TransaksiProdukLog::select([
                'transaksi.order_code AS transaksi_kode',
                'produk.nama AS produk',
                'transaksi_produk_log.qty',
                'cabang.nama AS cabang_nama',
                'transaksi_produk_log.status'
            ])
            ->leftJoin('transaksi_produk', 'transaksi_produk.id', 'transaksi_produk_log.transaksi_produk_id')
            ->leftJoin('produk', 'produk.id', 'transaksi_produk.produk_id')
            ->leftJoin('transaksi', 'transaksi.id', 'transaksi_produk.transaksi_id')
            ->leftJoin('cabang', 'cabang.id', 'transaksi.cabang_id')
            ->when(!empty($cabangId), function($query) use($cabangId) {
                $query->where('transaksi.cabang_id', $cabangId);
            })
            ->orderBy('transaksi_produk_log.updated_at', 'DESC')
            ->paginate(10);

        $pagination = $transaksiProdukLogList->links('pagination::tailwind');

        return view('transaksi-produk-log.index', compact('transaksiProdukLogList', 'pagination'));
    }
}
