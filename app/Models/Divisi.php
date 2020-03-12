<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mockery\CountValidator\Exception;

class Divisi extends Model
{
    protected $table = "divisions";

//    public static function getAllDivisi()
//    {
//        return Divisi::Distinct()
//            ->Select('DIV_NAMADIVISI', 'DIV_KODEDIVISI', 'color', 'banner', 'icon','url')
//            ->Get();
//    }

    public static function getAllDivisi()
    {
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }
        $div = Divisi::Distinct()
            ->Selectraw('id, division, color, CONCAT(\'https://klikigrsim.mitraindogrosir.co.id/image/\',images) as images ,priority')
            ->WhereNull('deleted_at');
        if(\Auth::guest() || $typeuserid == 1 || $typeuserid == 3) {
            $div->where('division', 'NOT LIKE', '%Rokok%');
        }
        $div = $div->OrderBy('priority','asc')
            ->Get();

        return $div;
    }
//
    public static function getDivNama($div)
    {
        try {
            return Divisi::Distinct()
                ->Select('division', 'id')
                ->WhereNull('deleted_at')
                ->Where('id', $div)
                ->First()->division;
        }catch(\Exception $ex){
            return "Non Divisi";
        }
    }

//    public static function getDivNama($div)
//    {
//        return Divisi::Distinct()
//            ->Select('DIV_NAMADIVISI', 'DIV_KODEDIVISI')
//            ->Where('DIV_KODEDIVISI', $div)
//            ->First()->DIV_NAMADIVISI;
//    }


}
