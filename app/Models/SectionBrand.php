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

    public static function getBrandSectionPriority(){
        return SectionBrand::Distinct()
            ->where('priority', 1)
            ->take(8)
            ->Get();
    }
}
