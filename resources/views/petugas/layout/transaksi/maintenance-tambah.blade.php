@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">

        @php
            use Carbon\Carbon;
            // $no_last = DB::table('keranjang_pengadaans')->select('*')->orderByDesc('no_pengadaan')->first();
            $no_last = DB::table('maintenances')
                ->select(DB::raw('RIGHT(no_maintenance, 4) + 1 as noUrut'))
                ->orderBy('no_maintenance', 'DESC')
                ->limit(1)
                ->get();

            // $no_count = DB::table('keranjang_pengadaans')->select('*')->count();
            // dd($no_last);

            if (!$no_last->isEmpty()) {
                $noUrut = $no_last[0]->noUrut;
                $floatValue = floatval($noUrut);
            }
            if ($no_last->isEmpty()) {
                $no_maintenance_last = '0001';
            } else {
                if ($noUrut < 10) {
                    $no_maintenance_last = '000' . $noUrut;
                } elseif ($noUrut < 100) {
                    $no_maintenance_last = '00' . $noUrut;
                } elseif ($noUrut < 1000) {
                    $no_maintenance_last = '0' . $noUrut;
                } elseif ($noUrut < 10000) {
                    $no_maintenance_last = $noUrut;
                } else {
                    $no_maintenance_last = '0001';
                }
            }

            $no_maintenance =
                'MA-' . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis') . $no_maintenance_last;
        @endphp
        <div class="bg-secondary ps-2 text-white w-30">
            Informasi Maintenance
        </div>
        <form action="/addmaintenance" method="POST">
            @csrf
            <div class="row mb-2">
                <div class="col-md-8">

                    <table class="w-100">

                        <tr>
                            <td>No. Maintenace</td>
                            <td>: {{ $no_maintenance }}</td>
                            <input type="hidden" value="{{ $no_maintenance }}" name="no_maintenance">
                        </tr>
                        <tr>
                            <td>Tanggal Maintenance</td>
                            <td>: {{ now()->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <td>Biaya</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text" style="font-size: 14px;" id="basic-addon1">Rp.</span>
                                    <input type="number" name="biaya" class="form-control form-control-sm"
                                        placeholder="000.000,00" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Keterangan</td>
                            <td>
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5" required></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                {{-- <label for="">No Penempatan</label> --}}
            </div>
            <div class="bg-secondary ps-2 text-white w-30">
                Barang yang akan dimaintenance
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="">Scan Barcode / Kode Barang</label>
                    <input type="text" value="" class="form-control" id="input-barcode" onchange="adddatabarang()"
                        name="kode_barcode">
                </div>
                <div class="form-group">
                    <label for="">Nama Barang</label>
                    <input type="text" value="" class="form-control" id="input-nama" readonly>
                </div>
                <div class="form-group">
                    <label for="">No. Asset</label>
                    <input type="text" value="" class="form-control" id="input-asset" readonly>
                </div>
                {{-- <div class="form-group">
                <label for="">Kondisi</label>
                <input type="text" value="" class="form-control" id="input-kondisi">
            </div> --}}
            </div>

            <button class="btn btn-primary mt-1" onclick="addmaintenance()">
                <i class="fa fa-plus me-2 mt-2"></i>Create Data
            </button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });

        function addkeranjangmutasi() {
            var barcode1 = document.getElementById('input-barcode-1');
            var barcode2 = document.getElementById('input-barcode-2');
            var form = document.getElementById('addkeranjangmutasi');

            barcode2.value = barcode1.value;

            form.submit();
        }

        function addmutasi() {
            var lokasimutasi = document.getElementById('lokasi-mutasi');
            var lokasimutasi2 = document.getElementById('input-lokasi-2');
            var keterangan = document.getElementById('keterangan');
            var keterangan2 = document.getElementById('input-keterangan-2');
            var formmutasi = document.getElementById('addmutasi');

            lokasimutasi2.value = lokasimutasi.value;
            keterangan2.value = keterangan.value;

            formmutasi.submit();
        }

        function adddatabarang() {
            var kode_barcode = $('#input-barcode').val();
            if (kode_barcode) {
                $.ajax({
                    url: '/getBarangByBarcode',
                    type: 'GET',
                    data: {
                        kode_barcode: kode_barcode
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            var barang = response.data;
                            console.log(barang);
                            $('#input-nama').val("(" + barang.nama_barang + ") " + barang.merk + ", " + barang
                                .spesifikasi);
                            $('#input-asset').val(barang.no_asset);
                            // $('#input_kondisi').val(barang.kondisi);
                            // Set kode_barcode input to readonly
                            // $('#kode_barcode').prop('readonly', true);
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
