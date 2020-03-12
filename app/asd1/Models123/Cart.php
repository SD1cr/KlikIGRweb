<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    protected $table = "carts";

    public static function getCartContent(){
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

        $var = Cart::Distinct()
            ->Join('products', 'carts.PLU', '=', 'products.prdcd')
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

            })
//            ->Join('ms_product_oracle', function ($join) {
//                $join->on('products.prdcd', '=', 'ms_product_oracle.prd_prdcd');
//                $join->on('products.kode_igr', '=', 'ms_product_oracle.prd_kodeigr');
//            }
//            )
            ->leftJoin('ms_tag_oracle', function ($join) {
                //$join->on('ms_product_oracle.PRD_PRDCD', '=',  'ms_product_pareto.PRT_PRDCD');
                $join->on('products.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('products.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            }
            )
        ;
//            ->leftJoin('addresses', 'carts.address_id', '=', 'addresses.id');
        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $var->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('products.id', '=', 'contract_items.product_id');
                });
            }
        }
        if($typeuserid = 2 || $typeuserid = 3) {
            $var->leftJoin('price_tag', function ($join) {
                $join->on('products.kode_igr', '=', 'price_tag.PRICE_KODEIGR');
                $join->on('products.prdcd', '=', 'price_tag.PRICE_PRDCD');
            });
        }
        $var = $var->Where('kode_igr', $kodecabang)
            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
            ->Where('userid',\Auth::User()->id)
            ->whereNotIn('products.kode_tag', ['A','H','O', 'X','Z','C', 'N'])
//            ->Where('userid','ADM')
            ->OrderBy('carts.PLU')
            ->Get();

        return $var;
    }

    public static function getCartContentKat($address){
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

        $var = Cart::Distinct()  
            ->Join('products', 'carts.PLU', '=', 'products.prdcd')     
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

            }) 
//            ->Join('ms_product_oracle', function ($join) {
//                $join->on('products.prdcd', '=', 'ms_product_oracle.prd_prdcd');
//                $join->on('products.kode_igr', '=', 'ms_product_oracle.prd_kodeigr');
//            }
//            )
            ->leftJoin('ms_tag_oracle', function ($join) {
                //$join->on('ms_product_oracle.PRD_PRDCD', '=',  'ms_product_pareto.PRT_PRDCD');
                $join->on('products.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('products.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            }
            )
            ->leftJoin('addresses', 'carts.address_id', '=', 'addresses.id');
            if($typeuserid == 1) { // Corporate
                if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                    $var->leftJoin('contract_items', function($leftJoin){
                        $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                        $leftJoin->on('products.id', '=', 'contract_items.product_id');
                    });
                }
            }
            if($typeuserid = 2 || $typeuserid = 3) {
                $var->leftJoin('price_tag', function ($join) {
                    $join->on('products.kode_igr', '=', 'price_tag.PRICE_KODEIGR');
                    $join->on('products.prdcd', '=', 'price_tag.PRICE_PRDCD');
                });
            }
        $var = $var->Where('addresses.id', $address)
            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
            ->Where('kode_igr', $kodecabang)
            ->Where('flag_default',1)
            ->whereNotIn('products.kode_tag', ['A','O', 'X','Z','C', 'N'])
//            ->Where('userid',\Auth::User()->id)
//            ->Where('userid','ADM')
            ->OrderBy('carts.PLU')
            ->Get();

        return $var;
    }

    public static function getCartContentCheckout($address){
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

        $var = Cart::Distinct()
            ->Join('products', 'carts.PLU', '=', 'products.prdcd')
            ->leftJoin('ms_picture_productnew', function ($join) {
                $join->on('products.prdcd', '=', 'ms_picture_productnew.PIC_PRDCD');
//                $join->on('products.kode_igr', '=', 'ms_picture_productnew.PIC_KODEIGR');

            })
            ->leftJoin('ms_tag_oracle', function ($join) {
                //$join->on('ms_product_oracle.PRD_PRDCD', '=',  'ms_product_pareto.PRT_PRDCD');
                $join->on('products.kode_tag', '=', 'ms_tag_oracle.tag_kodetag');
                $join->on('products.kode_igr', '=', 'ms_tag_oracle.TAG_KODEIGR');
            }
            )
            ->leftJoin('addresses', 'carts.address_id', '=', 'addresses.id')
            ->join('branches','addresses.branch_id', '=', 'branches.id')
            ->join('provinces','addresses.province_id', '=', 'provinces.id')
            ->join('cities', 'addresses.city_id','=','cities.id')
            ->join('members', 'addresses.member_id', '=', 'members.id')
            ->join('districts', 'addresses.district_id', '=', 'districts.id')
            ->join('sub_districts', 'addresses.sub_district_id', '=', 'sub_districts.id');
        if($typeuserid == 1) { // Corporate
            if(Count(Contract::getBindingContractIds()->toArray()) > 0 ){
                $var->leftJoin('contract_items', function($leftJoin){
                    $leftJoin->whereIn('contract_id', Contract::getBindingContractIds()->toArray());
                    $leftJoin->on('products.id', '=', 'contract_items.product_id');
                });
            }
        }
        if($typeuserid = 2 || $typeuserid = 3) {
            $var->leftJoin('price_tag', function ($join) {
                $join->on('products.kode_igr', '=', 'price_tag.PRICE_KODEIGR');
                $join->on('products.prdcd', '=', 'price_tag.PRICE_PRDCD');
            });
        }
        $var = $var->Where('addresses.id', $address)
            ->WhereRaw('IFNULL(tag_taktampilweb, 0) <> \'Y\'')
            ->Where('products.kode_igr', $kodecabang)
            ->Where('flag_default',1)
            ->whereNotIn('products.kode_tag', ['A','O','X','Z','C', 'N'])
//            ->Where('userid',\Auth::User()->id)
//            ->Where('userid','ADM')
            ->OrderBy('carts.PLU')
            ->Get();

        return $var;
    }

    public static function getCartCsv(){
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

        return Cart::Distinct()
            ->selectRaw("concat(substring(carts.PLU,1,6),'1') as `PLU1` , SUM(qty * frac) as `Jumlah`")
            ->Join('products', 'carts.PLU', '=', 'prdcd')
            ->Where('kode_igr', $kodecabang)
            ->Where('userid', \Auth::User()->id)
            ->whereNotIn('products.kode_tag', ['A','O', 'X','Z','C', 'N'])
//            ->Where('userid','ADM')
            ->OrderBy('carts.PLU')
            ->GroupBy(\DB::Raw("concat(substring(carts.PLU,1,6), '1')"))
            ->Get();
    }

    public static function countIsCartItem($PLU, $ADDR = NULL){
        if($ADDR == NULL){
            $ADDR = Address::getDefaultAddress();
        }
        return Cart::Distinct()
            ->Where('userid', \Auth::User()->id)
//            ->Where('userid','ADM')
            ->Where('address_id', $ADDR)
            ->Where('PLU', $PLU)
            ->Pluck('qty');
    }

    public static function delCartItem($PLU, $ADDR = NULL){
//        if($ADDR == NULL){
//            $ADDR = Address::getDefaultAddress();
//        }
        try{
            Cart::Where('userid', \Auth::User()->id)
                ->Where('PLU', $PLU)
//                ->Where('address_id', $ADDR)
                ->Delete();
            return "OK";
        }catch(Exception $e){
            return "FAIL";
        }
    }

    public static function delCartAll(){
        try{
            Cart::Where('userid', \Auth::User()->id)
                ->Delete();
            return "OK";
        }catch(Exception $e){
            return "FAIL";
        }
    }

    public static function truncateUserCart($id){
        try{
            Cart::Where('userid', \Auth::User()->id)
                ->Where('address_id', $id)
                ->Delete();
            return "OK";
        }catch(Exception $e){
            return "FAIL";
        }
    } 

    public static function updCartItem($PLU, $QTY, $ADDR){
        try{
            $date = new \DateTime;
            try{
                $cartQty = Cart::countIsCartItem($PLU, $ADDR);
            }catch (Exception $ex){
                return "FAIL";
            }
            if($cartQty > 0){
                $array = array(
                    "qty" => $QTY,
                    "updated_at" => $date
                );
                Cart::Where('PLU', $PLU)
                    ->Where('userid', \Auth::User()->id)   
                    ->Where('address_id', $ADDR)
                    ->Update($array);
            }else{
                return "FAIL";
            }
            return "OK";
        }catch(Exception $e){
            return "FAIL";
        }
    }

    public static function addCartItem($PLU, $QTY, $UNIT = null, $po_no = null){
        try{
        $cartQty = Cart::countIsCartItem($PLU, Address::getDefaultAddressId());

        }catch (Exception $ex){
        $cartQty = 0;
        }
        if($UNIT == null){
            $UNIT = Product::getUnit($PLU);
        }

        $date = new \DateTime;
        if($QTY > 0){
            if($cartQty > 0){
                //Sudah ada di cart, Update
                $array = array(
                    "qty" => $cartQty + $QTY,
                    "updated_at" => $date
                );
                Cart::Where('PLU', $PLU)
                    ->Where('userid', \Auth::User()->id)
//                    ->Where('userid','ADM')
                    ->Update($array);
            }else{
                //Belum ada di cart, Insert

                $array = array(
                    "userid" =>  \Auth::User()->id,
                    "PLU" => $PLU,
                    "qty" => $QTY,
                    "unit" => $UNIT,
                    "created_at" => $date,
                    "updated_at" => $date,
                    "address_id" => Address::where('member_id',\Auth::User()->id)->where('flag_default',1)->Pluck('id'),
                    "no_po" => $po_no,
                );
                Cart::Insert($array);
            }
        }
    }

//    public static function addCartItem($QTY, $plu, $UNIT){
//        try{
//            $cartQty = Cart::countIsCartItem($plu, Address::getDefaultAddressId());
//
//        }catch (Exception $ex){
//            $cartQty = 0;
//        }
//
//        $date = new \DateTime;
//        if($QTY > 0){
//            if($cartQty > 0){
//                //Sudah ada di cart, Update
//                $array = array(
//                    "qty" => $cartQty + $QTY,
//                    "updated_at" => $date
//                );
//                Cart::Where('PLU', $plu)
//                    ->Where('userid', \Auth::User()->id)
////                    ->Where('userid','ADM')
//                    ->Update($array);
//            }else{
//                //Belum ada di cart, Insert
//
//                $array = array(
//                    "userid" =>  \Auth::User()->id,
////                    "userid" =>  'ADM',
//                    "PLU" => $plu,
//                    "qty" => $QTY,
//                    "unit" => $UNIT,
//                    "created_at" => $date,
//                    "updated_at" => $date,
//                    "address_id" => Address::where('member_id',\Auth::User()->id)->where('flag_default',1)->Pluck('id')
//                );
//                Cart::Insert($array);
//            }
//        }
//    }


}