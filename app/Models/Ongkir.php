<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ongkir extends Model
{
    protected $table = 'ongkir_details';

    public static function getDetailsOngkir(){
        return Ongkir::Distinct()
           ->selectRaw('ongkir_details.id as trxid, nama, pulau, pulau_id, kendaraan_id, km_a, biaya_a, km_b, concat(biaya_b, "/ 1 Km") as biayaB, km_c, CASE WHEN km_c = 0 and biaya_c = 0 THEN "-" ELSE concat(concat(concat(\'>\', km_c), \' Km + Rp \'), biaya_c) END as ekstra, biaya_c, km_max')
            ->leftJoin('master_kendaraan', 'master_kendaraan.id', '=', 'ongkir_details.kendaraan_id')
            ->leftJoin('cabang_ongkir', 'cabang_ongkir.id', '=', 'ongkir_details.pulau_id')
//            ->Where('ongkir_details.id', 'like', '%' . $id . '%')
            ->Get();
    }

}
