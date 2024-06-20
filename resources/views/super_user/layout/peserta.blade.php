@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="d-flex">

            <a href="/training" onclick="ShowModal1()" type="button" class="btn btn-warning border-warning btn-sm w-100 me-1">
                Training
            </a>
            <a href="#" onclick="ShowModal1()" type="button" class="btn border-warning btn-sm w-100 ms-1">
                Peserta
            </a>
        </div>
        @if ($cek > 0 && $cek_pegawai > 0)
            <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
                data-bs-target="#adddata">
                <i class="fa-solid fa-folder-plus me-1"></i> Tambah Data
            </button>
            <table class="table table-striped" id="data-tables">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>L/P</th>
                        <th>Organisasi</th>
                        <th>Training</th>
                        <th data-searchable="false">Action</th>
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
                            ->first();
                        $nama_training = DB::table('data_trainings')
                            ->select('*')
                            ->where('id', '=', $training->training_id)
                            ->first();
                        $organisasi = DB::table('pegawais')
                                        ->join('departemens', 'departemens.id', '=', 'pegawais.id_departemen')
                                        ->select('departemens.departemen')
                                        ->first();

                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        {{-- <td>{{ $city->id }}</td> --}}
                        {{-- <td>lorem</td> --}}
                        <td><img src="{{ asset('storage/' . $peserta->foto) }}" style="width: 45px; height: 45px;"
                                class="rounded rounded-circle" style="width: 50px;" alt=""></td>
                        <td>{{ $peserta->nik }}</td>
                        <td>{{ $peserta->nama_user }}</td>
                        <td>
                            @if ($peserta->jenis_kelamin === 'L')
                                L
                            @else
                                P
                            @endif
                        </td>
                        <td>{{ $organisasi->departemen }}</td>
                        <td>{{ $nama_training->nama_training }}</td>
                        <td>
                            {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $peserta->id }}" style=""
                        class="btn btn-primary"><i class="fa-regular fa-eye"></i></button> --}}
                            {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $peserta->id_peserta }}"
                                style="" class="btn btn-warning mt-1"><i class="fa fa-edit"></i></button> --}}
                            <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $peserta->id_peserta }}"
                                class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <b class="mt-3">
                <h5>
                    *Note: Data Peserta Training hanya bisa dibuat ketika kamu sudah mengisi <a href="/pegawai">Data
                        Pegawai</a> terlebih dahulu !
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
                <div class="modal-body">
                    <form action="/addpeserta" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">

                                    <label for="nik" class="col-form-label">NIK :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nik') is-invalid @enderror"
                                        placeholder="Tekan TAB setelah selesai input.." id="nik" required>
                                    {{-- @php
                                        $peserta_trainings = DB::table('pegawais')->select('*')->get();
                                    @endphp
                                    <div class="input-group">
                                        <select style="font-size: 14px;"
                                            class="form-select @error('nik') is-invalid @enderror" name="nik">
                                            @foreach ($peserta_trainings as $peserta_training)
                                                <option value="{{ $peserta_training->nik }}">[ {{ $peserta_training->nik }} ] {{ $peserta_training->nama_user }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    {{-- <label for="foto" class="col-form-label">Foto :</label><br> --}}
                                    <label for="nama" class="col-form-label">Nama :</label>
                                    <input type="text" id="nama" class="form-control" disabled>
                                    <label for="jenis_kelamin" class="col-form-label">Jenis Kelamin :</label>
                                    <input type="text" id="jenis_kelamin" class="form-control" disabled>

                                </div>
                            </div>
                            <div class="col-6" style="display: flex; align-items: center; justify-content: center;">

                                <img id="foto" src="" class="rounded rounded-circle" width="230px"
                                    height="230px"><br>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="alamat" class="col-form-label">Alamat :</label>
                                    <input type="text" id="alamat" class="form-control" disabled>
                                    <label for="no_telepon" class="col-form-label">No Telepon :</label>
                                    <input type="text" id="no_telepon" class="form-control" disabled>

                                    <label for="organisasi" class="col-form-label">Organisasi :</label>
                                    <input type="text" id="organisasi" class="form-control" disabled>
                                    <input type="hidden" id="nik-2" name="nik" class="form-control">
                                </div>
                            </div>
                        </div>
                        <hr>

                        <center><b>

                                <label for="id_training" class="col-form-label ">
                                    <h5>
                                        Judul Training</h5>
                                </label>
                            </b></center>
                        @php
                            $trainings = DB::table('trainings')->select('*')->get();
                            // dd($trainings);
                        @endphp
                        <div class="input-group">
                            <select style="font-size: 14px;"
                                class="form-select @error('id_training') is-invalid @enderror" name="id_training">
                                @foreach ($trainings as $training)
                                    @php
                                        $nama_training = DB::table('data_trainings')
                                            ->select('*')
                                            ->where('id', $training->training_id)
                                            ->first();
                                    @endphp
                                    <option value="{{ $training->id }}">{{ $nama_training->nama_training }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('id_training')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
    {{-- end modal add data --}}

    {{-- modal edit data --}}
    @foreach ($pesertas as $peserta)
        <div class="modal modal-blur fade" id="editdata{{ $peserta->id_peserta }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-6">Edit {{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/editpeserta" method="post">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="{{ $peserta->id_peserta }}" name="id_peserta">
                            <div class="row">
                                {{-- <div class="col-md-6"> --}}
                                <div= class="form-group">
                                    <label for="name" class="col-form-label">Nama Peserta :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nama')
                  is-invalid
              @enderror"
                                        placeholder="Nama training.." id="name" name="nama"
                                        value="{{ $peserta->nama_user }}" required>
                                    @error('nama')
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
                                            @if ($peserta->jenis_kelamin == 'L')
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            @elseif($peserta->jenis_kelamin == 'P')
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
                            </div>
                            {{-- <label for="name" class="col-form-label">NBPT :</label>
                                        <div class="input-group">
                                            <input style="font-size: 14px;" type="text"
                                                class="form-control @error('nbpt')
                                        is-invalid
                                        @enderror"
                                                id="name" name="nbpt" placeholder="NBPT.."
                                                value="{{ $peserta->nbpt }}" required>
                                        </div>
                                        @error('nbpt')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="col-form-label">Tempat Lahir :</label>
                                    <div class="input-group">
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('tempat_lahir')
                                        is-invalid
                                        @enderror"
                                            id="name" name="tempat_lahir" placeholder="Tempat lahir.."
                                            value="{{ $peserta->tempat_lahir }}">
                                    </div>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Tanggal Lahir :</label>
                                    <input style="font-size: 14px;" type="date"
                                        class="form-control @error('tanggal_lahir')
                  is-invalid
              @enderror"
                                        placeholder="Tanggal lahir.." id="name" name="tanggal_lahir"
                                        value="{{ $peserta->tanggal_lahir }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Training :</label>
                                    @php
                                        $trainings = DB::table('trainings')->select('*')->get();
                                    @endphp
                                    <div class="input-group">
                                        <select style="font-size: 14px;"
                                            class="form-select @error('id_training')
                                    is-invalid
                                @enderror"
                                            name="id_training">
                                            @foreach ($trainings as $training)
                                                <option value="{{ $training->id }}">{{ $training->nama_training }}
                                                </option>
                                                @if (old('id_training', $peserta->id_training) == $training->id)
                                                    <option value="{{ $training->id }}" selected>
                                                        {{ $training->nama_training }}</option>
                                                @else
                                                    <option value="{{ $training->id }}">
                                                        {{ $training->nama_training }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('id_training')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
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
    @foreach ($pesertas as $peserta)
        <div class="modal modal-blur fade" id="deletedata{{ $peserta->id_peserta }}" tabindex="-1" role="dialog"
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
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Nama peserta:
                            *<b>{{ $peserta->nama_user }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletepeserta" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_peserta" value="{{ $peserta->id_peserta }}">
                                    <input type="hidden" value="{{ $peserta->id_training }}" name="id_training">
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
        $(document).ready(function() {
            $('#nik').on('change', function() {
                var nik = $(this).val();
                if (nik) {
                    $.ajax({
                        url: '/getUserByNik',
                        type: 'GET',
                        data: {
                            nik: nik
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                var user = response.data;
                                var fotoUrl = "{{ asset('storage') }}/" + user.foto;
                                $('#nik-2').val(user.nik);
                                $('#nama').val(user.nama_user);
                                $('#jenis_kelamin').val(user.jenis_kelamin);
                                $('#alamat').val(user.alamat);
                                $('#no_telepon').val(user.no_telepon);
                                $('#organisasi').val(user.departemen);
                                $('#foto').attr('src', fotoUrl);
                                // $('#nik').prop('disabled', true);
                                } else {
                                console.log("haha");
                                alert(response.message);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
