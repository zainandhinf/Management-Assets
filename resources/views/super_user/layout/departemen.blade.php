@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
            data-bs-target="#adddata">
            <i class="fa-solid fa-folder-plus me-1"></i> Tambah Data
        </button>
        <table class="table table-striped" id="data-tables" style="font-size: 14px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Departemen</th>
                    <th>Departemen</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($departemens as $departemen)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    <td>{{ $departemen->no_departemen }}</td>
                    <td>{{ $departemen->departemen }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $departemen->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $departemen->id }}"
                            class="btn btn-danger">
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/adddepartemen" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">No. Departemen :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('no_departemen')
                  is-invalid
              @enderror"
                                placeholder="No. Departemen.." id="name" name="no_departemen">
                            @error('no_departemen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label for="name" class="col-form-label">Departemen :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('departemen')
                  is-invalid
              @enderror"
                                placeholder="Departemen.." id="name" name="departemen">
                            @error('departemen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
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
    @foreach ($departemens as $departemen)
        <div class="modal modal-blur fade" id="editdata{{ $departemen->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-6">Edit {{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/editdepartemen" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id_departemen" value="{{ $departemen->id }}">
                            <div class="form-group">
                                <label for="name" class="col-form-label">No. Departemen :</label>
                                <input style="font-size: 14px;" type="text"
                                    class="form-control @error('no_departemen') fs-6
                            is-invalid
                            @enderror"
                                    placeholder="No. Departemen.." id="name" name="no_departemen"
                                    value="{{ $departemen->no_departemen }}">
                                @error('no_departemen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label for="name" class="col-form-label">Departemen :</label>
                                <input style="font-size: 14px;" type="text"
                                    class="form-control @error('departemen') fs-6
                            is-invalid
                            @enderror"
                                    placeholder="Departemen.." id="name" name="departemen"
                                    value="{{ $departemen->departemen }}">
                                @error('departemen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
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
    @foreach ($departemens as $departemen)
        <div class="modal modal-blur fade" id="deletedata{{ $departemen->id }}" tabindex="-1" role="dialog"
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
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Nama Departemen:
                            *<b>{{ $departemen->departemen }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletedepartemen" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_departemen" value="{{ $departemen->id }}">
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
