<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnBeliHeadModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "return_beli_head";
    protected $fillabel = [
        'no_return',
        'tgl_return',
        'receive_id',
        'total_return',
        'keterangan',
        'user_id'
    ];

    public function get_detail()
    {
        return $this->hasMany(ReturnBeliDetailModel::class, 'head_id', 'id');
    }

    public function get_receive()
    {
        return $this->belongsTo(ReceiveHeadModel::class, 'receive_id', 'id');
    }
}
