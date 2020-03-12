<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    protected $table = 'sub_districts';

    public static function getSubDistrictByDistrict($district = "%")
    {
        return \DB::Table('sub_districts')->Distinct()
            ->Where('district_id', "LIKE", "%" . $district . "%")
            ->OrderBy('id')
            ->take(100)->get();
    }
}
