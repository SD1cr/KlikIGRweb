<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
    protected $table = 'product_views';

    public static function getAllProduct($divisi, $department, $kategori, $ord = 25, $key, $merk = null, $min, $max, $sort){

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
            ->LeftJoin('ms_picture_productnew', function ($join) {
//                $join->on('product_views.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
                $join->on('product_views.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
            });
        if($typeuserid == 2) {
            $var->leftJoin('price_tag', function ($join) {
                $join->on('product_views.prdcd', '=', 'price_tag.PRICE_PRDCD');
                $join->on('product_views.kode_igr', '=', 'price_tag.PRICE_KODEIGR');
            });
        }

        $var->Join('products', function ($join) {
            $join->on('product_views.kode_igr', '=', 'products.kode_igr');
            $join->on('product_views.prdcd', '=', 'products.prdcd');
        });

        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $var->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('products.id', '=', 'contract_items.product_id');
                });
            }
        }

        $var->leftJoin('kategori_oracle', function ($join) {
            $join->on('KAT_KODEDEPARTEMENT', '=', 'product_views.kode_department');
            $join->on('KAT_KODEKATEGORI', '=', 'product_views.kode_category');
        })

            ->leftJoin('ms_tag_oracle', function ($join) {
                $join->on('product_views.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('product_views.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            })
        ;


//        if($typeuserid = 2 || $typeuserid = 3) {
//            $var->leftJoin('price_tag', function ($join) {
//                $join->on('product_views.kode_igr', '=', 'price_tag.PRICE_KODEIGR');
//                $join->on('product_views.prdcd', '=', 'price_tag.PRICE_PRDCD');
//            });
//        }

        $var->Where('product_views.kode_igr', $kodecabang)
            ->leftJoin('category_kategorioracle', 'kategori_oracle.id', '=', 'category_kategorioracle.kategori_oracle_id')
            ->leftJoin('categories', 'category_kategorioracle.category_id', '=', 'categories.id')
            ->Join('departments', 'categories.department_id', '=', 'departments.id')
            ->Join('divisions', 'departments.division_id', '=', 'divisions.id');

        if($merk[0] != "") {
            $var->whereIn('brg_merk', $merk);
        }

        if($min != ""  && $max != "") {
            $var->whereBetween('product_views.hrg_jual', [$min, $max]);
        }


//            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
        $var = $var->Where('product_views.long_description', 'LIKE', '%' . str_replace(" ", "%", $key) . '%')
            ->WhereRaw('(product_views.kode_division != \'3\' OR product_views.kode_department != \'42\' OR product_views.kode_category != \'02\')')
            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
            ->Where('division_id', 'LIKE', $divisi)
            ->Where('product_views.long_description', 'not like', '%INDOMARET%')
            ->Where('product_views.kode_tag', '<>', 'N')
            ->Where('product_views.hrg_jual', '<>', '0')
            // ->whereNotIn('kode_tag', ['A', 'H','O', 'X','Z','C', 'N'])
            ->Where('department_id', 'LIKE', $department)
            ->Where('category_kategorioracle.category_id', 'LIKE', $kategori)
            ->Where('product_views.kode_igr', $kodecabang);
        if(\Auth::guest() || $typeuserid == 1 || $typeuserid == 3) {
            $var->where('product_views.flag_klik', 'Y');
        } 
        if($sort == "asc") {
            $var->OrderBy('product_views.hrg_jual', 'asc');
        }elseif($sort == "desc") {
            $var->OrderBy('product_views.hrg_jual', 'desc');
        }
        $var = $var->Paginate($ord);

        return $var;
    }

    public static function getProductRecomended($divisi, $department, $kategori, $key, $brand){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }

        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }
        $var = Pareto::Distinct()
            ->Join('product_views', function($join)
            {
                $join->on('product_views.prdcd','=', 'ms_pareto_oracle.PRT_PRDCD');
                $join->on('product_views.kode_igr','=', 'ms_pareto_oracle.PRT_KODEIGR');
            }
            )

            ->Join('products', function ($join) {
                $join->on('product_views.kode_igr', '=', 'products.kode_igr');
                $join->on('product_views.prdcd', '=', 'products.prdcd');
            });

        if(isset($typeuserid)){
            if($typeuserid == 1) { // Corporate
                if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                    $var->leftJoin('contract_items', function($leftJoin){
                        $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                        $leftJoin->on('products.id', '=', 'contract_items.product_id');
                    });
                }
            }
        }

        $var->leftJoin('ms_picture_productnew', function ($join) {
            $join->on('product_views.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//            $join->on('product_views.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

        })
            ->leftJoin('ms_tag_oracle', function ($join) {
                //$join->on('ms_product_oracle.PRD_PRDCD', '=',  'ms_product_pareto.PRT_PRDCD');
                $join->on('product_views.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('product_views.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            }
            )
            ->leftJoin('kategori_oracle', function ($join) {
                $join->on('KAT_KODEDEPARTEMENT', '=', 'product_views.kode_department');
                $join->on('KAT_KODEKATEGORI', '=', 'product_views.kode_category');
            }
            );
//            ->WhereRaw('(kode_division != \'3\' OR kode_department != \'42\' OR kode_category != \'02\')')
//            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
        $var = $var->leftJoin('category_kategorioracle', 'kategori_oracle.id', '=', 'category_kategorioracle.kategori_oracle_id')
            ->leftJoin('categories', 'category_kategorioracle.category_id', '=', 'categories.id')
            ->Join('departments', 'categories.department_id', '=', 'departments.id')
            ->Join('divisions', 'departments.division_id', '=', 'divisions.id')
            ->Where('product_views.long_description', 'LIKE', '%' . $key . '%')
            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'');
        if($brand[0] != "") {
            $var->whereIn('brg_merk', $brand);
        }
        if(\Auth::guest() || $typeuserid == 1 || $typeuserid == 3) {
            $var->where('product_views.flag_klik', 'Y');
        }
        $var = $var->Where('division_id', 'LIKE', $divisi)
            ->Where('product_views.long_description', 'not like', '%INDOMARET%')
            ->WhereNotNull('product_views.hrg_jual')
            ->Where('department_id', 'LIKE', $department)
            ->Where('category_kategorioracle.category_id', 'LIKE', $kategori)
            ->Where('product_views.kode_igr', $kodecabang)
            ->Orderbyraw('ms_pareto_oracle.id')
            ->Take(8)
            ->Get();

        return $var;
    }

    public static function getFilterProduk($divisi, $department, $kategori, $key, $brand){
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

        $var = ProductView::Distinct()->select('brg_merk')
            ->leftJoin('kategori_oracle', function ($join) {
                $join->on('KAT_KODEDEPARTEMENT', '=', 'product_views.kode_department');
                $join->on('KAT_KODEKATEGORI', '=', 'product_views.kode_category');
            })
//            ->Join('ms_barang_oracle', function ($join) {
//                $join->on('brg_kodeigr', '=', 'product_views.kode_igr');
//                $join->on('brg_prdcd', '=', 'product_views.prdcd');
//            })
            ->leftJoin('category_kategorioracle', 'kategori_oracle.id', '=', 'category_kategorioracle.kategori_oracle_id')
            ->leftJoin('categories', 'category_kategorioracle.category_id', '=', 'categories.id')
            ->Join('departments', 'categories.department_id', '=', 'departments.id')
            ->Join('divisions', 'departments.division_id', '=', 'divisions.id')
            ->Where('long_description', 'LIKE', '%' . str_replace(" ", "%", $key) . '%')
            ->Where('division_id', 'LIKE', $divisi)
            ->Where('department_id', 'LIKE', $department)
            ->Where('category_kategorioracle.category_id', 'LIKE', $kategori)
            ->Where('prdcd', 'LIKE', '%0')
            ->Where('kode_tag', '<>', 'N');
        if(\Auth::guest() || $typeuserid == 1 || $typeuserid == 3) {
            $var->where('product_views.flag_klik', 'Y');
        }
//        if($brand[0] != "") {
//           $var->whereIn('brg_merk', $brand);
//        }
        $var = $var->Where('kode_igr', 'LIKE', $kodecabang)
            ->GroupBy('brg_merk')
            ->get();

        return $var;
    }

    public static function getProductViewDetails($PLU)
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
        $ProductInfoAssoc = ProductView::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('product_views.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('product_views.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
            })
            ->leftJoin('plu_desc', 'product_views.plu_mcg', '=', 'plu_desc.kd_plu')
            ->leftJoin('master_desc', 'master_desc.kode_ot', '=', 'plu_desc.kode_ot')
        ;

        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $ProductInfoAssoc->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('product_views.id', '=', 'contract_items.product_plu');
                });
            }
        }
        $ProductInfoAssoc = $ProductInfoAssoc->Where('prdcd', 'LIKE', '' . $PLU . '%')
            ->Where('kode_igr', $kodecabang)
            ->WhereNotNull('deskripsi')
            ->GET();

        return $ProductInfoAssoc;
    }

    public static function getProductViewDetailsGramasi($PLU)
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
        $ProductInfoAssoc = ProductView::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('product_views.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('product_views.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');
            })
        ;

        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $ProductInfoAssoc->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('product_views.id', '=', 'contract_items.product_plu');
                });
            }
        }
        $ProductInfoAssoc = $ProductInfoAssoc->Where('prdcd', 'LIKE', '' . $PLU . '%')
            ->Where('kode_igr', $kodecabang)
            ->GET();

        return $ProductInfoAssoc;
    }

    public static function getProductPromo()
    {
        $ProductInfoAssoc = ProductView::Distinct()
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('product_views.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
            })
            ->Join('plu_promo', function ($join) {
                $join->on('product_views.prdcd', '=', 'plu_promo.kode_plu');
            })
            ->Where('kode_igr', 18)
            ->GET();

        return $ProductInfoAssoc;
    }

}
