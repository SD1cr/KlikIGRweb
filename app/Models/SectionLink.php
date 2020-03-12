<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionLink extends Model
{
    protected $table ='section_links';

    public static function getLinkSection($ID){
        return SectionLink::Distinct()
            ->Where('h_id', $ID)
            ->Get();
    }
}
