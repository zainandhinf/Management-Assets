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
                <form action="/print-data-petugas-pdf" method="GET" target="_blank" id="printForm">
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


        @php
            $no = 1;
            // dd($requests);
        @endphp
        <table class="table table-striped" id="data-tables">
            <thead>
                <tr>
                    <th>#</th>
                    {{-- <th>Foto Profil</th> --}}
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Gender</th>
                    {{-- <th>Alamat</th> --}}
                    {{-- <th>No Telepon</th> --}}
                    <th>Username</th>
                    <th>Role</th>
                    {{-- <th data-searchable="false">Action</th> --}}
                </tr>
            </thead>
            @foreach ($petugass as $petugas)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>lorem</td> --}}
                    <td>{{ $petugas->nik }}</td>
                    <td>{{ $petugas->nama_user }}</td>
                    <td>
                        @if ($petugas->jenis_kelamin === 'L')
                            Laki-Laki
                        @else
                            Perempuan
                        @endif
                    </td>
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
                    <td>{{ $petugas->username }}</td>
                    <td>
                        @if ($petugas->role == 'super_user')
                            Super User
                        @else
                            Koordinator
                        @endif
                    </td>
                    {{-- <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $petugas->id }}"
                            style="margin-right: 10px" class="btn btn-primary mr-2"><i
                                class="fa-regular fa-eye"></i></button>

                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $petugas->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $petugas->id }}"
                            class="btn btn-danger mt-1">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td> --}}
                </tr>
            @endforeach
        </table>
    </div>

    {{-- modal --}}

    {{-- modal filter --}}
    <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" style="font-size: 14px;">
                    <label class="mb-1" for="">Filter Berdasarkan Tanggal Dibuat Data Petugas :</label>
                    <div class="form-group d-flex flex-direction-column">
                        <input type="date" class="form-control form-control-sm" id="startDate">
                        <span class="p-2"> - </span>
                        <input type="date" class="form-control form-control-sm" id="endDate">
                    </div>
                    <label for="">Role</label>
                    <select style="font-size: 14px;" class="form-select" id="role" name="role">
                        <option value="">choose..</option>
                        <option value="super_user">Super User</option>
                        <option value="koordinator">Koordinator</option>
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

    {{-- end modal --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const roleInput = document.getElementById('role');
            const filterBtn = document.getElementById('filterBtn');

            function updateFilterHref() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const role = roleInput.value;
                let href = '/laporan-data-petugas/f=hah';

                if (startDate && endDate && role) {
                    href = `/laporan-data-petugas/f=?date=${startDate}_${endDate}&role=${role}`;
                } else if (role) {
                    href = `/laporan-data-petugas/f=?role=${role}`;
                } else if (role && startDate) {
                    href = `/laporan-data-petugas/f=?date=${startDate}&role=${role}`;
                } else if (role && endDate) {
                    href = `/laporan-data-petugas/f=?date=${endDate}&role=${role}`;
                    // } else if (startDate && endDate) {
                    //     href = `/laporan-data-petugas/f=?date=${startDate}_${endDate}&role=${role}`;
                } else if (startDate) {
                    href = `/laporan-data-petugas/f=?date=${startDate}`;
                } else if (endDate) {
                    href = `/laporan-data-petugas/f=?date=${endDate}]`;
                    // href = `/laporan-data-petugas/f=_${endDate}]`;
                }

                // if (role && startDate == null && endDate == null) {
                //     // href += (href.includes('?') ? '&' : (href ? '' : '')) + `${role}`;
                //     href += (href.includes('?') ? '&' : '') + `${role}`;
                // }else if (role){
                //     href += (href.includes('?') ? '&' : (href ? '?role=' : '')) + `${role}`;
                // }

                filterBtn.href = href;
            }

            startDateInput.addEventListener('change', updateFilterHref);
            endDateInput.addEventListener('change', updateFilterHref);
            roleInput.addEventListener('change', updateFilterHref);
        });
    </script>
@endsection
