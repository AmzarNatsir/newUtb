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
        'approved_2', //NULL : belum di approve, 1. Approved
        'approved_by_2',
        'approved_date_2',
        'approved_note_2',
        'status_approval',
        'tgl_transaksi',
        'via_id',
        'status_piutang'
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

    public function get_approver_1()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function get_approver_2()
    {
        return $this->belongsTo(User::class, 'approved_by_2', 'id');
    }

    public function get_return_jual_sum_qty($id)
    {
        $total_qty_return = \DB::table('jual_head')
                    ->join('return_jual_head', 'return_jual_head.jual_id', '=', 'jual_head.id')
                    ->join('return_jual_detail', 'return_jual_detail.head_id', '=', 'return_jual_head.id')
                    ->where('jual_head.id', $id)
                    ->selectRaw('sum(return_jual_detail.qty) as t_qty')
                    ->pluck('t_qty')->first();

        return $total_qty_return;
    }
    public function get_return_jual_sum_total($id)
    {
        $total_harga_return = \DB::table('jual_head')
                    ->join('return_jual_head', 'return_jual_head.jual_id', '=', 'jual_head.id')
                    ->join('return_jual_detail', 'return_jual_detail.head_id', '=', 'return_jual_head.id')
                    ->where('jual_head.id', $id)
                    ->selectRaw('sum(return_jual_detail.qty * return_jual_detail.harga) as t_harga')
                    ->pluck('t_harga')->first();

        return $total_harga_return;
    }
}
