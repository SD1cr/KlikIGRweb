<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = "departments";

//    public static function getDepByDivisi($divisi)
//    {
//        return Department::Distinct()
//            ->Select('DEP_KODEDIVISI', 'DEP_NAMADEPARTEMENT', 'DEP_KODEDEPARTEMENT')
//            ->Where('DEP_KODEDEPARTEMENT', '<>', 23)
//            ->Where('DEP_KODEDIVISI', $divisi)
//            ->Get();
//    }
//
//    public static function  getDepNama($div, $dep){
//        return Department::Distinct()
//            ->Select('DEP_KODEDIVISI', 'DEP_NAMADEPARTEMENT', 'DEP_KODEDEPARTEMENT')
//            ->Where('DEP_KODEDEPARTEMENT', '<>', 23)
//            ->Where('DEP_KODEDIVISI', $div)
//            ->Where('DEP_KODEDEPARTEMENT', $dep)
//            ->First()->DEP_NAMADEPARTEMENT;
//    }

    public static function  getDepNama($div, $dep)
    {
        try {
            return Department::Distinct()
                ->Select('division_id', 'department', 'id')
                ->Where('division_id', $div)
                ->Where('id', $dep)
                ->WhereNull('deleted_at')
                ->First()->department;
        } catch (\Exception $ex) {
            return "Non Department";
        }
    }

    public static function getDepByDivisi($divisi)
    {
        return Department::Distinct()
            ->Select('id', 'division_id', 'department','images', 'priority')
            ->Where('division_id', $divisi)
            ->WhereNull('deleted_at')
            ->OrderBy('priority','asc')
            ->Get();
    }

    public static function getDepPromotion($dep)
    {
        return Department::Distinct()
            ->Where('id', $dep)
            ->Pluck('division_id');
    }
}
