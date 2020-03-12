<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

//    public static function getKatByDep($department)
//    {
//        return Category::Distinct()
//            ->SelectRaw('case when category is null then `KAT_NAMAKATEGORI` else category end as nama, categories.id, department_id, categories.priority,categories.images ')
//            ->leftJoin('departments', 'departments.id', '=', 'categories.department_id')
//            ->leftJoin('category_kategorioracle', 'category_kategorioracle.category_id', '=', 'categories.department_id')
//            ->leftJoin('kategori_oracle', 'category_kategorioracle.kategori_oracle_id', '=', 'kategori_oracle.id')
//            ->Where('department_id', $department)
//            ->WhereNull('categories.deleted_at')
//            ->OrderBy('priority','asc')
//            ->Get();
//    }

    public static function getKatByDep($department)
    {
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }

        $cat = Category::Distinct()
            ->SelectRaw('case when category is null then `KAT_NAMAKATEGORI` else category end as nama,category, categories.id, department_id, categories.priority,categories.images ')
            ->leftJoin('departments', 'departments.id', '=', 'categories.department_id')
            ->leftJoin('category_kategorioracle', 'category_kategorioracle.category_id', '=', 'categories.department_id')
            ->leftJoin('kategori_oracle', 'category_kategorioracle.kategori_oracle_id', '=', 'kategori_oracle.id')
            ->Where('department_id', $department);
        if(\Auth::guest() || $typeuserid == 1 || $typeuserid == 3) {
            $cat->where('category', 'NOT LIKE', '%Make Up%');
        }
        $cat = $cat->WhereNull('categories.deleted_at')
            ->OrderBy('priority','asc')
            ->Get();

        return $cat;
    }      

    public static function getKatName($dep, $kat){
        try {
        return Category::Distinct()
            ->SelectRaw('case when category is null then `KAT_NAMAKATEGORI` else category end as nama, categories.id, department_id, categories.priority,categories.images ')
            ->leftJoin('departments', 'departments.id', '=', 'categories.department_id')
            ->leftJoin('category_kategorioracle', 'category_kategorioracle.category_id', '=', 'categories.department_id')
            ->leftJoin('kategori_oracle', 'category_kategorioracle.kategori_oracle_id', '=', 'kategori_oracle.id')
            ->WhereNull('categories.deleted_at')
            ->Where('department_id', $dep)->Where('categories.id', $kat)->First()->nama;
        } catch (\Exception $ex) {
            return "Non Category";
        }
    }



//    protected $table = "ms_kategori_oracle";
//
//
//    public static function getKatByDep($department)
//    {
//        return Category::Distinct()
//            ->SelectRaw('case when category is null then KAT_NAMAKATEGORI else category end as nama, DEP_KODEDIVISI,KAT_KODEDEPARTEMENT, KAT_KODEKATEGORI, KAT_NAMAKATEGORI')
//            ->leftJoin('ms_departemen_oracle', 'DEP_KODEDEPARTEMENT', '=', 'KAT_KODEDEPARTEMENT')
//            ->leftJoin('category_kategorioracle', 'ms_kategori_oracle.id', '=', 'category_kategorioracle.kategori_oracle_id')
//            ->leftJoin('categories', 'category_kategorioracle.category_id', '=', 'categories.id')
//            ->Where('KAT_KODEDEPARTEMENT', $department)
//            ->Get();
//    }
//
//    public static function getKatName($dep, $kat){
//        return Category::Distinct()
//            ->SelectRaw('case when category is null then KAT_NAMAKATEGORI else category end as nama, DEP_KODEDIVISI,KAT_KODEDEPARTEMENT, KAT_KODEKATEGORI, KAT_NAMAKATEGORI')
//            ->Where('KAT_KODEDEPARTEMENT', $dep)->Where('KAT_KODEKATEGORI', $kat)
//            ->leftJoin('ms_departemen_oracle', 'DEP_KODEDEPARTEMENT', '=', 'KAT_KODEDEPARTEMENT')
//            ->leftJoin('category_kategorioracle', 'ms_kategori_oracle.id', '=', 'category_kategorioracle.kategori_oracle_id')
//            ->leftJoin('categories', 'category_kategorioracle.category_id', '=', 'categories.id')->First()->nama;
//    }
}
