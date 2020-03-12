<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    public static function getCityByProv($prov = "%")
    {
        return \DB::Table('cities')->Distinct()
            ->Where('province_id', "LIKE", "%" . $prov . "%")
            ->OrderBy('city_code')
            ->Get();
    }
}
