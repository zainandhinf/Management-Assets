@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        @if ($cek1 > 0 && $cek2 > 0)
            <div class="d-flex">

                <a href="#" onclick="ShowModal1()" type="button"
                    class="btn border-warning btn-sm w-100 me-1">
                    Training
                </a>
                <a href="/peserta-training" onclick="ShowModal1()" type="button" class="btn  btn-warning border-warning btn-sm w-100 ms-1">
                    Peserta
                </a>
            </div>
            <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
                data-bs-target="#adddata">
                <i class="fa-solid fa-folder-plus me-1"></i> Tambah Data
            </button>
            <table class="table table-striped" id="data-tables">
                <thead>
                    <tr>
                        <th>#</th>
                        {{-- <th>Foto Profil</th> --}}
                        <th>Nama Training</th>
                        <th>Tanggal Training</th>
                        <th>Waktu dan Tempat</th>
                        <th>Peserta</th>
                        <th>Instruktur</th>
                        <th>Koordinator</th>
                        {{-- <th>Keterangan</th> --}}
                        {{-- <th>Alamat</th> --}}
                        {{-- <th>No Telepon</th> --}}
                        <th data-searchable="false">Action</th>
                    </tr>
                </thead>
                @php
                    $no = 1;
                @endphp
                @foreach ($trainings as $training)
                    @php
                        $tempat = DB::table('ruangans')
                            ->select('*')
                            ->where('no_ruangan', '=', $training->no_ruangan)
                            ->get();
                        $nama_petugas = DB::table('users')
                            ->select('*')
                            ->where('id', '=', $training->id_petugas)
                            ->get();
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        {{-- <td>{{ $city->id }}</td> --}}
                        {{-- <td>lorem</td> --}}
                        <td>{{ $training->nama_training }} <br> ({{ $training->keterangan }})</td>
                        <td>{{ $training->tanggal_mulai }} - {{ $training->tanggal_selesai }}</td>
                        <td>{{ $training->waktu_mulai }} - {{ $training->waktu_selesai }}<br> {{ $tempat[0]->ruangan }}</td>
                        <td>{{ $training->total_peserta }}
                            <a data-bs-toggle="modal" data-bs-target="#viewpeserta{{ $training->id }}"
                                style="margin-right: 10px" class="border-none mr-2"><i class="fa fa-eye"></i></a>
                        </td>
                        <td>{{ $training->instruktur }}</td>
                        <td>{{ $nama_petugas[0]->nama_user }}</td>
                        {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                        {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#editdata{{ $training->id }}"
                                style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                            <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $training->id }}"
                                class="btn btn-danger mt-1">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <b>
                <h5>
                    *Note: Data Training hanya bisa dibuat ketika kamu sudah mengisi <a href="/ruangan">Data
                        Ruangan</a> dan <a href="/petugas">Data Koordinator</a> terlebih dahulu !
                </h5>
            </b>
        @endif

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
                <form action="/addtraining" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Nama Training :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nama_training')
                  is-invalid
              @enderror"
                                        placeholder="Nama training.." id="name" name="nama_training">
                                    @error('nama_training')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Tanggal Training :</label>
                                    <div class="d-flex">
                                        <input style="font-size: 14px;" type="date" id="tanggal_mulai"
                                            class="form-control @error('tanggal_mulai')
                  is-invalid
              @enderror"
                                            id="name" name="tanggal_mulai">
                                        <i class="fa-solid fa-forward p-2 mt-1"></i>
                                        <input style="font-size: 14px;" type="date" id="tanggal_selesai"
                                            class="form-control @error('tanggal_selesai')
                  is-invalid
              @enderror"
                                            id="name" name="tanggal_selesai">
                                    </div>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Waktu :</label>
                                    <div class="d-flex">
                                        <input style="font-size: 14px;" type="time"
                                            class="form-control @error('waktu_mulai')
                  is-invalid
              @enderror"
                                            id="name" name="waktu_mulai">
                                        <i class="fa-solid fa-forward p-2 mt-1"></i>
                                        <input style="font-size: 14px;" type="time"
                                            class="form-control @error('waktu_selesai')
                  is-invalid
              @enderror"
                                            id="name" name="waktu_selesai">
                                    </div>
                                    @php
                                        $ruangans = DB::table('ruangans')->select('*')->get();
                                    @endphp
                                    <label for="name" class="col-form-label">Pilih Ruangan :</label>

                                    <div class="input-group">
                                        <select style="font-size: 14px;" id="no_ruangan"
                                            class="form-select @error('no_ruangan')
                                    is-invalid
                                @enderror"
                                            name="no_ruangan">
                                            @foreach ($ruangans as $ruangan)
                                                <option value="{{ $ruangan->no_ruangan }}">{{ $ruangan->ruangan }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                    @error('waktu_mulai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @error('waktu_selesai')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @error('no_ruangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Instruktur :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('instruktur')
                  is-invalid
              @enderror"
                                        placeholder="Instruktur.." id="name" name="instruktur">
                                    @error('instruktur')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Koordinator :</label>
                                    @php
                                        $koordinators = DB::table('users')
                                            ->select('*')
                                            ->where('role', '=', 'petugas')
                                            ->get();

                                    @endphp
                                    <div class="input-group">
                                        <select style="font-size: 14px;"
                                            class="form-select @error('id_petugas')
                                    is-invalid
                                @enderror"
                                            name="id_petugas">
                                            @foreach ($koordinators as $koordinator)
                                                <option value="{{ $koordinator->id }}">{{ $koordinator->nama_user }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('id_petugas')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Keterangan :</label>
                                    <textarea style="font-size: 14px;" type="text"
                                        class="form-control @error('keterangan')
                  is-invalid
              @enderror"
                                        placeholder="Keterangan.." id="name" name="keterangan"></textarea>
                                    @error('keterangan')
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
                {{-- <button class="btn btn-warning btn-sm mt-2" id="cek-ketersediaan-btn" onclick="cekketersediaan()">Cek
                    Ketersediaan</button> --}}
            </div>

        </div>
    </div>
    {{-- end modal add data --}}

    {{-- modal edit data --}}
    @foreach ($trainings as $training)
        <div class="modal modal-blur fade" id="editdata{{ $training->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-6">Edit {{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/edittraining" method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{ $training->id }}" name="id_training">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Nama Training :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('nama_training')
                      is-invalid
                  @enderror"
                                            placeholder="Nama training.." id="name" name="nama_training"
                                            value="{{ $training->nama_training }}">
                                        @error('nama_training')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Tanggal Training :</label>
                                        <div class="d-flex">
                                            <input style="font-size: 14px;" type="date" id="tanggal_mulai"
                                                class="form-control @error('tanggal_mulai')
                      is-invalid
                  @enderror"
                                                id="name" name="tanggal_mulai"
                                                value="{{ $training->tanggal_mulai }}">
                                            <i class="fa-solid fa-forward p-2 mt-1"></i>
                                            <input style="font-size: 14px;" type="date" id="tanggal_selesai"
                                                class="form-control @error('tanggal_selesai')
                      is-invalid
                  @enderror"
                                                id="name" name="tanggal_selesai"
                                                value="{{ $training->tanggal_selesai }}">
                                        </div>
                                        @error('tanggal_selesai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Waktu :</label>
                                        <div class="d-flex">
                                            <input style="font-size: 14px;" type="time"
                                                class="form-control @error('waktu_mulai')
                      is-invalid
                  @enderror"
                                                id="name" name="waktu_mulai" value="{{ $training->waktu_mulai }}">
                                            <i class="fa-solid fa-forward p-2 mt-1"></i>
                                            <input style="font-size: 14px;" type="time"
                                                class="form-control @error('waktu_selesai')
                      is-invalid
                  @enderror"
                                                id="name" name="waktu_selesai"
                                                value="{{ $training->waktu_selesai }}">
                                        </div>
                                        @php
                                            $ruangans = DB::table('ruangans')->select('*')->get();
                                        @endphp
                                        <label for="name" class="col-form-label">Pilih Ruangan :</label>

                                        <div class="input-group">
                                            <select style="font-size: 14px;" id="no_ruangan"
                                                class="form-select @error('no_ruangan')
                                        is-invalid
                                    @enderror"
                                                name="no_ruangan">
                                                @foreach ($ruangans as $ruangan)
                                                    @if (old('no_ruangan', $training->no_ruangan) == $ruangan->no_ruangan)
                                                        <option value="{{ $ruangan->no_ruangan }}" selected>
                                                            {{ $ruangan->no_ruangan }}</option>
                                                    @else
                                                        <option value="{{ $ruangan->no_ruangan }}">
                                                            {{ $ruangan->no_ruangan }}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                        </div>
                                        @error('waktu_mulai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @error('waktu_selesai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @error('no_ruangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Instruktur :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('instruktur')
                      is-invalid
                  @enderror"
                                            placeholder="Instruktur.." id="name" name="instruktur"
                                            value="{{ $training->instruktur }}">
                                        @error('instruktur')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Koordinator :</label>
                                        @php
                                            $koordinators = DB::table('users')
                                                ->select('*')
                                                ->where('role', '=', 'petugas')
                                                ->get();

                                        @endphp
                                        <div class="input-group">
                                            <select style="font-size: 14px;"
                                                class="form-select @error('id_petugas')
                                        is-invalid
                                    @enderror"
                                                name="id_petugas">
                                                @foreach ($koordinators as $koordinator)
                                                    @if (old('id_petugas', $training->id_petugas) == $koordinator->id)
                                                        <option value="{{ $koordinator->id }}" selected>
                                                            {{ $koordinator->nama_user }}</option>
                                                    @else
                                                        <option value="{{ $koordinator->id }}">
                                                            {{ $koordinator->nama_user }}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('id_petugas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Keterangan :</label>
                                        <textarea style="font-size: 14px;" type="text"
                                            class="form-control @error('keterangan')
                      is-invalid
                  @enderror"
                                            placeholder="Keterangan.." id="name" name="keterangan">{{ $training->keterangan }}</textarea>
                                        @error('keterangan')
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
    @endforeach
    {{-- end modal edit data --}}

    {{-- modal delete data --}}
    @foreach ($trainings as $training)
        <div class="modal modal-blur fade" id="deletedata{{ $training->id }}" tabindex="-1" role="dialog"
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
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Nama Training:
                            *<b>{{ $training->nama_training }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletetraining" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_training" value="{{ $training->id }}">
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

    {{-- modal view data peserta training --}}
    @foreach ($trainings as $training)
        <div class="modal modal-blur fade" id="viewpeserta{{ $training->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <table class="table table-striped" id="data-tables-peserta">
                            @php
                                $no = 1;
                                $pesertas = DB::table('peserta_trainings')
                                    ->select(
                                        'pegawais.foto',
                                        'pegawais.nik',
                                        'pegawais.nama_user',
                                        'pegawais.jenis_kelamin',
                                        'pegawais.no_telepon',
                                        'pegawais.organisasi',
                                        'peserta_trainings.id as id_peserta',
                                        'trainings.nama_training',
                                        'trainings.id as id_training',
                                    )
                                    ->join('pegawais', 'pegawais.nik', '=', 'peserta_trainings.nik')
                                    ->join('trainings', 'trainings.id', '=', 'peserta_trainings.id_training')
                                    ->get();
                            @endphp
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>No Telepon</th>
                                    <th>Training</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($pesertas as $peserta)
                                @php
                                    $training = DB::table('trainings')
                                        ->select('*')
                                        ->where('id', '=', $peserta->id_training)
                                        ->get();
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td><img src="{{ asset('storage/' . $peserta->foto) }}" class="rounded rounded-circle"
                                            style="width: 50px;" alt=""></td>
                                    <td>{{ $peserta->nik }}</td>
                                    <td>{{ $peserta->nama_user }}</td>
                                    <td>
                                        @if ($peserta->jenis_kelamin === 'L')
                                            Laki-Laki
                                        @else
                                            Perempuan
                                        @endif
                                    </td>
                                    <td>{{ $peserta->no_telepon }}</td>
                                    <td>{{ $training[0]->nama_training }}</td>
                                </tr>
                                @endforeach
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal view data peserta training --}}

    {{-- end modal --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-peserta').DataTable();
        });
        // document.addEventListener("DOMContentLoaded", function() {
        //     const cekKetersediaanBtn = document.querySelector('#cek-ketersediaan-btn');
        //     const feedbackMessage = document.querySelector('#feedback-message');

        //     cekKetersediaanBtn.addEventListener('click', function() {
        //         const tanggalMulai = document.querySelector('#tanggal_mulai').value;
        //         const tanggalSelesai = document.querySelector('#tanggal_selesai').value;
        //         const idRuangan = document.querySelector('#id_ruangan').value;

        //         // Lakukan permintaan Ajax ke endpoint backend untuk memeriksa ketersediaan ruangan
        //         // Pastikan untuk mengirim tanggalMulai, tanggalSelesai, dan idRuangan ke backend

        //         // Misalnya, dengan menggunakan Fetch API
        //         fetch(
        //                 `/check-room-availability?tanggal_mulai=${tanggalMulai}&tanggal_selesai=${tanggalSelesai}&id_ruangan=${idRuangan}`
        //             )
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.available) {
        //                     feedbackMessage.textContent = "Ruangan tersedia!";
        //                 } else {
        //                     feedbackMessage.textContent =
        //                         "Ruangan tidak tersedia pada tanggal tersebut.";
        //                 }
        //             })
        //             .catch(error => {
        //                 console.error('Error:', error);
        //                 feedbackMessage.textContent =
        //                     "Terjadi kesalahan saat memeriksa ketersediaan ruangan.";
        //             });
        //     });
        // });

        // function cekketersediaan() {
        //     console.log("haha");
        //     const cekKetersediaanBtn = document.querySelector('#cek-ketersediaan-btn');
        //     const feedbackMessage = document.querySelector('#feedback-message');

        //     cekKetersediaanBtn.addEventListener('click', function() {
        //         const tanggalMulai = document.querySelector('#tanggal_mulai').value;
        //         const tanggalSelesai = document.querySelector('#tanggal_selesai').value;
        //         const idRuangan = document.querySelector('#id_ruangan').value;

        //         // Lakukan permintaan Ajax ke endpoint backend untuk memeriksa ketersediaan ruangan
        //         // Pastikan untuk mengirim tanggalMulai, tanggalSelesai, dan idRuangan ke backend

        //         // Misalnya, dengan menggunakan Fetch API
        //         fetch(
        //                 `/check-room-availability?tanggal_mulai=${tanggalMulai}&tanggal_selesai=${tanggalSelesai}&id_ruangan=${idRuangan}`
        //             )
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.available) {
        //                     feedbackMessage.textContent = "Ruangan tersedia!";
        //                 } else {
        //                     feedbackMessage.textContent =
        //                         "Ruangan tidak tersedia pada tanggal tersebut.";
        //                 }
        //             })
        //             .catch(error => {
        //                 console.error('Error:', error);
        //                 feedbackMessage.textContent =
        //                     "Terjadi kesalahan saat memeriksa ketersediaan ruangan.";
        //             });
        //     });
        // }
    </script>
@endsection
