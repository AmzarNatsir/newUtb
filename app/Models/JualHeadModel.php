<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JualHeadModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "jual_head";
    protected $fillable = [
        'customer_id',
        'no_invoice',
        'tgl_invoice',
        'bayar_via',
        'tgl_jatuh_tempo',
        'keterangan',
        'total_invoice',
        'ppn_persen',
        'ppn_rupiah',
        'diskon_persen',
        'diskon_rupiah',
        'ongkir',
        'total_invoice_net',
        'status_invoice',
        'user_id'
    ];

    public function get_customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id', 'id');
    }

    public function get_detail()
    {
        return $this->hasMany(JualDetailModel::class, 'head_id', 'id');
    }
}
