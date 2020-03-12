<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\Auth;
use Auth;

class TransactionDownload extends Model {

    protected $table = "transaction_downloads";

    public static function  getAllCSV($status = "%", $cab = "%", $tipe = "%")  
    {
            $result = TransactionDownload::Distinct()
                ->SelectRaw('CASE WHEN npwp_number IS not NULL THEN \'Y\' ELSE cus_flagpkp END as flagmember,transaction_headers.kode_transaksi, CONCAT(nama, "<br>(", email, ")") AS emailnama , tgl_transaksi, email, nama, branches.name, description, cus_flagpkp, npwp_number')
                ->Join('transaction_headers', 'transaction_downloads.kode_transaksi', '=', 'transaction_headers.kode_transaksi')
                ->Join('members', 'members.id', '=', 'transaction_headers.userid')
                ->leftjoin('customers', 'customers.id', '=', 'members.customer_id')
                ->Join('types', 'types.id', '=', 'members.type_id')    
                ->Join('branches', 'transaction_downloads.kode_cabang', '=', 'branches.kode_igr')
                ->leftJoin('transaction_status', 'transaction_status.id', '=', 'transaction_headers.status_id');
                   if(\Auth::user('users_admin')->role == 2) {
                       $result ->Where('transaction_downloads.kode_cabang', \Auth::user('users_admin')->branch_code);
                           }else {
                       $result ->Where('transaction_downloads.kode_cabang', 'LIKE', $cab);
                   }
//                ->Where('transaction_downloads.kode_transaksi', 'LIKE', $kdtran)
            $result = $result->Where('status_id', 'LIKE', $status)
                ->Where('type_id', 'LIKE', $tipe)
                ->OrderBy('transaction_downloads.kode_transaksi', 'desc') 
                ->get();

        return $result;
    }                 

}