<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = "invoice";

    public static function createInvoice($userid){
        $date = new \DateTime;

        $array = array(
            "tgl_transaksi" => $date,
            "member_id" => $userid,
            "created_at" => $date,
            "updated_at" => $date
        );

        Invoice::Insert($array);
    }

    public static function getInvoice(){
        $userid = \Auth::User()->id;

        return Invoice::Distinct()
            ->SelectRaw('MAX(id)')
            ->Where('member_id', $userid)
            ->pluck('MAX(id)');
    }

    public static function getInvoiceCheckout($invoiceid){
        return Invoice::Distinct()
            ->Join('transaction_headers', 'invoice.id', '=', 'transaction_headers.invoice_id')
            ->Where('invoice.id', $invoiceid)
            ->Get();
    }
}
