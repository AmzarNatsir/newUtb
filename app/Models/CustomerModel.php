<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'common_customer';
    protected $fillable = [
        'kode',
        'nama_customer',
        'alamat',
        'kota',
        'no_telepon',
        'level' //1. Customer, 2. Agent, 3. Reseller
    ];
}
