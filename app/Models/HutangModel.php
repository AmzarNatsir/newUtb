<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HutangModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "hutang";
    protected $fillable = [
        'no_bayar',
        'tgl_bayar',
        'receive_id',
        'metode_bayar',
        'nominal',
        'keterangan',
        'file_evidence',
        'flag',
        'user_id'
    ];

    public function get_receive()
    {
        return $this->hasMany(ReceiveHeadModel::class, 'receive_id', 'id');
    }
}
