@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">

        @php
            use Carbon\Carbon;
            // $no_last = DB::table('keranjang_pengadaans')->select('*')->orderByDesc('no_pengadaan')->first();
            $no_last = DB::table('peminjamans')
                ->select(DB::raw('RIGHT(no_peminjaman, 4) + 1 as noUrut'))
                ->orderBy('no_peminjaman', 'DESC')
                ->limit(1)
                ->get();

            // $no_count = DB::table('keranjang_pengadaans')->select('*')->count();
            // dd($no_last);

            if (!$no_last->isEmpty()) {
                $noUrut = $no_last[0]->noUrut;
                $floatValue = floatval($noUrut);
            }
            if ($no_last->isEmpty()) {
                $no_peminjaman_last = '0001';
            } else {
                if ($noUrut < 10) {
                    $no_peminjaman_last = '000' . $noUrut;
                } elseif ($noUrut < 100) {
                    $no_peminjaman_last = '00' . $noUrut;
                } elseif ($noUrut < 1000) {
                    $no_peminjaman_last = '0' . $noUrut;
                } elseif ($noUrut < 10000) {
                    $no_peminjaman_last = $noUrut;
                } else {
                    $no_peminjaman_last = '0001';
                }
            }

            $no_peminjaman = 'PJ-' . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis') . $no_peminjaman_last;
        @endphp
        <div class="bg-secondary ps-2 text-white w-30">
            Informasi Peminjaman
        </div>
        <div class="row mb-2">
            <div class="col-md-8">

                <table class="w-100">

                    <tr>
                        <td>No. Peminjaman</td>
                        <td>: {{ $no_peminjaman }}</td>
                    </tr>
                    <tr>
                        <td>Tgl. Peminjaman</td>
                        <td>: <input type="date" style="width: 170px;" style="width: 100px;" name="tanggal_peminjaman" value="{{ now()->format('Y-m-d') }}" id="tanggal_peminjaman"></td>
                    </tr>
                    <tr>
                        <td>Tgl. Pengembalian</td>
                        <td>: <input style="width: 170px;" type="date" name="tanggal_kembali" id="tanggal_kembali"></td>
                    </tr>
                    <tr>
                        <td>Peminjam</td>
                        <td>
                            @php
                                $pegawais = DB::table('pegawais')->select('*')->get();
                                // dd($pegawais);
                            @endphp
                            <select class="form-select" name="" id="peminjam">
                                <option value="" selected>-- Pilih Peminjam --
                                </option>
                                @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->nik }}">[ {{ $pegawai->nik }} ] {{ $pegawai->nama_user }} - {{ $pegawai->organisasi }}
                                    </option>
                                @endforeach
                            </select>
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
            Barang yang akan dipinjamkan
        </div>

        <div class="row">
            <div class="form-group">
                <label for="">Scan Barcode / Kode Barang</label>
                <input type="text" value="" class="form-control" id="input-barcode-1"
                    onchange="addkeranjangpeminjaman()">
            </div>
        </div>

        <button class="btn btn-primary mt-1" onclick="addpeminjaman()">
            <i class="fa fa-plus me-2 mt-2"></i>Create Data
        </button>

        <hr>

        <h5>
            <strong class="fs-6">List Peminjaman Barang</strong>
        </h5>

        <table class="table table-striped" id="data-tables-keranjang">
            <thead>
                <tr>
                    <th>#</th>
                    {{-- <th>Foto Profil</th> --}}
                    {{-- <th>Alamat</th> --}}
                    {{-- <th>No Telepon</th> --}}
                    <th>Kode</th>
                    <th>Merk</th>
                    {{-- <th>Tanggal Pengadaan</th> --}}
                    <th>Kondisi</th>
                    <th>Status</th>
                    {{-- <th>Harga</th> --}}
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($keranjangs as $keranjang)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>No Barang: <b>{{ $keranjang->no_barang }}</b> <br>Barcode:
                        <b>{!! DNS1D::getBarcodeHTML($keranjang->kode_barcode, 'UPCA') !!}{{ $keranjang->kode_barcode }}</b> <br>No
                        Asset: <b>{{ $keranjang->no_asset }}</b>
                    </td>
                    <td>{{ $keranjang->merk }}, {{ $keranjang->spesifikasi }}</td>
                    {{-- <td>{{ $keranjang->jenis_pengadaan }}</td> --}}
                    <td>{{ $keranjang->kondisi }}</td>
                    <td>{{ $keranjang->status }}</td>
                    {{-- <td>Rp. {{ number_format($keranjang->harga) }}</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>{{ $keranjang->keterangan }}</td> --}}
                    <td>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $keranjang->id }}"
                        style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button> --}}
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $keranjang->id }}"
                            class="btn btn-danger mt-1">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
    <form action="/addkeranjangpeminjaman" method="POST" id="addkeranjangpeminjaman" style="display: none;">
        @csrf
        <input type="hidden" id="input-barcode-2" name="kode_barcode">
        <input type="hidden" id="input-no-peminjaman-2" name="no_peminjaman" value="{{ $no_peminjaman }}">
    </form>
    <form action="/addpeminjaman" method="POST" id="addpeminjaman" style="display: block;">
        @csrf
        <input type="hidden" id="input-no-peminjaman-2" name="no_peminjaman" value="{{ $no_peminjaman }}">
        <input type="hidden" id="input-peminjam-2" name="id_pegawai">
        <input type="hidden" id="tanggal_peminjaman2" name="tanggal_peminjaman">
        <input type="hidden" id="tanggal_kembali2" name="tanggal_kembali">
        <input type="hidden" id="input-keterangan-2" name="keterangan">
    </form>

    {{-- modal delete data keranjang --}}
    @foreach ($keranjangs as $keranjang)
        <div class="modal modal-blur fade" id="deletedata{{ $keranjang->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog w-50 modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                            <path d="M12 9v4" />
                            <path d="M12 17h.01" />
                        </svg>
                        <h6>Are you sure?</h6>
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Merk:
                            *<b>{{ $keranjang->merk }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletekeranjangpeminjaman" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="no_peminjaman" value="{{ $keranjang->no_peminjaman }}">
                                    {{-- <input type="hidden" name="no_keranjang" value="{{ $keranjang->no_keranjang }}"> --}}
                                    <button class="btn btn-danger w-100">
                                        Yakin
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- end modal delete data keranjang --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });

        function addkeranjangpeminjaman() {
            var barcode1 = document.getElementById('input-barcode-1');
            var barcode2 = document.getElementById('input-barcode-2');
            var form = document.getElementById('addkeranjangpeminjaman');

            barcode2.value = barcode1.value;

            form.submit();
        }

        function addpeminjaman() {
            console.log("haha");
            var peminjam = document.getElementById('peminjam');
            var peminjam2 = document.getElementById('input-peminjam-2');

            var tanggal_peminjaman = document.getElementById('tanggal_peminjaman');
            var tanggal_peminjaman2 = document.getElementById('tanggal_peminjaman2');

            var tanggal_kembali = document.getElementById('tanggal_kembali');
            var tanggal_kembali2 = document.getElementById('tanggal_kembali2');

            var keterangan = document.getElementById('keterangan');
            var keterangan2 = document.getElementById('input-keterangan-2');
            var formpeminjaman = document.getElementById('addpeminjaman');



            peminjam2.value = peminjam.value;

            tanggal_peminjaman2.value = tanggal_peminjaman.value;
            tanggal_kembali2.value = tanggal_kembali.value;

            keterangan2.value = keterangan.value;

            formpeminjaman.submit();
        }
    </script>
@endsection
