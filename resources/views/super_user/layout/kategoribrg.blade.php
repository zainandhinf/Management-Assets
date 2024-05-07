@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
            data-bs-target="#adddata">
            Tambah Data
        </button>
        @if (session()->has('success'))
            <div class="alert alert-success mt-1 mb-3" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-striped" id="data-tables" style="font-size: 14px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($ktgr_brngs as $ktgr_brng)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    <td>{{ $ktgr_brng->nama_kategori }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $ktgr_brng->id }}" style="margin-right: 10px"
                            class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $ktgr_brng->id }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>

                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- modal --}}

    {{-- modal add data --}}
    <div class="modal modal-blur fade" id="adddata" tabindex="-1" role="dialog" aria-hidden="true" style="font-size: 14px;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/addkategori" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nama Kategori Barang :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('nama_kategori')
                  is-invalid
              @enderror"
                                placeholder="Nama kategori.." id="name" name="nama_kategori">
                                @error('nama_kategori')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 14px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="font-size: 14px;">Create Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add data --}}

    {{-- modal edit data --}}
    @foreach ($ktgr_brngs as $ktgr_brng)
    <div class="modal modal-blur fade" id="editdata{{ $ktgr_brng->id }}" tabindex="-1" role="dialog" aria-hidden="true" style="font-size: 14px;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Edit {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/editkategori" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_ktgr" value="{{ $ktgr_brng->id }}">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nama Kategori Barang :</label>
                            <input style="font-size: 14px;" type="text"
                            class="form-control @error('nama_kategori') fs-6
                            is-invalid
                            @enderror"
                            placeholder="Nama kategori.." id="name" name="nama_kategori" value="{{ $ktgr_brng->nama_kategori }}">
                            @error('nama_kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 14px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" style="font-size: 14px;">Edit Data</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- end modal edit data --}}

    {{-- modal delete data --}}
    @foreach ($ktgr_brngs as $ktgr_brng)
    <div class="modal modal-blur fade" id="deletedata{{ $ktgr_brng->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <div class="text-muted">Yakin? Anda akan menghapus data ini (Nama Kategori: **{{ $ktgr_brng->nama_kategori }}**)...</div>
                </div>
                <div class="modal-footer">
                    <div class="w-100">
                        <div class="row">
                            <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Cancel
                                </button></div>
                            <form action="/deletekategori" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id_ktgr" value="{{ $ktgr_brng->id }}">
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
    {{-- end modal delete data --}}

    {{-- end modal --}}
    @endsection
