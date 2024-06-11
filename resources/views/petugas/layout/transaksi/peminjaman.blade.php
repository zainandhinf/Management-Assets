@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="row">
            <div class="col-md-4"> <button onclick="ShowModal1()" type="button" class="btn btn-warning btn-sm mt-2 mb-2 w-100"
                    data-bs-toggle="modal" data-bs-target="#listdata">
                    <i class="fa-solid fa-cart-flatbed"></i>
                    List Barang
                </button></div>
            <div class="col-md-8"> <a href="/peminjaman-tambah" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                    <i class="fa-solid fa-square-plus"></i>
                    Tambah Peminjaman Baru
                </a></div>
        </div>

        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Peminjaman</th>
                    <th>Merk</th>
                    <th>Tgl. Pinjam-kembali</th>
                    <th>Pegawai</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th data-searhable="false">
                        Action
                    </th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($data_peminjaman as $peminjaman)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>No. Peminjaman <b>{{ $peminjaman->no_peminjaman }}</b><br>No Barang: <b>{{ $peminjaman->no_barang }}</b> <br>Barcode:
                        <b>{!! DNS1D::getBarcodeHTML($peminjaman->kode_barcode, 'UPCA') !!}{{ $peminjaman->kode_barcode }}</b> <br>No
                        Asset: <b>{{ $peminjaman->no_asset }}</b>
                    </td>
                    <td>{{ $peminjaman->merk }}, {{ $peminjaman->spesifikasi }}</td>
                    <td>{{ $peminjaman->tanggal_peminjaman }} - {{ $peminjaman->tanggal_kembali }}</td>
                    {{-- <td>{{ $peminjaman->jenis_pengadaan }}</td> --}}
                    <td>{{ $peminjaman->id_pegawai }}</td>
                    <td>{{ $peminjaman->status_peminjaman }}</td>
                    <td>{{ $peminjaman->keterangan }}</td>
                    {{-- <td>Rp. {{ number_format($peminjaman->harga) }}</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>{{ $barang->keterangan }}</td> --}}
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $peminjaman->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-print"></i></button>
                        @if ($peminjaman->status_peminjaman == "Dipinjam")
                            <button data-bs-toggle="modal" data-bs-target="#confirm{{ $peminjaman->id }}"
                                class="btn btn-success mt-1">
                                <i class="fa fa-check"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>


    </div>




{{-- modal --}}

{{-- modal add data --}}
<div class="modal modal-blur fade" id="adddata" tabindex="-1" role="dialog" aria-hidden="true"
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
                        <td class="@if ($barang->status == 'Belum Ditempatkan') bg-warning @else bg-success @endif text-white">
                            {{ $barang->status }}</td>
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

{{-- end modal delete data detail --}}
 {{-- modal confirm --}}
 @foreach ($data_peminjaman as $peminjaman)
 <div class="modal modal-blur fade" id="confirm{{ $peminjaman->id }}" tabindex="-1" role="dialog"
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
                 <div class="text-muted">Yakin? Konfirmasi peminjaman telah selesai <br> (Merk:
                     *<b>{{ $peminjaman->merk }}</b>)...</div>
             </div>
             <div class="modal-footer">
                 <div class="w-100">
                     <div class="row">
                         <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                 aria-label="Close">
                                 Cancel
                             </button></div>
                         <form action="/givebackpeminjaman" method="post">
                             @csrf
                             @method('PUT')
                             <input type="hidden" name="no_peminjaman" value="{{ $peminjaman->no_peminjaman }}">
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



{{-- modal --}}

{{-- end modal --}}

<script>
    $(document).ready(function() {
        $('#data-tables-keranjang').DataTable();
    });
</script>
@endsection
