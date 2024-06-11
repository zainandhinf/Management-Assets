@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <table class="table table-striped" id="data-tables" style="font-size: 14px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Departemen</th>
                    <th>Departemen</th>
                    <th data-searchable="false">Action</th>
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
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $departemen->id }}"
                            style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $departemen->id }}"
                            class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>

                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    {{-- modal --}}

    {{-- end modal --}}
@endsection
