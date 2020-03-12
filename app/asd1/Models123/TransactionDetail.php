<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransactionDetail extends Model
{
    protected $table = "transaction_details";

    public static function insertDetail($kdTran, $plu, $qty, $harga, $disc, $subtotal){
        $date = new \DateTime;

        $array = array(
            "PLU" => $plu,
            "qty" => $qty,
            "harga" => $harga,
            "disc" => $disc,
            "kode_transaksi" =>  $kdTran,
            "subtotal" => $subtotal,
            "created_at" => $date,
            "updated_at" => $date
        );

        TransactionDetail::Insert($array);
    }

    public static function getTransactionDetail($invoiceID, $addressID){
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        } 
        $kodecabang = Branch::getBranches(); 
        $trans = TransactionDetail::Distinct()
            ->Select('PLU', 'qty', 'harga', 'disc', 'subtotal', 'long_description', 'URL_PIC_PROD', 'kode_tag','unit', 'frac', \DB::raw('(subtotal/qty) AS hargatot'))
            ->Join('transaction_headers', 'transaction_details.kode_transaksi', '=', 'transaction_headers.kode_transaksi')
            ->leftJoin('products', function ($join) {
                $join->on('transaction_details.PLU', '=', 'products.prdcd');
                $join->on('transaction_headers.kode_cabang', '=', 'products.kode_igr');
            })
            ->leftJoin('ms_picture_product', function ($join) {
                $join->on('transaction_details.PLU', '=', 'ms_picture_product.PIC_PRDCD');
                $join->on('transaction_headers.kode_cabang', '=', 'ms_picture_product.pic_kodeigr');
            })
            ->Join('invoice', 'invoice.id', '=', 'transaction_headers.invoice_id')
			//->Where('kode_tag', '<>', 'N')
            ->Where('invoice.id', $invoiceID)
			->Where('pic_kodeigr', $kodecabang);

                $trans ->Where('address_id', $addressID);

            $trans = $trans->Where('kode_igr', $kodecabang)
            ->Get();
        return $trans;
    }

//    public static function getTransactionDetail1($invoiceID){
//        if (!\Auth::guest()) {
//            $typeuserid = \Auth::User()->type_id;
//        }else{
//            $typeuserid = '3';
//        }
//        $kodecabang = Branch::getBranches();
//        $trans = TransactionDetail::Distinct()
//            ->Select('PLU', 'qty', 'harga', 'disc', 'subtotal', 'long_description', 'URL_PIC_PROD')
//            ->Join('products', 'transaction_details.PLU', '=', 'products.prdcd')
//            ->Join('ms_picture_productnewnew', 'transaction_details.PLU', '=', 'ms_picture_productnewnew.PIC_PRDCD')
//            ->Join('transaction_headers', 'transaction_details.kode_transaksi', '=', 'transaction_headers.kode_transaksi')
//            ->Join('invoice', 'invoice.id', '=', 'transaction_headers.invoice_id')
//            ->Join('addresses', 'addresses.id', '=', 'transaction_headers.address_id')
//            ->Where('invoice.id', $invoiceID)
//            ->Where('flag_default', 1);
//        $trans = $trans->Where('pic_kodeigr', $kodecabang)
//            ->Get();
//        return $trans;
//    }

//    public static function getTransactionReorderDetail($invoiceID){
//        $kodecabang = Branch::getBranches();
//        return TransactionDetail::Distinct()
//            ->Select('PLU', 'qty', 'harga', 'disc', 'subtotal', 'long_description', 'URL_PIC_PROD')
//            ->Join('products', 'transaction_details.PLU', '=', 'products.prdcd')
//            ->Join('ms_picture_productnewnew', 'transaction_details.PLU', '=', 'ms_picture_productnewnew.PIC_PRDCD')
//            ->Join('transaction_headers', 'transaction_details.kode_transaksi', '=', 'transaction_headers.kode_transaksi')
//            ->Join('invoice', 'invoice.id', '=', 'transaction_headers.invoice_id')
//			->Where('kode_tag', '<>', 'N')
//            ->Where('invoice.id', $invoiceID)
//            ->Where('pic_kodeigr', $kodecabang)
//            ->Get();
//    }

    public static function getTransactionReorderDetail($invoiceID){
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }
        $kodecabang = Branch::getBranches();
        $trans = TransactionDetail::Distinct()
            ->Select('PLU', 'qty', 'harga', 'disc', 'subtotal', 'long_description', 'URL_PIC_PROD')
            ->Join('transaction_headers', 'transaction_details.kode_transaksi', '=', 'transaction_headers.kode_transaksi')
            ->leftJoin('products', function ($join) {
                $join->on('transaction_details.PLU', '=', 'products.prdcd');
                $join->on('transaction_headers.kode_cabang', '=', 'products.kode_igr');
            })
            ->leftJoin('ms_picture_product', function ($join) {
                $join->on('transaction_details.PLU', '=', 'ms_picture_product.PIC_PRDCD');
                $join->on('transaction_headers.kode_cabang', '=', 'ms_picture_product.pic_kodeigr');
            })
            ->Join('invoice', 'invoice.id', '=', 'transaction_headers.invoice_id')
            ->Where('invoice.id', $invoiceID);
           if($typeuserid == 1 || $typeuserid == 3) {
               $trans->where('products.flag_klik', 'Y');   
           }
         $trans = $trans->Where('kode_igr', $kodecabang)         
             ->Get();
        return $trans;
    }      

    public static function getListHistory($key, $id, $addressID){

        $key = str_replace(" ", "%", $key);
        return TransactionDetail::Distinct()

            ->Select('PLU', 'long_description', \DB::raw('sum(qty*harga) AS Jumlah'))
            ->Join('transaction_headers', 'transaction_details.kode_transaksi', '=', 'transaction_headers.kode_transaksi')
            ->Join('users', 'transaction_headers.userid', '=', 'users.id')
            ->leftJoin('products', function ($join) {    
                $join->on('transaction_details.PLU', '=', 'products.prdcd');
                $join->on('transaction_headers.kode_cabang', '=', 'products.kode_igr');
            })
            ->WhereRaw('members.kode_cabang = kode_igr')
            ->Where('userid', $id)
            ->Where('long_description', 'LIKE', '%'. $key . '%')       
            ->GroupBY('PLU')
            ->OrderBy('Jumlah', 'desc')
            ->Paginate(10);
    }
}
