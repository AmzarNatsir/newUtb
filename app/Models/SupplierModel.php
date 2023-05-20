<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'common_supplier';
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'email',
        'no_telepon',
        'kontak_person'
    ];

    
}
