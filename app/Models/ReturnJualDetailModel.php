<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnJualDetailModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "return_jual_detail";
    protected $fillabel = [
        'head_id',
        'produk_id',
        'qty',
        'harga',
        'sub_total'
    ];

    public function get_produk()
    {
        return $this->belongsTo(ProductModel::class, 'produk_id', 'id');
    }
}
