@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
            data-bs-target="#adddata">
            <i class="fa-solid fa-folder-plus me-1"></i> Tambah Data
        </button>
        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>No</th>
                    {{-- <th>Foto Profil</th> --}}
                    <th>NIK</th>
                    <th>Nama</th>
                    {{-- <th>Jenis Kelamin</th> --}}
                    {{-- <th>Alamat</th> --}}
                    {{-- <th>No Telepon</th> --}}
                    <th>Username</th>
                    <th>Role</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @foreach ($petugass as $petugas)
                @php
                    $no = 1;
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>{{ $petugas->nik }}</td>
                    <td>{{ $petugas->nama_user }}</td>
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    <td>{{ $petugas->username }}</td>
                    <td>@if ($petugas->role == 'super_user')
                        Super User
                        @else
                        Koordinator
                    @endif</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $petugas->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $petugas->id }}"
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
                    <div class="modal-body">
                        <div class="row">
                            @csrf
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
                                            <option value="l">Laki-Laki</option>
                                            <option value="p">Perempuan</option>
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
    @foreach ($petugass as $petugas)
        <div class="modal modal-blur fade" id="editdata{{ $petugas->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/editpetugas" method="post">
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                @method('PUT')
                                <input type="hidden" value="{{ $petugas->id }}" name="id_user">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">NIK :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('nik')
              is-invalid
          @enderror"
                                            placeholder="NIK.." id="name" name="nik"
                                            value="{{ $petugas->nik }}" required>
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
                                            placeholder="Nama petugas.." id="name" name="nama_user"
                                            value="{{ $petugas->nama_user }}" required>
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
                                                @if ($petugas->jenis_kelamin == 'l')
                                                    <option value="l">Laki-Laki</option>
                                                    <option value="p">Perempuan</option>
                                                    @elseif($petugas->jenis_kelamin == 'p')
                                                    <option value="p">Perempuan</option>
                                                    <option value="l">Laki-Laki</option>
                                                @endif
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
                                            id="name" name="alamat">{{ $petugas->alamat }}</textarea>
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
                                            placeholder="No telepon.." id="name" name="no_telepon"
                                            value="{{ $petugas->no_telepon }}">
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
                                            placeholder="Username.." id="name" name="username"
                                            value="{{ $petugas->username }}" required>
                                        @error('username')
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
                                            {{-- <option value="{{ $petugas->role }}" selected>{{ $petugas->role }}
                                            </option>
                                            <option value="super_user">Super User</option>
                                            <option value="petugas">Petugas</option> --}}
                                            @if ($petugas->role == 'super_user')
                                                <option value="super_user">Super User</option>
                                                <option value="petugas">Petugas</option>
                                            @elseif($petugas->role == 'petugas')
                                                <option value="petugas">Petugas</option>
                                                <option value="super_user">Super User</option>
                                            @endif
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
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                style="font-size: 14px;">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" style="font-size: 14px;">Edit Data</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        </div>
    @endforeach
    {{-- end modal edit data --}}

    {{-- modal delete data --}}
    @foreach ($petugass as $petugas)
        <div class="modal modal-blur fade" id="deletedata{{ $petugas->id }}" tabindex="-1" role="dialog"
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
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Nama Petugas:
                            *<b>{{ $petugas->nama_user }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletepetugas" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_user" value="{{ $petugas->id }}">
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
