<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    public static function getAllProvince()
    {
        return \DB::Table('provinces')->Distinct()
            ->OrderBy('province_code')
            ->Get();
    }
}
