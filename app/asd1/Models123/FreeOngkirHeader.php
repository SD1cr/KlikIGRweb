<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeOngkirHeader extends Model
{
    protected $table = 'freeongkir_hdr';

    public static function getFreeOngkir(){        
        return FreeOngkirHeader::Distinct()
            ->SelectRaw('CASE WHEN flag_all = \'Y\' THEN \'nominal\' ELSE \'member\' END as tipe, nama, kodemember,nominal, DATE_FORMAT(periode_start, "%d %M %Y") as awal, DATE_FORMAT(periode_end, "%d %M %Y") as akhir, flag_all, freeongkir_hdr.id, cabang, address_id, name, freeongkir_hdr.id as idfree')
            ->leftjoin('branches','branches.kode_igr', '=', 'freeongkir_hdr.cabang')
            ->leftjoin('freeongkir_dtl', 'freeongkir_hdr.id', '=', 'freeongkir_dtl.ongkir_id')
            ->Groupby('nama')
            ->OrderByRaw('id desc')
            ->Get();
    }


    public static function getDetailOngkir(){
        if(\Auth::guest()){
            $kodecabang = '18';
        }else{
            $kodecabang = Branch::getBranches();
        }
        return FreeOngkirHeader::Distinct()
            ->where('periode_start', '<=', Carbon::today())
            ->where('periode_end', '>=', Carbon::today())
            ->where('flag_all', '=', 'Y')
            ->where('cabang', $kodecabang)
            ->get();
    }
}
