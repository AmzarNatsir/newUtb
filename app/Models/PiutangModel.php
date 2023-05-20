<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PiutangModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "piutang";
    protected $fillable = [
        'no_bayar',
        'tgl_bayar',
        'jual_id',
        'metode_bayar',
        'nominal',
        'keterangan',
        'file_evidence',
        'flag',
        'user_id'
    ];

    public function get_penjualan()
    {
        return $this->hasMany(JualHeadModel::class, 'jual_id', 'id');
    }
}
