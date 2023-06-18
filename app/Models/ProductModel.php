<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "common_product";
    protected $fillabel = [
        'unit_id',
        'kode',
        'nama_produk',
        'kemasan',
        'harga_beli',
        'harga_toko',
        'harga_eceran',
        'gambar',
        'stok_awal',
        'stok_akhir',
        'merk_id',
        'keterangan'
    ];

    public function get_unit()
    {
        return $this->belongsTo(UnitModel::class, 'unit_id', 'id');
    }

    public function get_merk()
    {
        return $this->belongsTo(MerkModel::class, 'merk_id', 'id');
    }

    public function get_sub_produk()
    {
        return $this->hasMany(ProductSubModel::class, 'head_id', 'id');
    }
}
