<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class POHeadModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "po_head";
    protected $fillable = [
        'supplier_id',
        'nomor_po',
        'tanggal_po',
        'keterangan',
        'ppn_persen',
        'ppn_rupiah',
        'diskon_persen',
        'diskon_rupiah',
        'total_po',
        'status_po',
        'user_id'
    ];

    public function get_supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id', 'id');
    }
}
