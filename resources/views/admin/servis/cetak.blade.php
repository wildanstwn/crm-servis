<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Servis - {{ $s->nama_unit }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .content { margin-top: 20px; line-height: 1.6; }
        .footer { margin-top: 50px; text-align: right; font-style: italic; }
        .btn-print { background: #007bff; color: white; padding: 10px; text-decoration: none; border-radius: 5px; }
        @media print { .btn-print { display: none; } }
    </style>
</head>
<body onload="window.print()"> <div class="header">
        <h2>CAHAYA MANDIRI AUDIO & ELEKTRONIK</h2>
        <p>Jl. Singkil  - Spesialis Service Audio & Elektronik</p>
    </div>

    <div class="content">
        <table width="100%">
            <tr>
                <td width="150">No. Antrean</td>
                <td>: <b>#SRV-00{{ $s->id }}</b></td>
            </tr>
            <tr>
                <td>Tanggal Masuk</td>
                <td>: {{ $s->created_at->format('d M Y') }}</td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>: {{ $s->pelanggan->nama }} ({{ $s->pelanggan->no_wa }})</td>
            </tr>
            <tr>
                <td>Nama Unit</td>
                <td>: <b>{{ $s->nama_unit }}</b></td>
            </tr>
            <tr>
                <td>Keluhan</td>
                <td>: {{ $s->keluhan }}</td>
            </tr>
            <tr>
                <td>Teknisi</td>
                <td>: {{ $s->teknisi->name }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px; font-size: 12px; color: red;">
            *Harap bawa nota ini saat pengambilan unit.<br>
            *Unit yang tidak diambil lebih dari 3 bulan di luar tanggung jawab kami.
        </p>
    </div>

    <div class="footer">
        <p>Hormat Kami,</p>
        <br><br>
        <p>( {{ Auth::user()->name }} )</p>
    </div>

    <center><a href="#" class="btn-print" onclick="window.print()">Klik Cetak Nota</a></center>
</body>
</html>