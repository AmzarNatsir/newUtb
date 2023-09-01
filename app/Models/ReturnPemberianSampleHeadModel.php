<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnPemberianSampleHeadModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "return_pemberian_sample_head";
    protected $fillabel = [
        'no_return',
        'tgl_return',
        'jual_id',
        'total_qty',
        'keterangan',
        'user_id'
    ];

    public function get_detail()
    {
        return $this->hasMany(ReturnJualDetailModel::class, 'head_id', 'id');
    }

    public function get_invoice()
    {
        return $this->belongsTo(JualHeadModel::class, 'jual_id', 'id');
    }
}
