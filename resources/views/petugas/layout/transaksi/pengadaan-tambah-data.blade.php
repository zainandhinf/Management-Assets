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
            {{-- @php
                use Carbon\Carbon;
                // $no_last = DB::table('keranjang_pengadaans')->select('*')->orderByDesc('no_pengadaan')->first();
                $no_last = DB::table('keranjang_pengadaans')
                    ->select(DB::raw('RIGHT(no_pengadaan, 4) + 1 as noUrut'))
                    ->orderBy('no_pengadaan', 'DESC')
                    ->limit(1)
                    ->get();

                $no_count = DB::table('keranjang_pengadaans')->select('*')->count();
                // dd($no_last);

                if (!$no_last->isEmpty()) {
                    $noUrut = $no_last[0]->noUrut;
                    $floatValue = floatval($noUrut);
                }
                if ($no_last->isEmpty()) {
                    $no_pengadaan_last = '0001';
                } else {
                    if ($noUrut < 10) {
                        $no_pengadaan_last = '000' . $noUrut;
                    } elseif ($noUrut < 100) {
                        $no_pengadaan_last = '00' . $noUrut;
                    } elseif ($noUrut < 1000) {
                        $no_pengadaan_last = '0' . $noUrut;
                    } elseif ($noUrut < 10000) {
                        $no_pengadaan_last = $noUrut;
                    } else {
                        $no_pengadaan_last = '0001';
                    }
                }

                $no_pengadaan = 'P' . Carbon::now()->setTimezone('Asia/Jakarta')->format('YmdHis') . $no_pengadaan_last;
            @endphp --}}
            <div class="form-group">
                <form action="/addkeranjang" method="POST">
                    @csrf

                    {{-- <label for="">No. Pengadaan</label><br>
                    <input type="text" name="no_pengadaan" class="form-control mb-2 w-100" value="{{ $no_pengadaan }}"
                        readonly> --}}

                    <label for="">No. Barang</label><br>
                    <input type="text" name="no_barang" class="form-control mb-2 w-100"
                        value="{{ $data_barang->no_barang }}" readonly>

                    <label for="">Kode Barcode</label><br>
                    <input type="text" name="kode_barcode" class="form-control mb-2" value="{{ $kode_barcode }}"
                        readonly>

                    <label for="">No. Asset</label><br>
                    <div class="input-group">
                        <span class="input-group-text" style="font-size: 14px; height: 38px;"
                            id="basic-addon1">{{ $data_barang->kode_awal }}-</span>
                            <input type="hidden" value="{{ $data_barang->kode_awal }}" name="kode_awal">
                        <input type="text" placeholder="No asset.." name="no_asset" class="form-control mb-2"
                            value="" required>
                    </div>

                    <label for="">Merk</label><br>
                    <input type="text" name="merk" class="form-control mb-2" value="" placeholder="Merk.."
                        required>

                    <label for="">Spesifikasi</label><br>
                    <textarea class="form-control" name="spesifikasi" cols="10" rows="3"
                        placeholder="*Contoh pengisian: Intel Core i7 Gen 13 Ram 2 dst.." required></textarea>

                    <label for="">Kondisi</label><br>
                    <select type="text" name="kondisi" class="form-control mb-2">
                        <option value="BK">Baik</option>
                        <option value="RR">Rusak</option>
                        <option value="PB">Perlu Perbaikan</option>
                    </select>

                    <input type="hidden" value="Belum Ditempatkan" name="status" class="form-control mb-2">

                    <label for="">Rp./Harga Beli</label><br>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                        <input type="number" name="harga" class="form-control" placeholder="000.000,00" required>
                    </div>

                    <label for="">Jenis Pengadaan</label><br>
                    <select type="text" name="jenis_pengadaan" class="form-control mb-2">
                        <option value="BarangLama">Barang Lama</option>
                        <option value="Pembelian">Pembelian</option>
                        <option value="Sumbangan">Sumbangan</option>
                        <option value="Wakaf">Wakaf</option>
                        <option value="Hibah">Hibah</option>
                        <option value="Hadiah">Hadiah</option>
                        <option value="Donasi">Donasi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>

                    <label for="">Keterangan</label><br>
                    <textarea class="form-control mb-4" name="keterangan" cols="10" rows="3" placeholder="Keterangan.." required></textarea>

                    <button type="submit" class="btn btn-primary mt-2 w-100" style="font-size: 14px;"><i class="fa fa-list me-2"></i>+ Tambah ke List</button>
                </form>

            </div>

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
