<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'user_id',
        'jenis_jual', //NULL: penjualan, 1. pemberian sample
        'approved', //NULL : belum di approve, 1. Approved
        'approved_by',
        'approved_date',
        'approved_note',
        'tgl_transaksi',
        'via_id'
    ];

    public function get_customer()
    {
        return $this->belongsTo(CustomerModel::class, 'customer_id', 'id');
    }

    public function get_detail()
    {
        return $this->hasMany(JualDetailModel::class, 'head_id', 'id');
    }

    public function get_via()
    {
        return $this->BelongsTo(ViaModel::class, 'via_id', 'id');
    }

    public function get_piut_terbayar($id)
    {
        $total_terbayar_invoice = \DB::table('piutang')
                ->where('piutang.jual_id', $id)
                ->whereNull('piutang.deleted_at')
                ->selectRaw('sum(piutang.nominal) as t_nominal')
                ->pluck('t_nominal')->first();

        return $total_terbayar_invoice;
    }
}
