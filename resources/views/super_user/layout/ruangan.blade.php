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
                    <th>No Ruangan</th>
                    <th>Ruangan</th>
                    <th>Lokasi</th>
                    <th>Kapasitas</th>
                    <th>Foto Ruangan</th>
                    <th>Tipe Ruangan</th>
                    <th data-searchable="false">Action</th>
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($ruangans as $ruangan)
                @php
                    $tipe_ruangan = DB::table('tipe_ruangans')
                        ->select('nama_tipe')
                        ->where('id', '=', $ruangan->tipe_ruangan)
                        ->get();
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    <td>{{ $ruangan->no_ruangan }}</td>
                    <td>{{ $ruangan->ruangan }}</td>
                    <td>{{ $ruangan->lokasi }}</td>
                    <td>{{ $ruangan->kapasitas }}</td>
                    <td><a href="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi, numquam!</a></td>
                    <td>{{ $tipe_ruangan[0]->nama_tipe }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $ruangan->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>


                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $ruangan->id }}"
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
                <form action="/addruangan" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">No Ruangan :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('no_ruangan')
                  is-invalid
              @enderror"
                                        placeholder="No Ruangan.." id="name" name="no_ruangan" required>
                                    @error('no_ruangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Ruangan :</label>
                                    <input style="font-size: 14px;" type="text"
                                        class="form-control @error('ruangan')
                  is-invalid
              @enderror"
                                        placeholder="Ruangan.." id="name" name="ruangan" required>
                                    @error('ruangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="name" class="col-form-label">Lokasi :</label>
                                    <textarea style="font-size: 14px;" type="text"
                                        class="form-control @error('lokasi')
              is-invalid
          @enderror" placeholder="Lokasi.."
                                        id="name" name="lokasi" required></textarea>
                                    @error('lokasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $tipe_ruangans = DB::table('tipe_ruangans')->select('*')->get();
                                @endphp
                                <label for="name" class="col-form-label">Kapasitas :</label>
                                <input style="font-size: 14px;" type="number"
                                    class="form-control @error('kapasitas')
              is-invalid
          @enderror"
                                    placeholder="Kapasitas.." id="name" name="kapasitas" required>
                                @error('kapasitas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Tipe Ruangan :</label>
                                    <select style="font-size: 14px;"
                                        class="form-select @error('tipe_ruangan')
                                    is-invalid
                                @enderror"
                                        id="inputGroupSelect01" name="tipe_ruangan">
                                        @foreach ($tipe_ruangans as $tipe_ruangan)
                                            <option value="{{ $tipe_ruangan->id }}">{{ $tipe_ruangan->nama_tipe }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tipe_ruangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="name" class="col-form-label">Foto Ruangan :</label>
                                <br>
                                <label for="file" class="custom-file-upload-ruangan bg-white">
                                    <div class="icon">
                                        <i class="fa-solid fa-camera fs-5"></i>
                                    </div>
                                    <div class="text">
                                        <span class="text-black">Tambah foto ruangan</span>
                                        <input id="file" type="file" name="foto[]" multiple>
                                    </div>
                                </label>
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
    @foreach ($ruangans as $ruangan)
        <div class="modal modal-blur fade" id="editdata{{ $ruangan->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/editruangan" method="post">
                        <div class="modal-body">
                            <div class="row">
                                @csrf
                                @method('PUT')
                                <input type="hidden" value="{{ $ruangan->id }}" name="id_ruangan">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">No Ruangan :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('no_ruangan')
                      is-invalid
                  @enderror"
                                            placeholder="No Ruangan.." id="name" name="no_ruangan"
                                            value="{{ old('no_ruangan', $ruangan->no_ruangan) }}" required>
                                        @error('no_ruangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Ruangan :</label>
                                        <input style="font-size: 14px;" type="text"
                                            class="form-control @error('ruangan')
                      is-invalid
                  @enderror"
                                            placeholder="Ruangan.." id="name" name="ruangan"
                                            value="{{ old('ruangan', $ruangan->ruangan) }}" required>
                                        @error('ruangan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <label for="name" class="col-form-label">Lokasi :</label>
                                        <textarea style="font-size: 14px;" type="text"
                                            class="form-control @error('lokasi')
                  is-invalid
              @enderror" placeholder="Lokasi.."
                                            id="name" name="lokasi" required>{{ old('lokasi', $ruangan->lokasi) }}</textarea>
                                        @error('lokasi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @php
                                        $tipe_ruangans = DB::table('tipe_ruangans')->select('*')->get();
                                    @endphp
                                    <label for="name" class="col-form-label">Kapasitas :</label>
                                    <input style="font-size: 14px;" type="number"
                                        class="form-control @error('kapasitas')
                  is-invalid
              @enderror"
                                        placeholder="Kapasitas.." id="name" name="kapasitas"
                                        value="{{ old('kapasitas', $ruangan->kapasitas) }}" required>
                                    @error('kapasitas')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Tipe Ruangan :</label>
                                        <select style="font-size: 14px;"
                                            class="form-select @error('tipe_ruangan')
                                        is-invalid
                                    @enderror"
                                            id="inputGroupSelect01" name="tipe_ruangan">
                                            @foreach ($tipe_ruangans as $tipe_ruangan)
                                                @if (old('no_ruangan', $ruangan->no_ruangan) == $tipe_ruangan->id)
                                                    <option value="{{ $tipe_ruangan->id }}" selected>
                                                        {{ $tipe_ruangan->nama_tipe }}</option>
                                                @else
                                                    <option value="{{ $tipe_ruangan->id }}">
                                                        {{ $tipe_ruangan->nama_tipe }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('tipe_ruangan')
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
    @foreach ($ruangans as $ruangan)
        <div class="modal modal-blur fade" id="deletedata{{ $ruangan->id }}" tabindex="-1" role="dialog"
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
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Ruangan:
                            *<b>{{ $ruangan->ruangan }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deleteruangan" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_ruangan" value="{{ $ruangan->id }}">
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
