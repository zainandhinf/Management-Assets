@extends('super_user.main')

@section('content')

    <div class="dashboard-head">
        <div class="card-dashboard card-officer">
            <div>
                <h1>Petugas</h1>
                <h2>{{ $petugas }}</h2>
                {{-- <p>
                    petugas baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
        </div>
        <div class="card-dashboard card-user">
            <div>
                <h1>Pegawai</h1>
                <h2>{{ $pegawai }}</h2>
                {{-- <p>
                    pegawai baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-user"></i>
            </div>
        </div>
        <div class="card-dashboard card-catalog">
            <div>
                <h1>Barang</h1>
                <h2>{{ $barang }}</h2>
                {{-- <p>
                    barang baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-boxes-packing"></i>            
            </div>
        </div>
        <div class="card-dashboard card-transaction">
            <div>
                <h1>Ruangan</h1>
                <h2>{{ $ruangan }}</h2>
                {{-- <p>
                    ruangan baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-list"></i>
            </div>
        </div>
    </div>
    <div class="dashboard-head">
        <div class="card-dashboard card-officer">
            <div>
                <h1>Departemen</h1>
                <h2>{{ $departemen }}</h2>
                {{-- <p>
                    departemen baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>
        <div class="card-dashboard card-user">
            <div>
                <h1>Pengadaan</h1>
                <h2>{{ $pengadaan }}</h2>
                {{-- <p>
                    pegawai baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-cart-plus"></i>
            </div>
        </div>
        <div class="card-dashboard card-catalog">
            <div>
                <h1>Penempatan</h1>
                <h2>{{ $penempatan }}</h2>
                {{-- <p>
                    barang baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-map-location-dot"></i>            
            </div>
        </div>
        <div class="card-dashboard card-transaction">
            <div>
                <h1>Mutasi</h1>
                <h2>{{ $mutasi }}</h2>
                {{-- <p>
                    ruangan baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-building-circle-arrow-right"></i>
            </div>
        </div>
    </div>
    <div class="dashboard-head">
        <div class="card-dashboard card-officer">
            <div>
                <h1>Peminjaman</h1>
                <h2>{{ $peminjaman }}</h2>
                {{-- <p>
                    departemen baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-handshake"></i>
            </div>
        </div>
        <div class="card-dashboard card-user">
            <div>
                <h1>Maintenance</h1>
                <h2>{{ $maintenance }}</h2>
                {{-- <p>
                    pegawai baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>
        </div>
        <div class="card-dashboard card-catalog">
            <div>
                <h1>Penghapusan</h1>
                <h2>{{ $penghapusan }}</h2>
                {{-- <p>
                    barang baru <br>dibulan ini 1
                </p> --}}
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-ban"></i>            
            </div>
        </div>
    </div>
    {{-- <div class="ms-2 mt-2 mb-3 d-flex">
        <div class="col-xl-8 col-xxl-9 shadow-sm ">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Monthly Transaction Chart</h5>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-xl-4 col-xxl-3 ms-2">
            <div class="card full-width">
                <div class="card-header">
                    <h5 class="card-title">Top Selling Catalogs</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-2">
                        <table class="table table-striped full-width" id="top-catalogs-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Total Transactions</th>
                                </tr>
                            </thead>

                            <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>haha</td>
                                        <td>2</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ms-2">
        <div class="col-xl-4 col-xxl-12 shadow-sm">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Recent Transactions</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-2">
                        <table class="table table-striped" style="width:100%" id="data-tables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Transaction</th>
                                    <th>Date Transaction</th>
                                    <th>Name User</th>
                                    <th>Client Name</th>
                                    <th>Id Catalog</th>
                                    <th>Tour Date</th>
                                    <th>Adult Qty</th>
                                    <th>Child Qty</th>
                                    <th>Transportation</th>
                                    <th>Total Payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                                <tr>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                   <td>1</td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="card p-4" style="font-size: 14px;">
        <h5 class="mb-4">Jadwal Training Minggu Ini</h5>
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

                        $nama_training = DB::table('data_trainings')
                            ->select('*')
                            ->where('id', '=', $training->training_id)
                            ->first();

                        $total_peserta = DB::table('peserta_trainings')
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
                            ->join('ruangans', 'ruangans.no_ruangan', '=', 'trainings.no_ruangan')
                            ->where('trainings.id', '=', $training->id)
                            ->count();
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        {{-- <td>{{ $city->id }}</td> --}}
                        {{-- <td>lorem</td> --}}
                        <td>{{ $nama_training->nama_training }} <br> ({{ $nama_training->keterangan }})</td>
                        <td>{{ $training->tanggal_mulai }} - {{ $training->tanggal_selesai }}</td>
                        <td>{{ $training->waktu_mulai }} - {{ $training->waktu_selesai }}<br>
                            {{ $tempat[0]->ruangan }}<br>(max: {{ $tempat[0]->kapasitas }})</td>
                        <td>{{ $total_peserta }}
                            <a data-bs-toggle="modal" data-bs-target="#viewpeserta{{ $training->id }}"
                                style="margin-right: 10px" class="border-none mr-2"><i class="fa fa-eye"></i></a>
                        </td>
                        <td>{{ $training->instruktur }}</td>
                        <td>{{ $nama_petugas[0]->nama_user }}</td>
                        {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                        {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#editdata{{ $training->id }}"
                                class="btn btn-warning"><i class="fa-solid fa-clock-rotate-left"></i></button>
                            <button data-bs-toggle="modal" data-bs-target="#editinfotraining{{ $training->id }}"
                                class="btn btn-success"><i class="fa fa-edit"></i></button>
                            <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $training->id }}"
                                class="btn btn-danger mt-1">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>

    </div>

    {{-- modal --}}

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
                                        // 'trainings.nama_training',
                                        'trainings.id as id_training',
                                    )
                                    ->join('pegawais', 'pegawais.nik', '=', 'peserta_trainings.nik')
                                    ->join('trainings', 'trainings.id', '=', 'peserta_trainings.id_training')
                                    ->join('ruangans', 'ruangans.no_ruangan', '=', 'trainings.no_ruangan')
                                    ->where('trainings.id', '=', $training->id)
                                    ->get();
                            @endphp
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>L/P</th>
                                    <th>No Telepon</th>
                                    {{-- <th>Training</th> --}}
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($pesertas as $peserta)
                                @php
                                    // $training = DB::table('trainings')
                                    //     ->select('*')
                                    //     ->where('id', '=', $peserta->id_training)
                                    //     ->get();
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    {{-- <td>{{ $city->id }}</td> --}}
                                    {{-- <td>lorem</td> --}}
                                    <td><img src="{{ asset('storage/' . $peserta->foto) }}"
                                            class="rounded rounded-circle" style="width: 50px;" alt=""></td>
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
                                    {{-- <td>{{ $training[0]->nama_training }}</td> --}}
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

@endsection
