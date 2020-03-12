@extends('appcheckout')
@section('content')
    <div class="container" style="margin-top: 90px;">
        <div class="row">
            {!! $sideprofile !!}
            <div class="col-sm-9" style="min-height: 4px;box-shadow : 0 1px 4px 0 rgba(0, 0, 0, 0.14);">
                <div style="margin-bottom: 10px;margin-top: 10px;">

                    <div class="row">
                        <div class="bs-callout bs-callout-primary" style="margin-top: -10px; margin-bottom: 20px;">
                            <h4 style="font-size: 30px !important;">Cara Belanja</h4>
                            Klik Indogrosir siap melayani Anda
                        </div>
                    </div>
                    <div style="padding-left: 20px;padding-right: 10px;">

                        <p><big><strong>1.	Silahkan log in terlebih dahulu di menu “Masuk” apabila Anda sudah mempunyai account.  </strong></big></p>

                        <p>&nbsp;</p>

                        <p><big><strong>2.	Tentukan alamat kirim yang ada di menu Buku Alamat, klik “Default” kemudian klik “Ya”.</strong></big></p>

                        <p>&nbsp;</p>

                        <p><big><strong>3.	Untuk menemukan produk yang Anda cari, ada dua cara yang bisa Anda lakukan, yaitu:</strong></big></p>

                        <p>&nbsp;</p>

                        <p><big> - Ketik nama produk pada kolom pencarian </big></p>
                        <p><img alt=""  src="{{ url('../resources/assets/img/reg1.png') }}" width="100%" /></p></br>

                        <p><big> - Klik Kategori-kategori yang tersedia di halaman Klikindogrosir.</big></p>
                        <p><img alt=""  src="{{ url('../resources/assets/img/reg2.jpg') }}" width="60%" /></p></br>


                        <p><big><strong>4.	Setelah Anda menemukan produk yang dicari, klik gambar produk tersebut untuk memuat informasi produk lebih banyak : </strong></big></p>

                        <p>&nbsp;</p>

                        <p><img alt=""  src="{{ url('../resources/assets/img/reg3.jpg') }}" width="100%" /></p></br>
                        <p><big> - Informasi Produk : memuat semua detail informasi produk yang Anda pilih. </big></p>
                        <p><big> - Harga Grosir   	: memuat daftar harga produk dengan satuan jual </big></p>

                        <p><big><strong>5.	Apabila Anda sudah yakin dengan produk yang Anda pilih, silahkan pilih harga satuan jual dan masukkan jumlah produk yang Anda pesan kemudian klik “Beli Sekarang”.</strong></big></p>

                        <p>&nbsp;</p>

                        <p><img alt=""  src="{{ url('../resources/assets/img/reg4.jpg') }}" width="100%" /></p></br>

                        <p><big><strong>6. Selanjutnya akan muncul pop up dibawah ini, apabila Anda ingin menambah produk lain klik “Lanjut Belanja” kemudian cari produk yang Anda ingin beli ikuti step sebelumnya, klik “Perbarui Keranjang” akan muncul produk yang sudah ditambahkan, apabila anda sudah yakin klik “Pesan Sekarang”.</strong></big></p>

                        <p>&nbsp;</p>

                        <p><img alt=""  src="{{ url('../resources/assets/img/reg5.jpg') }}" width="100%" /></p></br>

                        <p><big><strong>7.	Setelah itu akan mucul tampilan berupa informasi detail pemesanan barang dan total harga yang harus dibayar serta pastikan alamat kirim yang Anda pilih sudah sesuai, kemudian klik “Lanjutkan Pembayaran” setelah itu akan  muncul pop up dan klik “Check Out”.</strong></big></p>

                        <p>&nbsp;</p>

                        <p><img alt=""  src="{{ url('../resources/assets/img/reg6.jpg') }}" width="100%" /></p></br>     

                        <p><big><strong>8.	Setelah check out Anda akan menerima konfirmasi pemesanan berupa email dalam waktu 24 jam. Terima kasih sudah berbelanja di Klikindogorsir.com</strong></big></p>

                        <p>&nbsp;</p>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection