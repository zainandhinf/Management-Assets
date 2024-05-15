@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">

            <div class="row">


                     {{-- <div class="bg-secondary text-white mb-2">
                            <h6>Detail Barang</h6>
                     </div> --}}
                     <strong class="mb-2">*Informasi barang akan otomatis terisi setelah memilih Barang atau Mengisi Kolom Kode Barang...</strong>
                     <button class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
                     data-bs-target="#adddata">
                        <i class="fa-solid fa-boxes-packing mb-2"></i>
                        Pilih Barang
                     </button>
                    <div class="form-group">

                        <label for="">No. Barang</label><br>
                        <input type="text" name="no_pengadaan" class="form-control mb-2 w-100" value="{{ $data_barang->no_barang }}" readonly>
                        <label for="">Kode Barcode</label><br>
                        <input type="text" name="no_pengadaan" class="form-control mb-2" value="{{ $kode_barcode }}" readonly>
                        <label for="">No. Asset</label><br>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size: 14px; height: 38px;" id="basic-addon1">{{ $data_barang->kode_awal }}-</span>
                            <input type="text" placeholder="" name="no_asset" class="form-control mb-2" value="">
                        </div>
                        <label for="">Merk</label><br>
                        <input type="text" name="merk" class="form-control mb-2" value="">
                        <label for="">Spesifikasi</label><br>
                        <textarea class="form-control" name="spesifikasi" cols="30" rows="10" placeholder="Intel Core i7 Gen 13 Ram 2 dst..."></textarea>
                        <label for="">Kondisi</label><br>
                        <select type="text" name="kondisi" class="form-control mb-2">
                            <option value="Baik">Baik</option>
                            <option value="Baik">Rusak</option>
                            <option value="Baik">Perlu Perbaikan</option>
                        </select>
                        <input type="hidden" value="Belum Ditempatkan" name="status" class="form-control mb-2">
                        <label for="">Rp./Harga Beli</label><br>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                        <input type="number" name="harga" class="form-control mb-2" placeholder="000.000,00">
                        </div>


                    </div>

            </div>



    </div>
    {{-- Start Modal --}}
    {{-- modal add data --}}
    <div class="modal modal-blur fade" id="adddata" tabindex="-1" role="dialog" aria-hidden="true" style="font-size: 14px;">
        <div class="modal-dialog modal-fullscreen" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-6">Pilih Barang yang akan dibuat Pengadaanya !</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/pickThis" method="post">
                        @csrf
                        <table class="table table-striped" id="data-tables" style="font-size: 14px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Barang</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Qty</th>
                                    <th data-searchable="false">Action</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($barangs as $barang)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $barang->no_barang }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->nama_kategori }}</td>
                                    <td>{{ $barang->qty }}</td>
                                    <td>
                                        <input type="hidden" name="id_barang" value="{{ $barang->id }}">
                                        <button style="margin-right: 10px" class="btn btn-info mr-2">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        <button type="submit" class="btn btn-warning" href="/pickThis">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
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

    {{-- modal edit data --}}

    {{-- end modal edit data --}}

    {{-- modal delete data --}}

    {{-- end modal delete data --}}

    {{-- end modal --}}
@endsection
