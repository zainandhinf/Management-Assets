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
                    <th>Nama Training</th>
                    <th>Keterangan</th>
                    {{-- <th data-searchable="false">Action</th> --}}
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($trainings as $training)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $training->nama_training }}</td>
                    <td>{{ $training->keterangan }}</td>
                    {{-- <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $training->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $training->id }}"
                            class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>

                    </td> --}}
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
                    <form action="/addnamatraining" method="post">
                        @csrf
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
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Keterangan :</label>
                            <textarea style="font-size: 14px;"
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



    {{-- end modal --}}
@endsection
