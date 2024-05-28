@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <div class="row">


            {{-- <div class="bg-secondary text-white mb-2">
                            <h6>Detail Barang</h6>
                     </div> --}}
            <strong class="mb-2">*Informasi barang akan otomatis terisi setelah memilih Barang atau Mengisi Kolom Kode
                Barang...</strong>
            <button class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#adddata">
                <i class="fa-solid fa-boxes-packing mb-2"></i>
                Pilih Barang
            </button>
            <form action="/pengadaan-tambah-barang" method="post">
                @csrf
                {{-- <input type="hidden" name="no_barang" id="input-no-barang"> --}}
            <div class="form-group">

                <label for="">No. Barang</label><br>
                <input type="text" name="no_barang" class="form-control mb-2 w-100" value="" placeholder="Masukan No. Barang lalu tekan 'ENTER'..." required>
                <button type="submit" style="display: none"></button>
                {{-- <label for="">No. Pengadaan</label><br>
                <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">
                <label for="">No. Pengadaan</label><br>
                <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">
                <label for="">No. Pengadaan</label><br>
                <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">
                <label for="">No. Pengadaan</label><br>
                <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">
                <label for="">No. Pengadaan</label><br>
                <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">
                <label for="">No. Pengadaan</label><br>
                <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001"> --}}


            </div>
        </form>


        </div>
    </div>
    {{-- Start Modal --}}
    {{-- modal add data --}}

    <div class="modal modal-blur fade" id="adddata" tabindex="-1" role="dialog" aria-hidden="true"
        style="font-size: 14px;">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-6">Pilih Barang yang akan dibuat Pengadaanya !</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <table class="table table-striped" id="data-tables" style="font-size: 14px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Barang</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Qty</th>
                                <th style="text-align: right" data-searchable="false">Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($barangs as $barang)
                            {{-- <form action="/pengadaan-tambah/{{ $barang->no_barang }}" method="post"> --}}
                            {{-- @csrf --}}
                            @php
                                $qty = DB::table('detail_barangs')
                                    ->join('barangs', 'detail_barangs.no_barang', '=', 'barangs.no_barang')
                                    ->where('detail_barangs.no_barang', '=', $barang->no_barang)
                                    ->count();
                            @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><strong>{{ $barang->no_barang }}</strong></td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->nama_kategori }}</td>
                                <td>{{ $qty }}</td>
                                <td style="float: right;">
                                    {{-- <button style="margin-right: 10px" class="btn btn-info mr-2">
                                        <i class="fa fa-eye"></i>
                                    </button> --}}

                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning select-barang"
                                        data-no-barang="{{ $barang->no_barang }}">
                                        <i class="fa fa-plus"></i> Pilih Barang
                                    </button>
                                    {{-- </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden Form --}}
    <form id="form-pengadaan" action="/pengadaan-tambah-barang" method="post" style="display: none;">
        @csrf
        <input type="hidden" name="no_barang" id="input-no-barang">
    </form>


    {{-- end modal add data --}}

    {{-- modal edit data --}}

    {{-- end modal edit data --}}

    {{-- modal detail barang --}}
    {{-- end modal detail barang --}}

    {{-- modal delete data --}}

    {{-- end modal delete data --}}

    {{-- end modal --}}
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-barang').forEach(button => {
                button.addEventListener('click', function() {
                    const noBarang = this.getAttribute('data-no-barang');
                    document.getElementById('input-no-barang').value = noBarang;
                    document.getElementById('form-pengadaan').submit();
                });
            });
        });
    </script>
@endsection
