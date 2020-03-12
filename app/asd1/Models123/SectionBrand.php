<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionBrand extends Model
{
    protected $table ='section_brands';

    public static function getBrandSection($ID){
        return SectionBrand::Distinct()
            ->Where('h_id', $ID)
            ->OrderBy('priority')
            ->Get();
    }
}
