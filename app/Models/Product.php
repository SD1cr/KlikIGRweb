<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    public static function getAllProduct($divisi, $department, $kategori, $ord = 25, $key, $merk = '%'){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }


        $var = Product::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
            })
            ->leftJoin('kategori_oracle', function ($join) {
                $join->on('KAT_KODEDEPARTEMENT', '=', 'products.kode_department');
                $join->on('KAT_KODEKATEGORI', '=', 'products.kode_category');
            })
//            ->leftJoin('ms_barang_oracle', function ($join) {
//                $join->on('brg_kodeigr', '=', 'products.kode_igr');
//                $join->on('brg_prdcd', '=', 'products.prdcd');
//            })
            ->leftJoin('ms_tag_oracle', function ($join) {
                $join->on('products.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('products.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            })
        ;

        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $var->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('products.id', '=', 'contract_items.product_id');
                });
            }
        }
        if($typeuserid == 2) {
            $var->leftJoin('price_tag', function ($join) {
                $join->on('products.prdcd', '=', 'price_tag.PRICE_PRDCD');
                $join->on('products.kode_igr', '=', 'price_tag.PRICE_KODEIGR');

            });
        }

        $var = $var->Where('kode_igr', $kodecabang)
            ->leftJoin('category_kategorioracle', 'kategori_oracle.id', '=', 'category_kategorioracle.kategori_oracle_id')
            ->leftJoin('categories', 'category_kategorioracle.category_id', '=', 'categories.id')
            ->Join('departments', 'categories.department_id', '=', 'departments.id')
            ->Join('divisions', 'departments.division_id', '=', 'divisions.id')
//            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
            ->Where('long_description', 'LIKE', '%' . str_replace(" ", "%", $key) . '%')
            ->Where('division_id', 'LIKE', $divisi)
            ->Where('department_id', 'LIKE', $department)
            ->Where('category_kategorioracle.category_id', 'LIKE', $kategori)
            ->Where('products.hrg_jual', '<>', '0')
            //            ->Where('brg_merk', 'LIKE', $merk)
//            ->whereIn('brg_merk', [$merk])
            ->Where('prdcd', 'LIKE', '%0')
            ->Paginate($ord);

        return $var;
    }

    public static function getHrgPromo($PLU)
    {
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
        return Product::Distinct()
            ->Where('prdcd', $PLU)
            ->WhereRaw('(kode_division != \'3\' OR kode_department != \'42\' OR kode_category != \'02\')')
            ->Where('kode_igr', $kodecabang)
            ->Where('flagpromomd', 1)
            ->Pluck('prmd_hrgjual');
    }

    public static function getMinBeli($PLU)
    {
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
        return Product::Distinct()
            ->Where('prdcd', $PLU)
            ->Where('kode_igr', $kodecabang)
            ->Pluck('min_jual');
    }

    public static function getUnit($PLU)
    {
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
        return Product::Distinct()
            ->Where('prdcd', $PLU)
            ->Where('kode_igr', $kodecabang)
            ->whereNotIn('kode_tag', ['A', 'H','O','X','Z','C','N'])
            ->Pluck('unit');
    }

    public static function getFrac($PLU)
    {
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
//        $kdCabang = Auth::cabang();
        return Product::Distinct()
            ->Where('prdcd', $PLU)
            ->WhereRaw('(kode_division != \'3\' OR kode_department != \'42\' OR kode_category != \'02\')')
            ->Where('kode_igr', $kodecabang)
            ->Pluck('frac');
    }

    public static function getDesc($PLU)
    {
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
//        $kdCabang = Auth::cabang();
        return Product::Distinct()
            ->Where('prdcd', $PLU)
            ->WhereRaw('(kode_division != \'3\' OR kode_department != \'42\' OR kode_category != \'02\')')
            ->Where('kode_igr', $kodecabang)
            ->Pluck('long_description');
    }

    public static function getListHarga($PLU6)
    {
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }
//        $kdCabang = Auth::cabang();
        return Product::Distinct()
            ->Select('prdcd', 'hrg_jual', 'frac', 'min_jual', 'kode_tag', 'unit')
            ->Where('prdcd', 'LIKE', $PLU6 . '%')
            ->WhereRaw('IFNULL(kode_tag, 0) != \'C\'')
            ->WhereRaw('IFNULL(kode_tag, 0) != \'Q\'')
            ->WhereRaw('IFNULL(kode_tag, 0) != \'I\'')
//            ->whereNotIn('PRD_KODETAG', function ($Q) {
//                $Q->select('TAG_KODETAG')
//                    ->from('ms_tag_oracle')
//                    ->WhereRaw('(IFNULL(TAG_TIDAKBOLEHJUAL, 0) = \'Y\' OR IFNULL(TAG_TIDAKBOLEHJUAL, 0) = \'Q\' OR IFNULL(TAG_TIDAKBOLEHJUAL, 0) = \'I\')')
//                    ->Where('TAG_KODEIGR', '18');
//            })
            ->WhereRaw('(kode_division != \'3\' OR kode_department != \'42\' OR kode_category != \'02\')')
            ->Where('kode_igr', $kodecabang)
            ->Where('products.hrg_jual', '<>', '0')
            ->OrderByRaw('hrg_jual/frac ASC')
            ->Get();
    }

    public static function getInfoData($PLU)
    {
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
        return Product::Distinct()
            ->SelectRaw('hrg_jual/frac as HRG, CASE WHEN IFNULL(flagpromomd, 0) = 1 THEN IFNULL(hrg_jual-prmd_hrgjual, 0) ELSE 0 END AS DISC, unit, frac')
            ->Where('prdcd', $PLU)
            ->Where('kode_igr', $kodecabang)
            ->first();
    }

    public static function getProductRecomended($divisi, $department, $kategori, $key){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        return Product::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

            })
            ->Join('ms_pareto_oracle', function($join)
            {
                $join->on('products.prdcd','=', 'ms_pareto_oracle.PRT_PRDCD');
                $join->on('products.kode_igr','=', 'ms_pareto_oracle.PRT_KODEIGR');
            }
            )
            ->leftJoin('ms_tag_oracle', function ($join) {
                //$join->on('ms_product_oracle.PRD_PRDCD', '=',  'ms_product_pareto.PRT_PRDCD');
                $join->on('products.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('products.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            }
            )
            ->leftJoin('kategori_oracle', function ($join) {
                $join->on('KAT_KODEDEPARTEMENT', '=', 'products.kode_department');
                $join->on('KAT_KODEKATEGORI', '=', 'products.kode_category');
            }
            )
            ->WhereRaw('(kode_division != \'3\' OR kode_department != \'42\' OR kode_category != \'02\')')
            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
            ->leftJoin('category_kategorioracle', 'kategori_oracle.id', '=', 'category_kategorioracle.kategori_oracle_id')
            ->leftJoin('categories', 'category_kategorioracle.category_id', '=', 'categories.id')
            ->Join('departments', 'categories.department_id', '=', 'departments.id')
            ->Join('divisions', 'departments.division_id', '=', 'divisions.id')
            ->Where('long_description', 'LIKE', '%' . $key . '%')
            ->Where('products.hrg_jual', '<>', '0')
            ->Where('division_id', 'LIKE', $divisi)
            ->Where('department_id', 'LIKE', $department)
            ->Where('category_kategorioracle.category_id', 'LIKE', $kategori)
            ->Where('kode_igr', $kodecabang)
            ->Where('prdcd', 'LIKE', '%0')
            ->Take(8)
            ->Get();
    }

    public static function getProductRecomendedFont(){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        return Product::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

            })
            ->Join('ms_pareto_oracle', function($join)
            {
                $join->on('products.prdcd','=', 'ms_pareto_oracle.PRT_PRDCD');
                $join->on('products.kode_igr','=', 'ms_pareto_oracle.PRT_KODEIGR');
            }
            )
            ->leftJoin('ms_tag_oracle', function ($join) {
                //$join->on('ms_product_oracle.PRD_PRDCD', '=',  'ms_product_pareto.PRT_PRDCD');
                $join->on('products.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('products.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            }
            )
            ->leftJoin('kategori_oracle', function ($join) {
                $join->on('KAT_KODEDEPARTEMENT', '=', 'products.kode_department');
                $join->on('KAT_KODEKATEGORI', '=', 'products.kode_category');
            }
            )
            ->WhereRaw('(kode_division != \'3\' OR kode_department != \'42\' OR kode_category != \'02\')')
            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
            ->Where('kode_igr', $kodecabang)
            ->Where('prdcd', 'LIKE', '%0')
            ->Orderbyraw('prt_member desc')
            ->Take(10)
            ->Get();
    }

    public static function getProductDetails($PLU)
    {
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }

        $PLU = substr($PLU, 0, 6);
        $ProductInfoAssoc = Product::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
            })

            ->leftJoin('ms_tag_oracle', function ($join) {
                $join->on('products.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('products.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            })
            ->leftJoin('stocks', function ($join) {
                $join->on(\DB::raw('substr(stocks.plu, 1, 6)'), '=', \DB::raw('substr(products.prdcd, 1, 6)'));
                $join->on('stocks.branch_id', '=', 'products.kode_igr');
            })
        ;

        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $ProductInfoAssoc->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('products.id', '=', 'contract_items.product_id');
                });
            }
        }
        if($typeuserid == 2) {
            $ProductInfoAssoc->leftJoin('price_tag', function ($join) {
                $join->on('products.kode_igr', '=', 'price_tag.PRICE_KODEIGR');
                $join->on('products.prdcd', '=', 'price_tag.PRICE_PRDCD');
            });
        }
        $ProductInfoAssoc = $ProductInfoAssoc->Where('prdcd', 'LIKE', '' . $PLU . '%')
            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
            ->whereNotIn('kode_tag', ['A', 'H','O','X','Z','C','N'])
            ->Where('prdcd', 'NOT LIKE', '%x')
            ->Where('kode_igr', $kodecabang)
            ->OrderByRaw('frac*min_jual DESC')
            ->GET();


        return $ProductInfoAssoc;
    }


    public static function getProductContractFont(){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }


        $var = Product::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
            })
            ->leftJoin('ms_tag_oracle', function ($join) {
                $join->on('products.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('products.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            });


        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $var->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('products.id', '=', 'contract_items.product_id');
                });
                $var->WhereNotNull('price');
            }
        }

        $var->Where('kode_igr', $kodecabang);
        $var = $var->Where('frac', '=', 1)->Where('min_jual', '=', 1)
            ->Paginate();

        return $var;
    }

    public static function getProductContract($key, $min, $max, $ord){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }


        $var = ProductView::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
//                $join->on('product_views.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
                $join->on('product_views.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
            })
            ->leftJoin('ms_tag_oracle', function ($join) {
                $join->on('product_views.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('product_views.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            })
        ;

        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $var->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('product_views.prdcd', '=', 'contract_items.product_plu');
                });
                $var->WhereNotNull('price');
            }
        }

        if($min != ""  && $max != "") {
            $var->whereBetween('price', [$min, $max]);
        }

        $var->Where('kode_igr', $kodecabang)
            ->whereNotIn('kode_tag', ['A', 'H','O','X','Z','C','N'])
            ->Where('long_description', 'LIKE', '%' . $key . '%');
        $var = $var
//            ->Where('prdcd', 'LIKE', '%0')
            ->Paginate($ord);

//        ->WhereRaw('(PRD_KODEDIVISI != \'3\' OR PRD_KODEDEPARTEMENT != \'42\' OR PRD_KODEKATEGORIBARANG != \'02\')')
//            ->Where('PRD_PRDCD', 'LIKE', '%0')
        return $var;
    }
}
