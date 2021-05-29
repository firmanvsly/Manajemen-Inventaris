<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cetak</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body {
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>

<body>
    <h5 class="text-center">Data Inventaris {{ $type }}</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>

            @if ($data->count())
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->kategori }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>{{ $d->kondisi }}</td>
                        <td>{{ $d->keterangan }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="6">Tidak ada data</td>
                </tr>
            @endif

        </tbody>
    </table>
</body>

</html>
