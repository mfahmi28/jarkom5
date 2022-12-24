<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    public $table = 'transaksi';
    protected $primaryKey = 'id';

    public const DEFAULT_TAX = 1100;
    public const EXPIRED_DAYS = 40;

    public $status_names = [
        'Pending',
        'Approved',
        'Rejected',
        'Shipping',
        'Received',
    ];

    //!! 'sort_subtotal' FOR SORTING PURPOSE ONLY
    protected $fillable = [
        'status',
        'order_code',
        'tipe',
        'supplier_id',
        'cabang_id',
        'maker_id',
        'reciever_id',
        'description',
        'tax',
        'sort_subtotal',
        'estimated_date',
        'expired_date',
        'recieved_at',
        'order_code_ref',
        'created_at',
        'updated_at'
    ];

    public $appends = ['status_name'];

    /**
     * Get the supplier that owns the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Get the cabang that owns the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    /**
     * Get the maker that owns the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maker()
    {
        return $this->belongsTo(User::class, 'maker_id');
    }

    /**
     * Get the reciever that owns the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reciever()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }

    /**
     * Get all of the transaksi_produks for the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi_produks()
    {
        return $this->hasMany(TransaksiProduk::class, 'transaksi_id', 'id');
    }

    public function getStatusNameAttribute()
    {
        $r = "-";
        if ($this->status === 0) {
            $r = Carbon::now()->greaterThan($this->expired_date) ? "Expired" : "Pending";
        }else if(isset($this->status_names[$this->status])){
            $r = $this->status_names[$this->status] ;
        }
        return $r;
        // return (isset($this->status_names[$this->status]) ? $this->status_names[$this->status] : "-" );
    }

    // inactive attribute, use append/setAppends 'total' on query
    public function getTotalAttribute()
    {
        return $this->transaksi_produks()->sum('locked_total');
    }

    // inactive attribute, use append/setAppends 'subtotal' on query
    public function getSubTotalAttribute()
    {
        $t = $this->transaksi_produks()->sum('locked_total') ?? 0;
        return ($t + $this->tax);
    }
}
