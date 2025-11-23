<?php

namespace Modules\MSync\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\MSync\Database\Factories\IdentitasSyncFactory;

class IdentitasSync extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'identitas_syncs';

    protected $fillable = [
        'nama',
        'nim',
        'prodi',
        'fakultas',
        'universitas',
    ];

    protected $casts = [
        
    ];

    // protected static function newFactory(): IdentitasSyncFactory
    // {
    //     // return IdentitasSyncFactory::new();
    // }
}
