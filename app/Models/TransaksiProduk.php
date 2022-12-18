<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiProduk extends Model
{
    use HasFactory;

    public $table = 'transaksi_produk';
    protected $primaryKey = 'id';

    // 'locked_price' => Price when Rejected/Approved
    // 'locked_total' => Price when Rejected/Approved

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'qty',
        'locked_price',
        'locked_total',
        'transaksi_id',
        'produk_id',
    ];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * Get the produk that owns the TransaksiProduk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    /**
     * Get simulated actual Price for this date and time
     *
     **/
    public function getActualPriceAttribute()
    {
        return ($this->produk->harga_per_qty);
    }

    /**
     * Get simulated actual Price for this date and time
     *
     **/
    public function getActualTotalAttribute()
    {
        return ($this->produk->harga_per_qty * $this->qty);
    }


}
