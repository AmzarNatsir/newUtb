<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerkModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "common_merk";
    protected $fillable = [
        'merk'
    ];
    
}
