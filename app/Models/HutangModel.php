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
        'supplier_id',
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
        return $this->belongsTo(ReceiveHeadModel::class, 'receive_id', 'id');
    }

    public function get_supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'id');
    }
}
