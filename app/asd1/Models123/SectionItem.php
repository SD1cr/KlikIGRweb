<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionItem extends Model
{
    protected $table ='section_items';

    public static function getItemSection($DetailID){
        return SectionItem::Distinct()
            ->Where('d_id', $DetailID)
            ->OrderBy('priority', 'asc')    
            ->Get();
    }
}
