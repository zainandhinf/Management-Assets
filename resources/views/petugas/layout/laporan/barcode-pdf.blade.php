<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Aktiva / Fasilitas Ruangan PDF</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        * {
            font-family: arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 97%;
            margin-left: 10px;
        }

        th {
            border: 1px solid black;
            /* border: 1px solid #dddddd; */
            text-align: center;
            padding: 8px;
        }

        td {
            border: 1px solid black;
            /* border: 1px solid #dddddd; */
            text-align: left;
            padding: 8px;
            font-size: 12px;
        }

        td:first-child {
            text-align: center;
            width: 5px;
        }

        tr:nth-child(even) {
            /* background-color: #dddddd; */
        }

        tr:first-child {}

        .logo img {
            width: 60px;
        }

        .logo .ptdi {
            margin-top: -55px;
            margin-left: 70px;
        }

        .logo p {
            font-size: 8px;
            /* font-weight: bold; */
        }

        .judul h1 {
            margin-bottom: -8px;
            font-size: 20px;
        }

        .judul p {
            font-size: 14px;
            margin-top: -8px;
        }

        .keterangan {
            margin-left: 120px;
            margin-bottom: 18px;
        }

        .keterangan p {
            font-size: 14px;
            margin: 0px;
        }

        .left {
            position: absolute;
            bottom: 0;
            margin-bottom: 180px;
            margin-left: 40px;
        }

        .right {
            position: absolute;
            bottom: 0;
            margin-bottom: 180px;
            margin-left: 420px;
        }

        .bottom {
            position: absolute;
            bottom: 0;
            margin-bottom: 60px;
            margin-left: 40px;
            width: 85%;
        }

        .line {
            display: inline-block;
            width: 100%;
            height: 1px;
            background-color: black;
            color: black;
        }

        .barcode {
            width: 190px;
            margin: 35px;
            display: inline-block;
        }

        .barcode p {
            text-align: center
        }

        .clear {
            clear: both;
        }

        .barcode:nth-child(4n)::after {
            content: "";
            display: table;
            clear: both;
        }
        
    </style>
</head>

<body>
    @php
        // dd($assets);
    @endphp
    {{-- <div style="display: block; overflow: hidden;"> --}}
        @foreach ($assets as $index => $asset)
            @php
                $barang = DB::table('barangs')
                    ->select('*')
                    ->where('no_barang', '=', $asset->no_barang)
                    ->first();
            @endphp
            <div class="barcode" style="float: left;">
                <p>{{ $barang->nama_barang }}, {{ $asset->merk }}</p>
                {!! DNS1D::getBarcodeHTML($asset->kode_barcode, 'UPCA') !!}
                <p>{{ $asset->kode_barcode }}</p>
            </div>
            
            @if (($index + 1) % 4 == 0)
            <div class="clear"></div>
        @endif
            
        @endforeach
    {{-- </div> --}}

    {{-- <div>Content 1</div>
    <div style="float: right; width: 50%;">Content 2</div> --}}


    {{-- <h1>Page 2</h1>
        <div class="page-break"></div>
    <h1>Hello World</h1> --}}
</body>

</html>

