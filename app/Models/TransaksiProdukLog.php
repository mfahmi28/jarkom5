<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiProdukLog extends Model
{
    use HasFactory;

    public $table = 'transaksi_produk_log';
    protected $primaryKey = 'id';
}
