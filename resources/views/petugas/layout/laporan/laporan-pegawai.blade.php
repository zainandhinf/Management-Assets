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
                        <input type="hidden" name="organisasi" id="requestsInput" value="{{ $requests->query('organisasi') }}">
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                        <i class="fa-solid fa-print"></i>
                        Print
                    </button>
                </form>
            </div>
            <form method="GET" action="/export-laporan-data-pegawai">
                @if ($requests == null)
                @else
                    <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                    <input type="hidden" name="organisasi" id="requestsInput" value="{{ $requests->query('organisasi') }}">
                @endif
                <button type="submit" class="btn btn-success mb-2"><i class="fa-solid fa-download me-2"></i>Download
                    Excel</button>
            </form>
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
                    <th>Tanggal Data Dibuat</th>
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
                    @php
                        $organisasi = DB::table('departemens')->select('*')->where('id','=',$pegawai->id_departemen)->first();
                    @endphp
                    <td>{{ $organisasi->departemen }}</td>
                    <td>{{ $pegawai->created_at }}</td>

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


    {{-- modal filter --}}
    <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" style="font-size: 14px;">
                    <label class="mb-1" for="">Filter Berdasarkan Tanggal Dibuat Data Pegawai :</label>
                    <div class="form-group d-flex flex-direction-column">
                        <input type="date" class="form-control form-control-sm" id="startDate">
                        <span class="p-2"> - </span>
                        <input type="date" class="form-control form-control-sm" id="endDate">
                    </div>
                    <label for="">Organisasi</label>
                    <select style="font-size: 14px;" class="form-select" id="organisasi" name="organisasi">
                        <option value="">choose..</option>
                        {{-- <option value="super_user">Super User</option>
                        <option value="koordinator">Koordinator</option> --}}
                        @php
                            $organisasis = DB::table('departemens')->select('*')->get();
                        @endphp
                        @foreach ($organisasis as $organisasi)
                            <option value="{{ $organisasi->no_departemen }}">{{ $organisasi->departemen }}</option>
                        @endforeach
                    </select>
                    <div class="mt-1">
                        <a href="" id="filterBtn" type="button" class="btn btn-primary btn-sm">Filter</a>
                    </div>
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- end modal filter --}}

    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const organisasiInput = document.getElementById('organisasi');
            const filterBtn = document.getElementById('filterBtn');

            function updateFilterHref() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const organisasi = organisasiInput.value;
                let href = '/laporan-data-pegawai/f=hah';

                if (startDate && endDate && organisasi) {
                    href = `/laporan-data-pegawai/f=?date=${startDate}_${endDate}&organisasi=${organisasi}`;
                } else if (organisasi) {
                    href = `/laporan-data-pegawai/f=?organisasi=${organisasi}`;
                } else if (organisasi && startDate) {
                    href = `/laporan-data-pegawai/f=?date=${startDate}&organisasi=${organisasi}`;
                } else if (organisasi && endDate) {
                    href = `/laporan-data-pegawai/f=?date=${endDate}&organisasi=${organisasi}`;
                    // } else if (startDate && endDate) {
                    //     href = `/laporan-data-pegawai/f=?date=${startDate}_${endDate}&organisasi=${organisasi}`;
                } else if (startDate) {
                    href = `/laporan-data-pegawai/f=?date=${startDate}`;
                } else if (endDate) {
                    href = `/laporan-data-pegawai/f=?date=${endDate}]`;
                    // href = `/laporan-data-petugas/f=_${endDate}]`;
                }

                // if (organisasi && startDate == null && endDate == null) {
                //     // href += (href.includes('?') ? '&' : (href ? '' : '')) + `${organisasi}`;
                //     href += (href.includes('?') ? '&' : '') + `${organisasi}`;
                // }else if (organisasi){
                //     href += (href.includes('?') ? '&' : (href ? '?organisasi=' : '')) + `${organisasi}`;
                // }

                filterBtn.href = href;
            }

            startDateInput.addEventListener('change', updateFilterHref);
            endDateInput.addEventListener('change', updateFilterHref);
            organisasiInput.addEventListener('change', updateFilterHref);
        });
    </script>
@endsection
