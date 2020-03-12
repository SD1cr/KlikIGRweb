<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionItem extends Model
{
    protected $table ='section_items';

    public static function getItemSection($DetailID){
        return SectionItem::Distinct()
            ->Where('d_id', $DetailID)
            ->take(4)
            ->Get();
    }

    public static function getItemSectionPlu($DetailID){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
        return SectionItem::Distinct()
            ->leftJoin('product_views', 'prdcd', '=', 'kodeplu')
            ->LeftJoin('ms_picture_productnew', function ($join) {
                $join->on('product_views.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
            })
            ->Where('d_id', $DetailID)
            ->where('kode_igr', $kodecabang)
            ->Get();
    }
}
