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
        'customer_id',
        'jual_id',
        'metode_bayar',
        'via_id',
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

    public function get_customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id', 'id');
    }

    public function get_via()
    {
        return $this->BelongsTo(ViaModel::class, 'via_id', 'id');
    }
    
}
