<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PODetailModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'po_detail';
    protected $fillable = [
        'head_id',
        'produk_id',
        'qty',
        'harga',
        'sub_total',
        'status_item',
        'diskitem_persen',
        'diskitem_rupiah'
    ];

    public function get_produk()
    {
        return $this->belongsTo(ProductModel::class, 'produk_id', 'id');
    }
}
