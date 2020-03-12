<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SectionHeader extends Model
{
    protected $table = 'section_headers';

    public static function getSectionHeader(){
       return SectionHeader::Distinct()
//            ->leftJoin('section_membertype', 'section_headers.id', '=', 'section_membertype.section_id')->Where('type_id', $typeuserid)
            ->where('period_start', '<=', Carbon::today())
            ->where('period_end', '>=', Carbon::today())
            ->OrderBy('priority')
            ->Get();

    }
}
