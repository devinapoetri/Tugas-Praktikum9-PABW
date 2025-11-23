<?php

namespace Modules\Mahasiswa\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Modules\Mahasiswa\Database\Factories\IdentitasFactory;

class Identitas extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama',
        'nim',
        'prodi',
        'fakultas',
        'universitas',
    ];

    // protected static function newFactory(): IdentitasFactory
    // {
    //     // return IdentitasFactory::new();
    // }
}
