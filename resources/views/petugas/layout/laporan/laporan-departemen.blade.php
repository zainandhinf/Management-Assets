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
                <form action="/print-data-departemen-pdf" method="GET" target="_blank" id="printForm">
                    @if ($requests == null)
                    @else
                        <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                        {{-- <input type="hidden" name="role" id="requestsInput" value="{{ $requests->query('role') }}"> --}}
                    @endif
                    <button type="submit" class="btn btn-primary btn-sm mt-2 mb-2 w-100">
                        <i class="fa-solid fa-print"></i>
                        Print
                    </button>
                </form>
            </div>
            <form method="GET" action="/export-laporan-data-departemen">
                @if ($requests == null)
                @else
                    <input type="hidden" name="date" id="requestsInput" value="{{ $requests->query('date') }}">
                    {{-- <input type="hidden" name="organisasi" id="requestsInput" value="{{ $requests->query('organisasi') }}"> --}}
                @endif
                <button type="submit" class="btn btn-success mb-2"><i class="fa-solid fa-download me-2"></i>Download
                    Excel</button>
            </form>
        </div>
        <table class="table table-striped" id="data-tables" style="font-size: 14px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Departemen</th>
                    <th>Departemen</th>
                    <th>Tanggal Data Dibuat</th>
                    {{-- <th data-searchable="false">Action</th> --}}
                </tr>
            </thead>
            @php
                $no = 1;
            @endphp
            @foreach ($departemens as $departemen)
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    <td>{{ $departemen->no_departemen }}</td>
                    <td>{{ $departemen->departemen }}</td>
                    <td>{{ $departemen->created_at }}</td>
                    {{-- <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $departemen->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $departemen->id }}"
                            class="btn btn-danger">
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
                    <label class="mb-1" for="">Filter Berdasarkan Tanggal Dibuat Data Departenen :</label>
                    <div class="form-group d-flex flex-direction-column">
                        <input type="date" class="form-control form-control-sm" id="startDate">
                        <span class="p-2"> - </span>
                        <input type="date" class="form-control form-control-sm" id="endDate">
                    </div>
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
            // const tipeInput = document.getElementById('tipe');
            const filterBtn = document.getElementById('filterBtn');

            // console.log(tipeInput);

            function updateFilterHref() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                // const tipe = tipeInput.value;
                let href = '/laporan-data-departemen/f=hah';
                

                if (startDate && endDate) {
                    href = `/laporan-data-departemen/f=?date=${startDate}_${endDate}`;
                } else if (startDate) {
                    href = `/laporan-data-departemen/f=?date=${startDate}`;
                } else if (endDate) {
                    href = `/laporan-data-departemen/f=?date=${endDate}]`;
                    // href = `/laporan-data-petugas/f=_${endDate}]`;
                }

                // if (tipe && startDate == null && endDate == null) {
                //     // href += (href.includes('?') ? '&' : (href ? '' : '')) + `${tipe}`;
                //     href += (href.includes('?') ? '&' : '') + `${tipe}`;
                // }else if (tipe){
                //     href += (href.includes('?') ? '&' : (href ? '?tipe=' : '')) + `${tipe}`;
                // }

                // console.log(href);

                filterBtn.href = href;


            }

            startDateInput.addEventListener('change', updateFilterHref);
            endDateInput.addEventListener('change', updateFilterHref);
            // tipeInput.addEventListener('change', updateFilterHref);
        });
    </script>
@endsection
