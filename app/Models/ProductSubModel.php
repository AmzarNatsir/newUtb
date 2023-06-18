<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSubModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "common_product_sub";
    protected $fiilable = [
        'head_id',
        'kode',
        'nama_produk',
        'harga_toko',
        'harga_eceran',
        'gambar',
        'keterangan'
    ];

    public function get_product()
    {
        return $this->belongsTo(ProductModel::class, 'head_id', 'id');
    }
}
