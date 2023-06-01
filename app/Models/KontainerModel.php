<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KontainerModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'common_kontainer';
    protected $fillable = [
        'nama_kontainer',
        'alamat',
        'email',
        'no_telepon',
        'kontak_person'
    ];
}
