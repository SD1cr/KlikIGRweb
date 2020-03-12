<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    protected $except = [
        'deletecart', 'deleteallcart', 'loginajax', 'tambah_alamat','addcart', 'login_admin', 'reloaddashboard', 'checkout', 'bukualamat',
        'simpan_alamat',
        'get_alamat_admin',
        'get_kota_admin',
        'get_kecamatan_admin',
        'get_kelurahan_admin',
        'get_kodepos_admin',
        'ongkirAjax',
        'EditOngkir',
        'downloadcsv',
        'getdistanceajax',
        'getviewmarker',
        'getdataajax',
        'EditJarakOngkir',
        'deleteongkir',
        'postverif',
        'cekotp',
        'ResendOTP'
    ];
}
