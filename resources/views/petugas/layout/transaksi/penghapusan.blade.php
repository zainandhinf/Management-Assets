@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="row">
            <div class="col-md-4"> <button onclick="ShowModal1()" type="button" class="btn btn-warning btn-sm mt-2 mb-2 w-100"
                    data-bs-toggle="modal" data-bs-target="#listdata">
                    <i class="fa-solid fa-cart-flatbed"></i>
                    List Barang
                </button></div>
            <div class="col-md-8"> <a href="/penghapusan-tambah" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                    <i class="fa-solid fa-square-plus"></i>
                    Tambah Penghapusan Baru
                </a></div>
        </div>

        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No Penghapusan</th>
                    <th>Tanggal Penghapusan</th>
                    <th>Jenis Penghapusan</th>
                    <th>Keterangan</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($penghapusans as $penghapusan)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $penghapusan->no_penghapusan }}</td>
                    <td>{{ $penghapusan->tanggal_penghapusan }}</td>
                    <td>{{ $penghapusan->jenis_penghapusan }}</td>
                    <td>{{ $penghapusan->keterangan }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#showdata{{ $penghapusan->id }}"
                            class="btn btn-primary mt-1">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $penghapusan->id }}"
                            class="btn btn-danger mt-1">
                            <i class="fa fa-trash"></i>
                        </button>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#confirm{{ $penghapusan->id }}"
                            class="btn btn-success mt-1">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        </button> --}}
                    </td>
                </tr>
            @endforeach
        </table>


    </div>

    {{-- modal --}}

    {{-- modal add data --}}
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
                    <hr>

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
                        @foreach ($barangs as $barang)
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
                                    <b>{{ $barang->no_asset }}</b>
                                </td>
                                <td>{{ $nama_barang->nama_barang }}</td>
                                <td>{{ $barang->merk }}, {{ $barang->spesifikasi }}</td>
                                {{-- <td>{{ $barang->tanggal_pengadaan }}</td> --}}
                                <td>{{ $barang->jenis_pengadaan }}</td>
                                <td>{{ $barang->kondisi }}</td>
                                <td><button
                                        class="btn btn-sm rounded-pill @if ($barang->status == 'Belum Ditempatkan') btn-warning @elseif ($barang->status == 'Sudah Dihapus') btn-danger @else btn-success @endif text-white"
                                        style="cursor: default;">{{ $barang->status }}</button>
                                </td>
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



    {{-- modal --}}

    {{-- modal add data --}}

    {{-- end modal add data --}}

    {{-- modal edit data --}}

    {{-- end modal edit data --}}

    {{-- modal delete data detail --}}
    {{-- @foreach ($barangs as $barang)
        <div class="modal modal-blur fade" id="deletedata{{ $barang->id }}" tabindex="-1" role="dialog"
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
                            *<b>{{ $barang->merk }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletedetail" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_detail" value="{{ $barang->id }}">
                                    <input type="hidden" name="no_keranjang" value="{{ $keranjang->no_keranjang }}">
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
    @endforeach --}}
    {{-- end modal delete data detail --}}

    {{-- modal view data --}}
    @foreach ($penghapusans as $penghapusan)
        @php
            // $detail_barangs = DB::table('detail_barangs')
            //     ->join('penempatans', 'detail_barangs.kode_barcode', '=', 'penempatans.kode_barcode')
            //     ->select('penempatans.tanggal_penempatan', 'detail_barangs.*')
            //     ->where('detail_barangs.barcode', '=', $penghapusan->barcode)
            //     ->get();

            // dd($penghapusan);
            $detail_penghapusans = DB::table('detail_penghapusans')
                ->join('penghapusans', 'detail_penghapusans.no_penghapusan', '=', 'penghapusans.no_penghapusan')
                ->join('detail_barangs', 'detail_barangs.kode_barcode', '=', 'detail_penghapusans.kode_barcode')
                ->select(
                    'penghapusans.tanggal_penghapusan',
                    'penghapusans.jenis_penghapusan',
                    'penghapusans.keterangan as keterangan_penghapusan',
                    'detail_barangs.*',
                )
                ->where('detail_penghapusans.no_penghapusan', '=', $penghapusan->no_penghapusan)
                ->get();

        @endphp
        <div class="modal modal-blur fade" id="showdata{{ $penghapusan->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body">

                        <table class="table table-striped" id="data-tables">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Foto Profil</th> --}}
                                    <th>Kode</th>
                                    {{-- <th>Alamat</th> --}}
                                    {{-- <th>No Telepon</th> --}}
                                    <th>Merk</th>
                                    <th>Tanggal Penghapusan</th>
                                    {{-- <th>Jenis Pengadaan</th> --}}
                                    <th>Jenis Penghapusan</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Keterangan</th>
                                    {{-- <th>Keterangan</th> --}}
                                    <th data-searchable="false">Action</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($detail_penghapusans as $detail_penghapusan)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td>No Barang: <b>{{ $detail_penghapusan->no_barang }}</b> <br>Barcode:
                                        <b>{!! DNS1D::getBarcodeHTML($detail_penghapusan->kode_barcode, 'UPCA') !!}{{ $detail_penghapusan->kode_barcode }}</b> <br>No
                                        Asset: <b>{{ $detail_penghapusan->no_asset }}</b>
                                    </td>
                                    <td>{{ $detail_penghapusan->merk }}, {{ $detail_penghapusan->spesifikasi }}</td>
                                    <td>{{ $detail_penghapusan->tanggal_penghapusan }}</td>
                                    {{-- <td>{{ $detail_penghapusan->jenis_pengadaan }}</td> --}}
                                    <td>{{ $detail_penghapusan->jenis_penghapusan }}</td>
                                    <td>{{ $detail_penghapusan->keterangan_penghapusan }}</td>
                                    {{-- <td>Rp. {{ number_format($detail_penghapusan->harga) }}</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                                    {{-- <td>{{ $detail_penghapusan->keterangan }}</td> --}}
                                    <td>
                                        {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $detail_barang->id }}"
                                        style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button> --}}
                                        <button data-bs-toggle="modal" class="btn btn-warning mt-1"><i
                                                class="fa-solid fa-barcode"></i></button>
                                        <button data-bs-toggle="modal"
                                            data-bs-target="#deletedata{{ $detail_penghapusan->id }}"
                                            class="btn btn-danger mt-1">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal view data --}}

    {{-- modal confirm --}}
    @foreach ($penghapusans as $penghapusan)
        <div class="modal modal-blur fade" id="confirm{{ $penghapusan->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog w-50 modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-success icon-lg" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                        <path d="M12 9v4" />
                        <path d="M12 17h.01" />
                    </svg> --}}
                        <i class="fa fa-check text-success" style="font-size: 20px;"></i>
                        <h6>Are you sure?</h6>
                        <div class="text-muted">Yakin? Anda akan memulihkan barang yang sudah dihapus <br> (Merk:
                            *<b>{{ $penghapusan->no_penghapusan }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/pulihkan" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="no_penghapusan" value="{{ $penghapusan->no_penghapusan }}">
                                    {{-- <input type="hidden" name="no_keranjang" value="{{ $keranjang->no_keranjang }}"> --}}
                                    <button class="btn btn-success w-100">
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
    {{-- end modal confirm --}}

    {{-- end modal --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });
    </script>
@endsection
