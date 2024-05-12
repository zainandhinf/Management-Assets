@extends('super_user.main')

@section('content')
    {{-- @if (session()->has('success'))
        <div class="alert alert-success mt-5 me-5 position-absolute end-0 top-0" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger mt-5 me-5 position-absolute end-0 top-0" role="alert">
            {{ session('error') }}
        </div>
    @endif --}}
    <div class="d-flex mb-5">
        <div class="card p-4 flex-row" style="width: 750px;">
            <div class="profile-right col-4">
                @if (auth()->user()->foto == null)
                <img src="assets/image/user.png" class="img-fluid rounded rounded-circle me-2 ms-3" style="width: 200px; height: 200px;"
                alt="">
                @else
                <img src="{{ asset('storage/' . auth()->user()->foto) }}" class="img-fluid rounded rounded-circle me-2 ms-3" style="width: 200px; height: 200px;"
                alt="">
                @endif
                <label for="file" class="custom-file-upload ms-3 mt-2">
                    <form action="/uploadprofile" method="POST" enctype="multipart/form-data" id="uploadprofile">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="oldPic" value="{{ auth()->user()->foto }}">
                        <div class="icon">
                            <i class="fa-solid fa-camera-rotate text-white fs-5"></i>
                        </div>
                        <div class="text">
                            <span>Ubah foto profil</span>
                        </div>
                        <input id="file" type="file" onchange="handleFileChange()" name="foto">
                    </form>
                </label>

            </div>
            <div class="ms-3" style="width: 70%">
                <div class="form-group">
                    <label for="name" class="col-form-label">NIK :</label>
                    <input style="font-size: 14px;" type="text" class="form-control" id="name"
                        value="{{ auth()->user()->nik }}" disabled>
                </div>
                <div class="form-group">
                    <label for="name" class="col-form-label">Nama :</label>
                    <input style="font-size: 14px;" type="text" class="form-control" id="name"
                        value="{{ auth()->user()->nama_user }}" disabled>
                </div>
                <div class="form-group">
                    <label for="name" class="col-form-label">Jenis Kelamin :</label>
                    <input style="font-size: 14px;" type="text" class="form-control" id="name"
                        value="@if (auth()->user()->jenis_kelamin == 'L') Laki-Laki
                        @else Perempuan @endif"
                        disabled>
                </div>
                <div class="form-group">
                    <label for="name" class="col-form-label">Alamat :</label>
                    <input style="font-size: 14px;" type="text" class="form-control" id="name"
                        value="{{ auth()->user()->alamat }}" disabled>
                </div>
                <div class="form-group">
                    <label for="name" class="col-form-label">No Telepon :</label>
                    <input style="font-size: 14px;" type="text" class="form-control" id="name"
                        value="{{ auth()->user()->no_telepon }}" disabled>
                </div>
                <div class="form-group">
                    <label for="name" class="col-form-label">Username :</label>
                    <input style="font-size: 14px;" type="text" class="form-control" id="name"
                        value="{{ auth()->user()->username }}" disabled>
                </div>
                <div class="form-group">
                    <label for="name" class="col-form-label">Role :</label>
                    <input style="font-size: 14px;" type="text" class="form-control" id="name" value="Super User"
                        disabled>
                </div>
            </div>
        </div>
        <div class="card p-4 ms-2" style="height: 150px; width: 270px;">
            <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
                data-bs-target="#editdata">
                Edit Profile
            </button>
            <button onclick="ShowModal1()" type="button" class="btn btn-warning btn-sm mt-2 mb-2" data-bs-toggle="modal"
                data-bs-target="#editpass">
                Changes Password
            </button>
        </div>
    </div>

    {{-- modal --}}

    {{-- modal edit profile --}}
    <div class="modal modal-blur fade" id="editdata" tabindex="-1" role="dialog" aria-hidden="true"
        style="font-size: 14px;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Edit {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/editprofile" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                        <div class="form-group">
                            <label for="name" class="col-form-label">NIK :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('nik') fs-6
                        is-invalid
                        @enderror"
                                placeholder="NIK.." id="name" name="nik" value="{{ auth()->user()->nik }}"
                                required>
                            @error('nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nama :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('nama_user') fs-6
                        is-invalid
                        @enderror"
                                placeholder="Nama.." id="name" name="nama_user"
                                value="{{ auth()->user()->nama_user }}" required>
                            @error('nama_user')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Jenis Kelamin :</label>
                            <div class="input-group">
                                <select style="font-size: 14px;"
                                    class="form-select @error('jenis_kelamin')
                                is-invalid
                            @enderror"
                                    name="jenis_kelamin">
                                    @if (auth()->user()->jenis_kelamin == 'L')
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    @elseif(auth()->user()->jenis_kelamin == 'P')
                                        <option value="P">Perempuan</option>
                                        <option value="L">Laki-Laki</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Alamat :</label>
                            <textarea style="font-size: 14px;" type="text"
                                class="form-control @error('alamat') fs-6
                        is-invalid
                        @enderror"
                                placeholder="Alamat.." id="name" name="alamat">{{ auth()->user()->alamat }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">No Telepon :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('no_telepon') fs-6
                        is-invalid
                        @enderror"
                                placeholder="No Telepon.." id="name" name="no_telepon"
                                value="{{ auth()->user()->no_telepon }}">
                            @error('no_telepon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Username :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('username') fs-6
                        is-invalid
                        @enderror"
                                placeholder="Username.." id="name" name="username"
                                value="{{ auth()->user()->username }}" required>
                            @error('username')
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
    {{-- end modal edit profile --}}

    {{-- modal edit password --}}
    <div class="modal modal-blur fade" id="editpass" tabindex="-1" role="dialog" aria-hidden="true"
        style="font-size: 14px;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Changes Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/editpassword" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                        <div class="form-group">
                            <label for="name" class="col-form-label">New Password :</label>
                            <input style="font-size: 14px;" type="password"
                                class="form-control @error('new_password') fs-6
                        is-invalid
                        @enderror"
                                placeholder="New password.." id="name" name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Confirm new password :</label>
                            <input style="font-size: 14px;" type="password"
                                class="form-control @error('password') fs-6
                        is-invalid
                        @enderror"
                                placeholder="Confirm new password.." id="name" name="password">
                            @error('password')
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
    {{-- end modal edit profile --}}
    <script>
        function handleFileChange() {
            var form = document.getElementById('uploadprofile');
            form.submit();
        }
    </script>
@endsection
