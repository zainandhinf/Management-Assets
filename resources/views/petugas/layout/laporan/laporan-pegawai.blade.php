@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">

        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-warning btn-sm mt-2 mb-2 w-100" data-bs-toggle="modal"
                    data-bs-target="#filter">
                    <i class="fa fa-slider"></i>
                    Filter
                </button>
            </div>
            {{-- <div class="col-md-8">
            <a href="/print-petugas" target="blank" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                <i class="fa-solid fa-print"></i>
                Print
            </a>
        </div> --}}
            <div class="col-md-8">
                <!-- Form untuk mengirimkan data saat print -->
                <form action="/print-data-pegawai-pdf" method="GET" target="_blank" id="printForm">
                    @if ($requests == null)
                    @else
                        <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                        <input type="hidden" name="role" id="requestsInput" value="{{ $requests->query('role') }}">
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                        <i class="fa-solid fa-print"></i>
                        Print
                    </button>
                </form>
            </div>
        </div>

        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Gender</th>

                    {{-- <th>Alamat</th> --}}
                    <th>No Telp</th>
                    <th>Organisasi</th>
                    {{-- <th>Foto</th> --}}
                    {{-- <th data-searchable="false">Action</th> --}}
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($pegawais as $pegawai)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>{{ $pegawai->nik }}</td>
                    <td>{{ $pegawai->nama_user }}</td>
                    <td>
                        @if ($pegawai->jenis_kelamin === 'L')
                            Laki-Laki
                        @else
                            Perempuan
                        @endif
                    </td>
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    <td>{{ $pegawai->no_telepon }}</td>
                    <td>{{ $pegawai->organisasi }}</td>

                    {{-- <td>
                 <button data-bs-toggle="modal" data-bs-target="#editdata{{ $pegawai->id }}"
                     style="margin-right: 10px" class="btn btn-primary mr-2"><i class="fa-regular fa-eye"></i></button>

                 <button data-bs-toggle="modal" data-bs-target="#editdata{{ $pegawai->id }}"
                     style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                 <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $pegawai->id }}"
                     class="btn btn-danger mt-1">
                     <i class="fa fa-trash"></i>
                 </button>
             </td> --}}
                </tr>
            @endforeach
        </table>
    </div>

@endsection
