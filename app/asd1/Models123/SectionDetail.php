<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionDetail extends Model
{
    protected $table ='section_details';

    public static function getDetailSection($ID){
        return SectionDetail::Distinct()
            ->Where('h_id', $ID)
            ->OrderBy('priority', 'asc')  
            ->Get();
    }
}
