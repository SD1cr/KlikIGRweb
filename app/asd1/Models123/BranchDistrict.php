<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchDistrict extends Model
{
    protected $table = 'branch_sub_districts';

    public static function getDistrictByBranch($district = "%")
    {
        return \DB::Table('branch_sub_districts')->Distinct()
            ->Where('sub_district_id', "LIKE", "%" . $district . "%")
            ->OrderBy('id')
            ->Get();
    }
}
