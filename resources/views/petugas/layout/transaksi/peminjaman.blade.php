@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="row">
            <div class="col-md-4"> <button onclick="ShowModal1()" type="button" class="btn btn-warning btn-sm mt-2 mb-2 w-100"
                    data-bs-toggle="modal" data-bs-target="#adddata">
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
                    {{-- <th>Foto Profil</th> --}}
                    <th>Kode</th>
                    {{-- <th>Alamat</th> --}}
                    {{-- <th>No Telepon</th> --}}
                    <th>Merk</th>
                    <th>Tanggal Penempatan</th>
                    {{-- <th>Jenis Pengadaan</th> --}}
                    <th>Lokasi Penempatan</th>
                    {{-- <th>Status</th> --}}
                    <th>Keterangan</th>
                    {{-- <th>Keterangan</th> --}}
                    {{-- <th data-searchable="false">Action</th> --}}
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($data_peminjaman as $peminjaman)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>No Barang: <b>{{ $peminjaman->no_barang }}</b> <br>Barcode:
                        <b>{!! DNS1D::getBarcodeHTML($peminjaman->kode_barcode, 'UPCA') !!}{{ $peminjaman->kode_barcode }}</b> <br>No
                        Asset: <b>{{ $peminjaman->no_asset }}</b>
                    </td>
                    <td>{{ $peminjaman->merk }}, {{ $peminjaman->spesifikasi }}</td>
                    <td>{{ $peminjaman->tanggal_penempatan }}</td>
                    {{-- <td>{{ $peminjaman->jenis_pengadaan }}</td> --}}
                    <td>{{ $peminjaman->lokasi_penempatan }}</td>
                    <td>{{ $peminjaman->keterangan }}</td>
                    {{-- <td>Rp. {{ number_format($peminjaman->harga) }}</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>{{ $barang->keterangan }}</td> --}}
                    {{-- <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $barang->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $barang->id }}"
                            class="btn btn-danger mt-1">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td> --}}
                </tr>
            @endforeach
        </table>


    </div>




{{-- modal --}}

{{-- modal add data --}}

{{-- end modal add data --}}

{{-- modal edit data --}}

{{-- end modal edit data --}}

{{-- modal delete data detail --}}

{{-- end modal delete data detail --}}

{{-- end modal --}}

<script>
    $(document).ready(function() {
        $('#data-tables-keranjang').DataTable();
    });
</script>
@endsection
