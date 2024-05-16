@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">

        <div class="bg-secondary ps-2 text-white w-30">
            Informasi Penempatan
        </div>
        <div class="row mb-2">
            <div class="col-md-8">

                <table class="w-100">

                    <tr>
                    <td>No. Penempatan</td>
                    <td>: PNMPTN-11111</td>
                </tr>
                <tr>
                    <td>Tgl Penempatan</td>
                    <td>: Hari ini</td>
                </tr>
                <tr>
                    <td>Lokasi Penempatan</td>
                    <td>
                        <select class="form-select" name="" id="">
                            <option value="">Ruangan siksa</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>
                        <textarea class="form-control" name="" id="" cols="30" rows="5"></textarea>
                    </td>
                </tr>
            </table>
        </div>
            {{-- <label for="">No Penempatan</label> --}}
        </div>
        <div class="bg-secondary ps-2 text-white w-30">
            Barang yang akan ditempatkan
        </div>

        <div class="row">
            <div class="form-group">
                <label for="">Scan Barcode / Kode Barang</label>
                <input type="text" value="" class="form-control">
            </div>
        </div>

        <hr>

        <h5>
            <strong>List Penempatan Barang</strong>
        </h5>

        <table border="1">
            <tr>
                <td>a</td>
                <td>a</td>
                <td>a</td>
                <td>a</td>
                <td>a</td>
                <td>a   </td>
            </tr>
        </table>
    </div>

    {{-- modal --}}

    {{-- modal add data --}}

    {{-- end modal add data --}}

    {{-- modal edit data --}}

    {{-- end modal edit data --}}

    {{-- modal delete data detail --}}
    @foreach ($barangs as $barang)
        <div class="modal modal-blur fade" id="deletedata{{ $barang->id }}" tabindex="-1" role="dialog"
            aria-hidden="true">
            <div class="modal-dialog w-50 modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-status bg-danger"></div>
                    <div class="modal-body text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                            <path d="M12 9v4" />
                            <path d="M12 17h.01" />
                        </svg>
                        <h6>Are you sure?</h6>
                        <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Merk:
                            *<b>{{ $barang->merk }}</b>)...</div>
                    </div>
                    <div class="modal-footer">
                        <div class="w-100">
                            <div class="row">
                                <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cancel
                                    </button></div>
                                <form action="/deletedetail" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_detail" value="{{ $barang->id }}">
                                    {{-- <input type="hidden" name="no_keranjang" value="{{ $keranjang->no_keranjang }}"> --}}
                                    <button class="btn btn-danger w-100">
                                        Yakin
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- end modal delete data detail --}}

    {{-- end modal --}}

    <script>
        $(document).ready(function() {
            $('#data-tables-keranjang').DataTable();
        });
    </script>
@endsection
