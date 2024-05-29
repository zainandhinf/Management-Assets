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
                    <th>#</th>
                    {{-- <th>Foto Profil</th> --}}
                    <th>Foto</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>L/P</th>
                    {{-- <th>Alamat</th> --}}
                    {{-- <th>No Telepon</th> --}}
                    <th>Username</th>
                    <th>Role</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($petugass as $petugas)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>
                        @if($petugas->foto == null)

                        <img src="{{ asset('nophoto.png') }}" alt="No Photo" class="rounded rounded-circle" style="width: 60px; height: 60px;"
                        style="width: 50px;" alt="">

                        @else

                        <img src="{{ asset('storage/' . $petugas->foto) }}" class="rounded rounded-circle" style="width: 60px; height: 60px;"
                        style="width: 50px;" alt="">

                        @endif
                    </td>
                    <td>{{ $petugas->nik }}</td>
                    <td>{{ $petugas->nama_user }}</td>
                    <td>
                        @if ($petugas->jenis_kelamin === 'L')
                            L
                        @else
                            P
                        @endif
                    </td>
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    <td>{{ $petugas->username }}</td>
                    <td>
                        @if ($petugas->role == 'super_user')
                            Super User
                        @else
                            Koordinator
                        @endif
                    </td>
                    <td>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $petugas->id }}"
                            style="margin-right: 10px" class="btn btn-primary mr-2"><i
                                class="fa-regular fa-eye"></i></button> --}}

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
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <form action="/addpetugas" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <label for="name" class="col-form-label">NIK* :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nik')
                  is-invalid
              @enderror"
                                        placeholder="NIK.." id="name" name="nik" autocomplete="off" required>
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Nama Petugas* :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nama_user')
                  is-invalid
              @enderror"
                                        placeholder="Nama petugas.." id="name" name="nama_user" autocomplete="off" required>
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
                                    <label for="name" class="col-form-label">No Telepon :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('no_telepon')
                  is-invalid
              @enderror"
                                        placeholder="No telepon.." id="name" name="no_telepon" autocomplete="off">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                                <label for="name" class="col-form-label">Username* :</label>
                                <input style="font-size: 14px;" type="text"
                                    class="form-control @error('username')
                  is-invalid
              @enderror"
                                    placeholder="Username.." id="name" name="username" autocomplete="off" required>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label for="name" class="col-form-label">Password* :</label>
                                <input style="font-size: 14px;" type="password"
                                    class="form-control @error('password')
                  is-invalid
              @enderror"
                                    placeholder="Password.." id="name" name="password" required>
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
                                    <option value="petugas">Koordinator</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label for="name" class="col-form-label">Foto(opsionals) :</label>
                                <br>
                                <input style="font-size: 14px;" type="file"
                                    class="form-control mb-3 @error('foto') is-invalid @enderror"
                                    placeholder="Choose Photo.." id="foto" name="foto"
                                    onchange="previewImage()">
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <img class="img-preview img-fluid col-3 rounded rounded-circle"
                                            style="display: none;" id="img-preview">
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
                        <h5 class="modal-title fs-6">Edit {{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <form action="/editpetugas" method="post" enctype="multipart/form-data">
                            <div class="row">
                                @csrf
                                @method('PUT')
                                <input type="hidden" value="{{ $petugas->id }}" name="id_user">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">NIK :</label>
                                        <input style="font-size: 14px; background: #eee;" type="text"
                                            class="form-control @error('nik') is-invalid @enderror" placeholder="NIK.."
                                            id="name" name="nik" value="{{ $petugas->nik }}" required readonly>
                                        @error('nik')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Nama Petugas :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('nama_user') is-invalid @enderror"
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
                                                class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                name="jenis_kelamin">
                                                @if ($petugas->jenis_kelamin == 'L')
                                                    <option value="L">Laki-Laki</option>
                                                    <option value="P">Perempuan</option>
                                                @elseif($petugas->jenis_kelamin == 'P')
                                                    <option value="P">Perempuan</option>
                                                    <option value="L">Laki-Laki</option>
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
                                            value="{{ $petugas->username }}" autocomplete="off" required>
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
                                            name="role">
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
                                        {{-- <label for="name" class="col-form-label">Foto :</label>
                                        <br>
                                        <img class="img-preview img-fluid col-3 rounded rounded-circle"
                                        id="img-preview-edit" src="{{ asset('storage/' . $petugas->foto) }}">
                                        <br>
                                        <label for="name" class="col-form-label">New Foto :</label>
                                        <input style="font-size: 14px;" type="file"
                                            class="form-control mb-3 @error('foto') is-invalid @enderror"
                                            placeholder="Choose Photo.." id="foto-edit" name="foto"
                                            onchange="previewImageedit()">
                                        @error('foto')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror --}}
                                        <label for="name" class="col-form-label">Foto :</label>
                                        <br>
                                        <div class="row d-flex w-100 align-items-center">
                                            <div class="col-md-4">

                                                <img class=" img-fluid col-3 rounded rounded-circle"
                                            id="" src="{{ asset('storage/' . $petugas->foto) }}" style="width: 120px; height: 120px;">


                                            </div>
                                            <div class="col-md-4 text-center"><i class="fa-solid fa-circle-chevron-right"></i><br>Ubah menjadi</i></div>
                                            <div class="col-md-4">
                                                <img class="img-preview-edit img-fluid col-3 rounded rounded-circle" style="display: none;width: 120px; height: 120px; "
                                                id="img-preview-edit{{ $petugas->id }}">

                                            </div>


                                        </div>
                                        <br>
                                        <label for="name" class="col-form-label">New Foto(opsional) :</label>
                                        {{-- <input style="font-size: 14px;" type="file"
                                            class="form-control mb-3 @error('foto') is-invalid @enderror"
                                            placeholder="Choose Photo.." id="fotoedit" name="foto"
                                            onchange="previewImage2()"> --}}

                        <input type="hidden" name="oldPic" value="{{ $petugas->foto }}">


                                            <input style="font-size: 14px;" type="file"
                                    class="form-control mb-3 @error('foto') is-invalid @enderror"
                                    placeholder="Choose Photo.." id="fotoedit{{ $petugas->id }}" name="foto"
                                    onchange="previewImage2('{{ $petugas->id }}')">
                                @error('foto')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                {{-- <img class="img-preview img-fluid col-3 rounded rounded-circle"
                                style="display: none;" id="img-preview-edit"> --}}

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
                                    <input type="hidden" name="foto" value="{{ $petugas->foto }}">
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



    <script>
        function previewImage() {
            const image = document.getElementById("foto")
            console.log(image);
            const imgPreview = document.getElementById('img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            console.log(oFReader);
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
    {{-- PREVIEW IMAGE UNTUK EDIT --}}
    <script>
         function previewImage2(idpetugas) {
            console.log("haha");
            // const idpetugas = document.getElementById('id_petugas').value;
            // const haha = "fotoedit"
            console.log(idpetugas);
            var imageedit = "fotoedit" + idpetugas;
            var imgPreviewedit = "img-preview-edit" + idpetugas;
            const imageedit2 = document.getElementById(imageedit);
            const imgPreviewedit2 = document.getElementById(imgPreviewedit);

            imgPreviewedit2.style.display = 'block';

            const oFReader2 = new FileReader();
            oFReader2.readAsDataURL(imageedit2.files[0]);

            oFReader2.onload = function(oFREvent) {
                imgPreviewedit2.src = oFREvent.target.result;
            }
        }
    </script>
    {{-- END PREVIEW IMAGE UNTUK EDIT --}}

@endsection
