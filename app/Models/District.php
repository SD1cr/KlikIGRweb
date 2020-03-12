<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    public static function getDistrictByCity($city = "%")
    {
        return \DB::Table('districts')->Distinct()
            ->Where('city_id', "LIKE", "%" . $city . "%")
            ->OrderBy('district_code')
            ->Get();
    }
}
