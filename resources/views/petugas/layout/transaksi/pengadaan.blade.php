@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="row">
            <div class="col-md-4"> <button onclick="ShowModal1()" type="button" class="btn btn-warning btn-sm mt-2 mb-2 w-100" data-bs-toggle="modal"
                data-bs-target="#adddata">
                <i class="fa-solid fa-cart-flatbed"></i>
                 Lihat Keranjang
            </button></div>
            <div class="col-md-8"> <a href="/pengadaan-tambah" class="btn btn-primary btn-sm mt-2 mb-2 w-100"   >
                <i class="fa-solid fa-square-plus"></i>
                 Tambah Pengadaan Baru
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
                    <th>Tanggal Pengadaan</th>
                    <th>Jenis Pengadaan</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($barangs as $barang)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>No Barang: <b>{{ $barang->no_barang }}</b> <br>Barcode: <b>{{ $barang->kode_barcode }}</b> <br>No Asset: <b>{{ $barang->no_asset }}</b> </td>
                    <td>{{ $barang->merk }}, {{ $barang->spesifikasi }}</td>
                    <td>{{ $barang->tanggal_pengadaan }}</td>
                    <td>{{ $barang->jenis_pengadaan }}</td>
                    <td>{{ $barang->kondisi }}</td>
                    <td>{{ $barang->status }}</td>
                    <td>Rp. {{ number_format($barang->harga) }}</td>
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    <td>{{ $barang->keterangan }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $barang->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $barang->id }}"
                            class="btn btn-danger mt-1">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- modal --}}

    {{-- modal add data --}}
    <div class="modal modal-blur fade" id="adddata" tabindex="-1" role="dialog" aria-hidden="true"
        style="font-size: 14px;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/addpetugas" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">NIK :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nik')
                  is-invalid
              @enderror"
                                        placeholder="NIK.." id="name" name="nik">
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Nama Petugas :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nama_user')
                  is-invalid
              @enderror"
                                        placeholder="Nama petugas.." id="name" name="nama_user">
                                    @error('nama_user')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Jenis Kelamin :</label>
                                    <div class="input-group">
                                        <select style="font-size: 14px;"
                                            class="form-select @error('jenis_kelamin')
                                    is-invalid
                                @enderror"
                                            name="jenis_kelamin">
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Alamat :</label>
                                    <textarea style="font-size: 14px;" type="text"
                                        class="form-control @error('alamat')
                  is-invalid
              @enderror" placeholder="Alamat.."
                                        id="name" name="alamat"></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">No Telepon :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('no_telepon')
                  is-invalid
              @enderror"
                                        placeholder="No telepon.." id="name" name="no_telepon">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Username :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('username')
                  is-invalid
              @enderror"
                                        placeholder="Username.." id="name" name="username">
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Password :</label>
                                    <input style="font-size: 14px;" type="password"
                                        class="form-control @error('password')
                  is-invalid
              @enderror"
                                        placeholder="Password.." id="name" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Role :</label>
                                    <select style="font-size: 14px;"
                                        class="form-select @error('role')
                                    is-invalid
                                @enderror"
                                        id="inputGroupSelect01" name="role">
                                        <option value="super_user">Super User</option>
                                        <option value="petugas">Petugas</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" style="font-size: 14px;">Create Data</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </div>
    {{-- end modal add data --}}

    {{-- modal edit data --}}

    {{-- end modal edit data --}}

    {{-- modal delete data --}}

    {{-- end modal delete data --}}

    {{-- end modal --}}
@endsection
