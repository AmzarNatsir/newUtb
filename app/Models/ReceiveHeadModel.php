<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiveHeadModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "receive_head";
    protected $fillable = [
        'po_id',
        'supplier_id',
        'nomor_receive',
        'tanggal_receive',
        'keterangan',
        'ppn_persen',
        'ppn_rupiah',
        'diskon_persen',
        'diskon_rupiah',
        'total_receice',
        'total_receive_net',
        'cara_bayar',
        'no_invoice',
        'tgl_invoice',
        'user_id'
    ];

    public function get_supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'id');
    }

    public function get_detail()
    {
        return $this->hasMany(ReceiveDetailModel::class, 'head_id', 'id');
    }
}
