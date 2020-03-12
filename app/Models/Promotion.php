<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    public static function getListPromoAll(){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        return Promotion::Distinct()
            ->Selectraw('promotions.id as idpromo, image, start_date, end_date, promotion_code')
            ->leftJoin('promotion_branches', 'promotions.id', '=', 'promotion_branches.promotion_id')
            ->leftJoin('branches', 'branches.id', '=', 'promotion_branches.branch_id')
            ->where('flag_active', 1)
            ->where(\DB::raw('DATE(start_date)'), '<=', Carbon::today())
            ->where(\DB::raw('DATE(end_date)'), '>=',Carbon::today())
            ->where('kode_igr', $kodecabang)
            ->get();
    }


    public static function getViewPromo($detailID){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        return Promotion::Distinct()
            ->leftJoin('promotion_branches', 'promotions.id', '=', 'promotion_branches.promotion_id')
//            ->leftJoin('promotion_links', 'promotions.id', '=', 'promotion_links.promotion_id')
            ->leftJoin('branches', 'branches.id', '=', 'promotion_branches.branch_id')
            ->where('flag_active', 1)
            ->where(\DB::raw('DATE(start_date)'), '<=', Carbon::today())
            ->where(\DB::raw('DATE(end_date)'), '>=',Carbon::today())
            ->where('kode_igr', $kodecabang)
            ->Where('promotions.id', $detailID)
            ->get();
    }

    public static function getLinkPromo($detailID, $linktype){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        $varPromo = Promotion::Distinct()
//            ->Selectraw('promotions.id as idpromo, link_type, link_id')
            ->leftJoin('promotion_branches', 'promotions.id', '=', 'promotion_branches.promotion_id')
            ->leftJoin('promotion_links', 'promotions.id', '=', 'promotion_links.promotion_id')
            ->leftJoin('branches', 'branches.id', '=', 'promotion_branches.branch_id');
        if($linktype == 1) {
            $varPromo->Join('divisions', 'divisions.id', '=', 'link_id');
        }elseif($linktype == 2){
            $varPromo->Join('departments', 'departments.id', '=', 'link_id');
        }else{
            $varPromo->Join('categories', 'categories.id', '=', 'link_id');
        }
        $varPromo = $varPromo->where('flag_active', 1)
            ->where('flag_active', 1)
            ->where(\DB::raw('DATE(start_date)'), '<=', Carbon::today())
            ->where(\DB::raw('DATE(end_date)'), '>=',Carbon::today())
            ->where('kode_igr', $kodecabang)
            ->Where('promotions.id', $detailID)
            ->get();

        return $varPromo;
    }


    public static function getLinkKeteranganPromo($detailID)
    {
        if (\Auth::guest()) {
            $kodecabang = '18';
        } else {
            $kodecabang = Branch::getBranches();
        }

        return Promotion::Distinct()
            ->leftJoin('promotion_branches', 'promotions.id', '=', 'promotion_branches.promotion_id')
            ->leftJoin('promotion_links', 'promotions.id', '=', 'promotion_links.promotion_id')
            ->leftJoin('branches', 'branches.id', '=', 'promotion_branches.branch_id')
            ->where('flag_active', 1)
            ->where(\DB::raw('DATE(start_date)'), '<=', Carbon::today())
            ->where(\DB::raw('DATE(end_date)'), '>=', Carbon::today())
            ->where('kode_igr', $kodecabang)
            ->Where('promotions.id', $detailID)
            ->get();
    }


    public static function getProductPromo($linkid, $linktype)
    {

        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        $var = ProductView::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('product_views.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
            });
             $var->leftJoin('kategori_oracle', function ($join) {
                 $join->on('KAT_KODEDEPARTEMENT', '=', 'product_views.kode_department');
                 $join->on('KAT_KODEKATEGORI', '=', 'product_views.kode_category');
             });
        $var->Where('product_views.kode_igr', $kodecabang)
            ->leftJoin('category_kategorioracle', 'kategori_oracle.id', '=', 'category_kategorioracle.kategori_oracle_id')
            ->leftJoin('categories', 'category_kategorioracle.category_id', '=', 'categories.id')
            ->Join('departments', 'categories.department_id', '=', 'departments.id')
            ->Join('divisions', 'departments.division_id', '=', 'divisions.id');

            if($linktype == 1) {
                $var->Where('divisions.id', $linkid);
            }elseif($linktype == 2){
                $var->Where('departments.id',$linkid);
            }elseif($linktype == 3){
                $var->Where('categories.id', $linkid);
            }elseif($linktype == 4){
                $var->where('prdcd', $linkid);
            }else{
                $var->where('brg_merk', $linkid);
            }
            $var = $var->WhereRaw('(product_views.kode_division != \'3\' OR product_views.kode_department != \'42\' OR product_views.kode_category != \'02\')')
            ->take(8)->get();

        return $var;
    }
}
