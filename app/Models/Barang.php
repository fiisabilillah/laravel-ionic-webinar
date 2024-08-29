<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barang',
        'harga',
        'stok',
        'keterangan',
        'gambar',
        'gambar2',
    ];
    protected $casts = [
        'gambar2' => 'array',
    ];

    public function OrderDetail()
	{
	     return $this->hasMany('App\Models\OrderDetail','barang_id', 'id');
	}
}
