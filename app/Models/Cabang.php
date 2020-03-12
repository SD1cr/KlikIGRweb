<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    public static function getAllCabang()
    {
        return Cabang::Distinct()
            ->Select('kode_cabang', 'nama_cabang')
            ->Get();
    }
}
