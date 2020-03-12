<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Aktivasi Akun</title>

</head>
<body>

<h4>Mengaktifkan Akun Klikindogrosir Anda</h4><br>

<span>Hai, {{ $nama }} </span>

<br>
<p>Terimakasih sudah mendaftar untuk bergabung dengan Klikindogrosir</p><br>
<p>Untuk menyelesaikan proses registrasi, mohon lakukan konfirmasi pendaftaran melalui tombol dibawah ini :</p><br>

<a href="{{ secure_url('/activate/'. $code) }}"><button>Aktifkan Akun Anda</button></a><br>
    <p>Jika button tidak berfungsi, silahkan klik link dibawah ini</p><br>
<a href="{{ secure_url('/activate/'. $code) }}">
    {{ secure_url('/activate/'. $code) }}
</a><br><br>

<p>Terima kasih,</p><br>

<p>
    Admin KlikIndogrosir
</p><br>
<a href="{{ secure_url('/product') }}"><img  src="{{ secure_url('../resources/assets/img/logo.png') }}"/></a>
</body>

</html>