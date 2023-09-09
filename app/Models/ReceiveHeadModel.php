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
        'tgl_jatuh_tempo',
        'user_id',
        'invoice_kontainer',
        'nilai_kontainer',
        'tgl_tiba',
        'kontainer_id',
        'status_hutang',
        'status_hutang_kontainer'
    ];

    public function get_supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'id');
    }

    public function get_detail()
    {
        return $this->hasMany(ReceiveDetailModel::class, 'head_id', 'id');
    }

    public function get_kontainer()
    {
        return $this->belongsTo(KontainerModel::class, 'kontainer_id', 'id');
    }

    public function get_hut_terbayar($id)
    {
        $total_terbayar_invoice = \DB::table('hutang')
                    ->where('hutang.receive_id', $id)
                    ->whereNull('hutang.deleted_at')
                    ->selectRaw('sum(hutang.nominal) as t_nominal')
                    ->pluck('t_nominal')->first();

        return $total_terbayar_invoice;
    }

    public function get_return_beli_sum_qty($id)
    {
        $total_qty_return = \DB::table('receive_head')
                    ->join('return_beli_head', 'return_beli_head.receive_id', '=', 'receive_head.id')
                    ->join('return_beli_detail', 'return_beli_detail.head_id', '=', 'return_beli_head.id')
                    ->where('receive_head.id', $id)
                    ->selectRaw('sum(return_beli_detail.qty) as t_qty')
                    ->pluck('t_qty')->first();

        return $total_qty_return;
    }
    public function get_return_beli_sum_total($id)
    {
        $total_harga_return = \DB::table('receive_head')
                    ->join('return_beli_head', 'return_beli_head.receive_id', '=', 'receive_head.id')
                    ->join('return_beli_detail', 'return_beli_detail.head_id', '=', 'return_beli_head.id')
                    ->where('receive_head.id', $id)
                    ->selectRaw('sum(return_beli_detail.qty * return_beli_detail.harga) as t_harga')
                    ->pluck('t_harga')->first();

        return $total_harga_return;
    }
}
