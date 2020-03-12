<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransactionHeader extends Model
{
    protected $table = "transaction_headers";

    public static function createHeader($tel, $jln, $subdistrict, $district, $kota, $prov, $kodepos, $kdCabang, $invoiceID, $addressID, $nopo){
        $date = new \DateTime;
        $userid = \Auth::User()->id;
        $fee = '0';
        $kdTran = TransactionHeader::SelectRaw('MAX(kode_transaksi)')->pluck('MAX(kode_transaksi)') + 1;
        $array = array(
            "userid" =>  $userid,
            "kode_transaksi" => $kdTran,
            "kode_cabang" => $kdCabang,
            "tgl_transaksi" => $date,
            "trstatus" => 0,
            "paystatus" => 0,
            "status_id" => 1,
            "phone" => $tel,
            "shipping_address" => $jln,
            "shipping_subdistrict" => $subdistrict,
            "shipping_district" => $district,
            "shipping_city" => $kota,
            "shipping_province" => $prov,
            "shipping_postal" => $kodepos,
            "shipping_fee" => $fee,
            "created_at" => $date,
            "updated_at" => $date,
            "invoice_id" => $invoiceID,
            "address_id" => $addressID,
            "no_po" => $nopo
        );
        TransactionHeader::Insert($array);

        Return $kdTran;
    }

    public static function updateHeader($kdTran, $bayar, $harga, $disc = 0){
        $date = new \DateTime;

        $array = array(
            "total_bayar" => $bayar,
            "total_harga" => $harga,
            "total_disc" => $disc,
            "updated_at" => $date
        );
        TransactionHeader::Where('kode_transaksi', $kdTran)
            ->Update($array);
    }

    public static function checkRequestAllowed($kdTran){
//        if(Auth::role() == 'ADMIN'||Auth::role() == 'SYSTEM'){
//            return "OK";
//        }else{
//            $id = Auth::userid();
        $userid = \Auth::User()->id;
        $assoc = TransactionHeader::Distinct()
//            ->Join('invoice', 'invoice.id', '=', 'transaction_headers.invoice_id')
            ->Where('userid', $userid)
            ->Where('kode_transaksi', $kdTran)
            ->Get();
        $count = 0;
        foreach($assoc as $index => $row){
            $count++;
        }
        if($count > 0){
            return "OK";
        }else{
            return "FAIL";
        }
//        }
    }

    public static function getListTransactionHeaders($add){
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }

        $userid = \Auth::User()->id;
        $trans = TransactionHeader::Distinct()
            ->Join('invoice', 'invoice.id', '=', 'transaction_headers.invoice_id')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'transaction_headers.status_id')
            ->Where('userid', $userid);
             if($typeuserid == 1){
                 $trans ->Where('address_id', $add);    
             }
            $trans = $trans->OrderBy('invoice.id', 'desc')
            ->Paginate(5)->get();

        return $trans;
    }

    public static function getListTransactionHeaders2($add){
        if (!\Auth::guest()) {
            $typeuserid = \Auth::User()->type_id;
        }else{
            $typeuserid = '3';
        }

        $userid = \Auth::User()->id;
        $trans = TransactionHeader::Distinct()
//            ->Join('invoiced', 'invoice.id', '=', 'transaction_headers.invoice_id')
            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'transaction_headers.status_id')
            ->Where('userid', $userid);
        if($typeuserid == 1){
            $trans ->Where('address_id', $add);
        }
        $trans = $trans->OrderBy('transaction_headers.kode_transaksi', 'desc')
            ->Paginate(5);

        return $trans;
    }

    public static function getTransactionHeader($kdTran){
        return TransactionHeader::Distinct()
//            ->leftJoin('transaction_status', 'transaction_status.id', '=', 'transaction_headers.status_id')
            ->Where('kode_transaksi', $kdTran)
            ->Get(1);
    }

    public static function getPBDetail($kodetrans){
        return  TransactionHeader::Distinct()
            ->SelectRaw('PLU, harga, qty, PRD_DESKRIPSIPANJANG, qty_realisasi')     
            ->Join('transaction_details', 'transaction_headers.kode_transaksi', '=', 'transaction_details.kode_transaksi')
            ->Join('ms_product_oracle', function ($join) {
                $join->on('transaction_details.PLU', '=', 'ms_product_oracle.prd_prdcd');
                $join->on('transaction_headers.kode_cabang', '=', 'ms_product_oracle.prd_kodeigr');
            })
            ->Join('transaction_downloads', 'transaction_headers.kode_transaksi', '=', 'transaction_downloads.kode_transaksi')
            ->Where('transaction_headers.kode_transaksi', $kodetrans)
            //->GroupBy('prdcd')
            ->Get();
    } 

    public static function getTransactionConfirmation(){
        return TransactionHeader::Distinct()
            ->Select('kode_transaksi')
            ->Where('userid', \Auth::User()->id)
            ->Where('kode_cabang', Branch::getBranches())
            ->Where('paystatus', 0)
            ->OrderBy('kode_transaksi', 'desc')
            ->Take(3)
            ->Get();
    }
}
