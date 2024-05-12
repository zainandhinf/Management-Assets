@extends('super_user.main')

@section('content')
<div class="card p-4" style="font-size: 14px;">
    <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
        data-bs-target="#exampleModal">
        <i class="fa-solid fa-folder-plus me-1"></i> Tambah Data
    </button>
    <table class="table table-striped" id="data-tables">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Desc</th>
                <th data-searchable="false">Action</th>
            </tr>
        </thead>
        @php
            $no = 1;
        @endphp
        <tr>
            <td>{{ $no++ }}</td>
            {{-- <td>{{ $city->id }}</td> --}}
            <td>lorem</td>
            <td>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ea necessitatibus vel praesentium sit impedit
                sapiente eum porro, quos, voluptatibus fuga dolorem cumque omnis molestias libero quia tempora in cum
                asperiores ducimus? Dolorem consequatur excepturi suscipit dolorum modi culpa, recusandae maxime?</td>
            <td>
                <button data-bs-toggle="modal" data-bs-target="#editUser" style="margin-right: 10px"
                    class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>


                <button data-bs-toggle="modal" data-bs-target="#delete" class="btn btn-danger mt-1">
                    <i class="fa fa-trash"></i>
                </button>

            </td>
        </tr>
    </table>
</div>
@endsection
