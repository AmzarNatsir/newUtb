<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JualDetailModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'jual_detail';
    protected $fillable = [
        'head_id',
        'produk_id',
        'qty',
        'harga',
        'sub_total',
        'diskitem_persen',
        'diskitem_rupiah',
        'sub_total_net',
        'status_item'
    ];

    public function get_produk()
    {
        return $this->belongsTo(ProductModel::class, 'produk_id', 'id');
    }
}
