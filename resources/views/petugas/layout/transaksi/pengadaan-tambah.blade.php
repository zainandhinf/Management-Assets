@extends('petugas.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        <form action="/addkeranjang" method="post">
            @csrf
            <div class="row">

                <div class="col-6">
                    <div class="form-group">


                        <label for="">No. Pengadaan</label><br>
                        <input type="text" name="no_pengadaan" class="form-control w-100 mb-2" value="BB00001">

                        <label for="">No. Pengadaan</label><br>
                        <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">

                        <label for="">No. Pengadaan</label><br>
                        <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">

                        <label for="">No. Pengadaan</label><br>
                        <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">

                        <label for="">No. Pengadaan</label><br>
                        <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">

                    </div>
                </div>


                <div class="col-6">
                    <div class="form-group">

                        <label for="">No. Pengadaan</label><br>
                        <input type="text" name="no_pengadaan" class="form-control mb-2 w-100" value="BB00001">
                        <label for="">No. Pengadaan</label><br>
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
                        <input type="text" name="no_pengadaan" class="form-control mb-2" value="BB00001">


                    </div>

                </div>
            </div>



        </form>
    </div>
    {{-- end modal add data --}}

    {{-- modal edit data --}}

    {{-- end modal edit data --}}

    {{-- modal delete data --}}

    {{-- end modal delete data --}}

    {{-- end modal --}}
@endsection
