@extends('appcheckout')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="row">
            {!! $sideprofile !!}
            <div class="col-sm-9" style="min-height: 4px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
                <div style="margin-bottom: 10px;margin-top: 10px;">

                    <div class="row">
                        <div class="bs-callout bs-callout-warning" style="margin-top: -10px; margin-bottom: 20px;">
                            <h4 style="font-size: 30px !important;">Cara Pendaftaran</h4>
                            Klik Indogrosir siap melayani Anda
                        </div>
                    </div>
                    <div style="padding-left: 20px;padding-right: 10px;">

                        <p><big><strong>1. Untuk mulai berbelanja di web Klikindogrosir Anda perlu mendaftar (registrasi) terlebih dahulu di menu “Daftar” pada halaman Klikindogrosir </strong></big></p>

                        <p>&nbsp;</p>

                        <p><big><strong>2. Setelah mengunjungi halaman diatas akan muncul tampilan dibawah ini :  </strong></big></p>

                        <p>&nbsp;</p>

                        <p><img alt=""  src="{{ secure_url('../resources/assets/img/reg.png') }}" width="100%" /></p></br>
                        <p><big><strong> - Isi semua data diri yang diminta dengan benar. </strong></big></p>
                        <p><big><strong> - Pastikan alamat email yang Anda gunakan belum pernah mendaftar di account Klikindogrosir sebelumnya.</strong></big></p></br>

                        <p><big><strong>3. Apabila data diri yang Anda masukkan sudah benar, silahkan klik tombol “Simpan User”.</strong></big></p>

                        <p>&nbsp;</p>

                        <p><big><strong>4. Anda akan langsung log in kedalam web dan mulai berbelanja. </strong></big></p>

                        <p>&nbsp;</p>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection