@extends('super_user.main')

@section('content')

    <div class="dashboard-head">
        <div class="card-dashboard card-officer">
            <div>
                <h1>Petugas</h1>
                <h2>1</h2>
                <p>
                    petugas baru <br>dibulan ini 1
                </p>
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
        </div>
        <div class="card-dashboard card-user">
            <div>
                <h1>Pegawai</h1>
                <h2>1</h2>
                <p>
                    pegawai baru <br>dibulan ini 1
                </p>
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-user"></i>
            </div>
        </div>
        <div class="card-dashboard card-catalog">
            <div>
                <h1>Barang</h1>
                <h2>1</h2>
                <p>
                    barang baru <br>dibulan ini 1
                </p>
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-boxes-packing"></i>            </div>
        </div>
        <div class="card-dashboard card-transaction">
            <div>
                <h1>Ruangan</h1>
                <h2>1</h2>
                <p>
                    ruangan baru <br>dibulan ini 1
                </p>
            </div>
            <div class="icon-dashboard">
                <i class="fa-solid fa-list"></i>
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
@endsection
