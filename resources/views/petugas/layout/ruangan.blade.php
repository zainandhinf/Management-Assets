@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        @if ($cek > 0)

            <table class="table table-striped" id="data-tables">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No Ruangan</th>
                        <th>Ruangan</th>
                        <th>Lokasi</th>
                        <th>Kapasitas</th>
                        <th>Foto Ruangan</th>
                        <th>Tipe Ruangan</th>
                        {{-- <th data-searchable="false">Action</th> --}}
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
                        $image_ruangan = DB::table('image_ruangans')
                            ->select('image')
                            ->where('no_ruangan', '=', $ruangan->no_ruangan)
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        {{-- <td>{{ $city->id }}</td> --}}
                        <td>{{ $ruangan->no_ruangan }}</td>
                        <td>{{ $ruangan->ruangan }}</td>
                        <td>{{ $ruangan->lokasi }}</td>
                        <td>{{ $ruangan->kapasitas }}</td>
                        <td>
                            <div class="d-flex flex-column image-ruangan">
                                {{-- @foreach ($image_ruangans as $image_ruangan) --}}
                                    <img src="{{ asset('storage/' . $image_ruangan->image) }}" alt="" width="100px"
                                        class="mb-1">
                                {{-- @endforeach --}}
                                <button class="btn btn-primary view-button btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#viewimg{{ $ruangan->id }}">
                                    <i class="fa-solid fa-eye "></i>
                                </button>
                            </div>
                        </td>
                        <td>{{ $tipe_ruangan[0]->nama_tipe }}</td>
                        {{-- <td>
                            <button data-bs-toggle="modal" data-bs-target="#editdata{{ $ruangan->id }}"
                                style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>


                            <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $ruangan->id }}"
                                class="btn btn-danger mt-1">
                                <i class="fa fa-trash"></i>
                            </button>

                        </td> --}}
                    </tr>
                @endforeach
            </table>
        @else
            <b>
                <h5>
                    *Note: Data Ruangan hanya bisa dibuat ketika kamu sudah mengisi <a href="/tipe-ruangan">Data Tipe
                        Ruangan</a> terlebih dahulu !
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
                                        <input type="file" name="foto[]" multiple>
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
                                    <input type="hidden" name="no_ruangan" value="{{ $ruangan->no_ruangan }}">
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

    {{-- modal view image --}}
    @foreach ($ruangans as $ruangan)
        <div class="modal modal-blur fade" id="viewimg{{ $ruangan->id }}" tabindex="-1" role="dialog"
            aria-hidden="true" style="font-size: 14px;">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content bg-transparent">
                    <div class="modal-body d-flex justify-content-center">
                        @php
                            $images_view = DB::table('image_ruangans')
                                ->select('*')
                                ->where('no_ruangan', '=', $ruangan->no_ruangan)
                                ->get();
                            $image_view = DB::table('image_ruangans')
                                ->select('*')
                                ->where('no_ruangan', '=', $ruangan->no_ruangan)
                                ->limit(1)
                                ->get();
                            $no = 2;
                            $no1 = 1;
                            // dd($image_view);
                        @endphp
                        <div id="carouselExample{{ $ruangan->id }}" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="img-ruangan">
                                        <img src="{{ asset('storage/' . $image_view[0]->image) }}"
                                            class="d-block img-fluid" alt="...">
                                        <div class="delete-button-img-ruangan">
                                            <a class="btn btn-primary btn-lg text-deco  ration-none"
                                                href="http://127.0.0.1:8000{{ asset('storage/' . $image_view[0]->image) }}"
                                                target="blank">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>

                                            <button class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                                data-bs-target="#deleteimg{{ $image_view[0]->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @foreach ($images_view->skip(1) as $image)
                                    <div class="carousel-item">
                                        <div class="img-ruangan">
                                            <img src="{{ asset('storage/' . $image->image) }}" class="d-block img-fluid"
                                                alt="...">
                                            <div class="delete-button-img-ruangan">
                                                <a class="btn btn-primary btn-lg text-decoration-none"
                                                    href="http://127.0.0.1:8000{{ asset('storage/' . $image->image) }}"
                                                    target="blank">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                                <button class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                                    data-bs-target="#deleteimg{{ $image->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="carousel-item">
                                    <div class="img-ruangan">
                                        <label for="file" class="custom-file-upload-view-img-ruangan ms-3 mt-2">
                                            <form action="/addimgruangan" method="POST" enctype="multipart/form-data"
                                                id="uploadimgruangan">
                                                @csrf
                                                <input type="hidden" name="id_ruangan" value="{{ $ruangan->id }}">
                                                <div class="icon">
                                                    <i class="fa-solid fa-camera text-white"></i>
                                                </div>
                                                <div class="text">
                                                    <span>Tambah foto ruangan</span>
                                                </div>
                                                <input id="file" type="file" name="foto[]" multiple>
                                            </form>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExample{{ $ruangan->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExample{{ $ruangan->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal view image --}}


    {{-- modal delete image ruangan --}}
    {{-- @foreach ($ruangans as $ruangan)
        @php
            $images_view = DB::table('image_ruangans')
                ->select('*')
                ->where('id_ruangan', '=', $ruangan->id)
                ->get();
        @endphp
    @endforeach --}}
    @php
        $images_delete = DB::table('image_ruangans')->select('*')->get();
    @endphp
    @foreach ($images_delete as $image)
        <div class="modal modal-blur fade" id="deleteimg{{ $image->id }}" tabindex="-1" role="dialog"
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
                        <div class="text-muted">Yakin? Anda akan menghapus foto ini...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deleteimgruangan" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="image" value="{{ $image->image }}">
                                    <input type="hidden" name="id_image" value="{{ $image->id }}">
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
    {{-- end modal delete image ruangan --}}

    {{-- end modal --}}


    <script>
        $(document).ready(function() {
            $('#file').on('change', function() {
                $('#uploadimgruangan').submit();
            });
        });
    </script>
@endsection
