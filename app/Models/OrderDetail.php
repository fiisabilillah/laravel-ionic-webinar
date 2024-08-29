<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'barang_id',
        'order_id',
        'jumlah',
        'jumlah_harga',
    ];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_id', 'id');
    }

    public function Order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }
}
