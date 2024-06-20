@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">

        @php
            use Carbon\Carbon;
            // $no_last = DB::table('keranjang_pengadaans')->select('*')->orderByDesc('no_pengadaan')->first();
            $no_last = DB::table('penempatans')
                ->select(DB::raw('RIGHT(no_penempatan, 4) + 1 as noUrut'))
                ->orderBy('no_penempatan', 'DESC')
                ->limit(1)
                ->get();

            // $no_count = DB::table('keranjang_pengadaans')->select('*')->count();
            // dd($no_last);

            if (!$no_last->isEmpty()) {
                $noUrut = $no_last[0]->noUrut;
                $floatValue = floatval($noUrut);
            }
            if ($no_last->isEmpty()) {
                $no_penempatan_last = '0001';
            } else {
                if ($noUrut < 10) {
                    $no_penempatan_last = '000' . $noUrut;
                } elseif ($noUrut < 100) {
                    $no_penempatan_last = '00' . $noUrut;
                } elseif ($noUrut < 1000) {
                    $no_penempatan_last = '0' . $noUrut;
                } elseif ($noUrut < 10000) {
                    $no_penempatan_last = $noUrut;
                } else {
                    $no_penempatan_last = '0001';
                }
            }

            $no_penempatan = 'PN-' . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis') . $no_penempatan_last;
        @endphp
        <div class="bg-secondary ps-2 text-white w-30">
            Informasi Penempatan
        </div>
        <div class="row mb-2">
            <div class="col-md-8">

                <table class="w-100">

                    <tr>
                        <td>No. Penempatan</td>
                        <td>: {{ $no_penempatan }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Penempatan</td>
                        <td>: {{ now()->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <td>Lokasi Penempatan</td>
                        <td>
                            @php
                                $ruangans = DB::table('ruangans')->select('*')->get();
                            @endphp
                            <select class="form-select" name="" id="lokasi-penempatan">
                                @foreach ($ruangans as $ruangan)
                                    <option value="{{ $ruangan->no_ruangan }}">{{ $ruangan->ruangan }} ({{ $ruangan->lokasi }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Pengguna (opsional)</td>
                        <td>
                            @php
                                $pegawais = DB::table('pegawais')->select('*')->get();
                            @endphp
                            <select class="form-select" name="" id="user-id">
                                <option value="{{ null }}">choose..</option>
                                @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id }}">{{ $pegawai->nik }} ({{ $pegawai->nama_user }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>
                            <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5" placeholder="keterangan.." required></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            {{-- <label for="">No Penempatan</label> --}}
        </div>
        <div class="bg-secondary ps-2 text-white w-30">
            Barang yang akan ditempatkan
        </div>

        <div class="row d-flex">
            <div class="col-md-8">
            <div class="form-group">

                <label for="">Scan Barcode / Kode Barang</label>
                <input type="text" value="" class="form-control" id="input-barcode-1" placeholder="Tekan TAB setelah selesai input.."
                    onchange="addkeranjangpenempatan()">


                </div>
            </div>
            <div class="col-md-4"> <button onclick="ShowModal1()" type="button" class="btn btn-warning btn-sm mt-4 mb-2 w-100"
                data-bs-toggle="modal" data-bs-target="#listdata">
                <i class="fa-solid fa-cart-flatbed"></i>
                Data Inventaris
            </button></div>
        </div>

        <hr>
        <button class="btn btn-primary mt-1" onclick="addpenempatan()">
            <i class="fa fa-plus me-2 mt-2"></i>Buat Penempatan
        </button>


        <h5>
            <strong class="fs-6">List Penempatan Barang</strong>
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
                    {{-- <th>Status</th> --}}
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
                        Asset: <b>{{ $keranjang->no_asset }}</b><br>Nomor
                        Kodifikasi: <b>{{ $keranjang->nomor_kodifikasi }}</b>
                    </td>
                    <td>{{ $keranjang->merk }}, {{ $keranjang->spesifikasi }}</td>
                    {{-- <td>{{ $keranjang->jenis_pengadaan }}</td> --}}
                    <td>{{ $keranjang->kondisi }}</td>
                    {{-- <td>{{ $keranjang->status }}</td> --}}
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
    <form action="/addkeranjangpenempatan" method="POST" id="addkeranjangpenempatan" style="display: none;">
        @csrf
        <input type="hidden" id="input-barcode-2" name="kode_barcode">
        <input type="hidden" id="input-no-penempatan-2" name="no_penempatan" value="{{ $no_penempatan }}">
    </form>
    <form action="/addpenempatan" method="POST" id="addpenempatan" style="display: none;">
        @csrf
        <input type="hidden" id="input-no-penempatan-2" name="no_penempatan" value="{{ $no_penempatan }}">
        <input type="hidden" id="input-lokasi-2" name="no_ruangan">
        <input type="hidden" id="input-user-2" name="user_id">
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
                                <form action="/deletekeranjangpenempatan" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="no_penempatan" value="{{ $keranjang->no_penempatan }}">
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

    {{-- modal list data --}}
    <div class="modal modal-blur fade" id="listdata" tabindex="-1" role="dialog" aria-hidden="true"
        style="font-size: 14px;">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6"><strong>List Barang</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="data-tables-keranjang">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th>Foto Profil</th> --}}
                                {{-- <th>Alamat</th> --}}
                                {{-- <th>No Telepon</th> --}}
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                {{-- <th>Tanggal Pengadaan</th> --}}
                                <th>Jenis Pengadaan</th>
                                <th>Kondisi</th>
                                <th>Status</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($detail_barangs as $barang)
                            @php
                                $nama_barang = DB::table('barangs')
                                    ->select('*')
                                    ->where('no_barang', '=', $barang->no_barang)
                                    ->first();
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                {{-- <td>{{ $city->id }}</td> --}}
                                {{-- <td>lorem</td> --}}
                                <td>No Barang: <b>{{ $barang->no_barang }}</b> <br>Barcode:
                                    <b>{!! DNS1D::getBarcodeHTML($barang->kode_barcode, 'UPCA') !!}{{ $barang->kode_barcode }}</b> <br>No Asset:
                                    <b>{{ $barang->no_asset }}</b><br>Nomor
                                    Kodifikasi: <b>{{ $barang->nomor_kodifikasi }}</b>
                                </td>
                                <td>{{ $nama_barang->nama_barang }}</td>
                                <td>{{ $barang->merk }}, {{ $barang->spesifikasi }}</td>
                                {{-- <td>{{ $barang->tanggal_pengadaan }}</td> --}}
                                <td>{{ $barang->jenis_pengadaan }}</td>
                                <td>{{ $barang->kondisi }}</td>
                                <td><button
                                        class="btn btn-sm rounded-pill @if ($barang->status == 'Belum Ditempatkan') btn-warning @elseif ($barang->status == 'Sudah Dihapus') btn-danger @else btn-success @endif text-white"
                                        style="cursor: default;">{{ $barang->status }}</button></td>
                                <td>Rp. {{ number_format($barang->harga) }}</td>
                                {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                <td>{{ $barang->keterangan }}</td>

                            </tr>
                        @endforeach
                    </table>
                </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    {{-- END END Modal List Data --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });

        function addkeranjangpenempatan() {
            var barcode1 = document.getElementById('input-barcode-1');
            var barcode2 = document.getElementById('input-barcode-2');
            var form = document.getElementById('addkeranjangpenempatan');

            barcode2.value = barcode1.value;

            form.submit();
        }

        function addpenempatan() {
            var lokasiPenempatan = document.getElementById('lokasi-penempatan');
            var lokasiPenempatan2 = document.getElementById('input-lokasi-2');
            var user = document.getElementById('user-id');
            var user2 = document.getElementById('input-user-2');
            var keterangan = document.getElementById('keterangan');
            var keterangan2 = document.getElementById('input-keterangan-2');
            var formpenempatan = document.getElementById('addpenempatan');

            lokasiPenempatan2.value = lokasiPenempatan.value;
            user2.value = user.value;
            keterangan2.value = keterangan.value;

            formpenempatan.submit();
        }
    </script>
@endsection
