<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SectionBanner extends Model
{
    protected $table ='section_banners';

    public static function getBannerSection($ID){
        return SectionBanner::Distinct()
            ->Where('h_id', $ID)
            ->OrderBy('priority', 'asc')
            ->Get();
    }
}
