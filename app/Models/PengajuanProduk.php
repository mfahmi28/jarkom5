<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanProduk extends Model
{
    use HasFactory;

    public $table = 'pengajuan_produk';
    protected $primaryKey = 'id';
}
