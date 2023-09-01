<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnPemberianSampleDetailModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "return_pemberian_sample_detail";
    protected $fillabel = [
        'head_id',
        'produk_id',
        'qty',
    ];

    public function get_produk()
    {
        return $this->belongsTo(ProductModel::class, 'produk_id', 'id');
    }
}
