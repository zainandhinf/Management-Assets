@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="d-flex">

            <a href="/training" onclick="ShowModal1()" type="button" class="btn border-warning btn-sm w-100 me-1">
                Training
            </a>
            <a href="#" onclick="ShowModal1()" type="button" class="btn border-warning btn-warning btn-sm w-100 ms-1">
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
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>NBPT</th>
                    <th>Tempat, Tanggal Lahir</th>
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
                        ->get();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>{{ $peserta->nama }}</td>
                    <td>
                        @if ($peserta->jenis_kelamin === 'L')
                            Laki-Laki
                        @else
                            Perempuan
                        @endif
                    </td>
                    <td>{{ $peserta->nbpt }}</td>
                    <td>{{ $peserta->tempat_lahir }}, {{ $peserta->tanggal_lahir }}</td>
                    <td>{{ $training[0]->nama_training }}</td>
                    <td>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#editdata{{ $peserta->id }}" style=""
                            class="btn btn-primary"><i class="fa-regular fa-eye"></i></button> --}}
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $peserta->id }}" style=""
                            class="btn btn-warning"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $peserta->id }}"
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
                            <div class="col-md-6">
                                <div= class="form-group">
                                    <label for="name" class="col-form-label">Nama Peserta :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nama')
                  is-invalid
              @enderror"
                                        placeholder="Nama training.." id="name" name="nama" required>
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
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">NBPT :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('nbpt')
                                        is-invalid
                                        @enderror"
                                        id="name" name="nbpt" placeholder="NBPT.." required>
                                    @error('nbpt')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="col-form-label">Tempat Lahir :</label>
                                <input style="font-size: 14px;" type="text"
                                    class="form-control @error('tempat_lahir')
                                        is-invalid
                                        @enderror"
                                    id="name" name="tempat_lahir" placeholder="Tempat lahir.." required>
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
                                    placeholder="Tanggal lahir.." id="name" name="tanggal_lahir" required>
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
                                        @endforeach
                                    </select>
                                </div>
                                @error('id_training')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
    @foreach ($pesertas as $peserta)
        <div class="modal modal-blur fade" id="editdata{{ $peserta->id }}" tabindex="-1" role="dialog"
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
                            <input type="hidden" value="{{ $peserta->id }}" name="id_peserta">
                            <div class="row">
                                <div class="col-md-6">
                                    <div= class="form-group">
                                        <label for="name" class="col-form-label">Nama Peserta :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('nama')
                  is-invalid
              @enderror"
                                            placeholder="Nama training.." id="name" name="nama"
                                            value="{{ $peserta->nama }}" required>
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
                                        <label for="name" class="col-form-label">NBPT :</label>
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
                                </div>
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
        <div class="modal modal-blur fade" id="deletedata{{ $peserta->id }}" tabindex="-1" role="dialog"
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
                            *<b>{{ $peserta->nama }}</b>)...</div>
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
                                    <input type="hidden" name="id_peserta" value="{{ $peserta->id }}">
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
@endsection
