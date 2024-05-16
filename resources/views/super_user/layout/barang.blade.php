@extends('super_user.main')

@section('content')
    <div class="card p-4" style="font-size: 14px;">
        @if ($cek > 0)
        <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal"
            data-bs-target="#adddata">
            <i class="fa-solid fa-folder-plus me-1"></i> Tambah Data
        </button>


        <table class="table table-striped" id="data-tables" style="font-size: 14px;">
            <thead>
                <tr>
                    <th>#</th>
                    {{-- <th>Kode Aktiva</th> --}}
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
            @php
                $qty = DB::table('detail_barangs')
                ->where('no_barang', '=', $barang->no_barang)
                ->count()
            @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    {{-- <td>{{ $city->id }}</td> --}}
                    {{-- <td>{{ $barang->kode_aktiva }}</td> --}}
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->nama_kategori }}</td>
                    <td>{{ $qty }}</td>
                    <td>
                        <button data-bs-toggle="modal" data-bs-target="#editdata{{ $barang->id }}" style="margin-right: 10px"
                            class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                        <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $barang->id }}" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>



                    </td>
                </tr>
            @endforeach
        </table>




        @else
        <b>
            <h5>
                *Note: Data Barang hanya bisa dibuat ketika kamu sudah mengisi <a href="/kategori-barang">Data Kategori Barang</a> terlebih dahulu !
            </h5>
        </b>
        @endif

    </div>

    {{-- modal --}}

    {{-- modal add data --}}
    <div class="modal modal-blur fade" id="adddata" tabindex="-1" role="dialog" aria-hidden="true"
        style="font-size: 14px;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/addbarang" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="no_barang" class="col-form-label">No. Barang :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('no_barang')
                  is-invalid
              @enderror"
                                placeholder="No Barang.." id="name" name="no_barang" value="{{ $kode_barang }}" readonly>
                            @error('nobarang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror



                            <label for="nama_barang" class="col-form-label">Nama Barang :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('nama_barang')
                                is-invalid
                                @enderror"
                                placeholder="Nama Barang.." id="name" name="nama_barang">
                            @error('nama_barang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label for="kode_awal" class="col-form-label">Kode Unik(Untuk No. asset) :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('kode_awal')
                                is-invalid
                                @enderror"
                                placeholder="Masukan kode unik untuk no. asset(KL atau MS atau LP).." id="name" name="kode_awal">
                            @error('kode_awal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <label for="id_kategori" class="col-form-label">Kategori Barang :</label>
                            <div class="input-group">
                                <select style="font-size: 14px;"
                                    class="form-select @error('id_kategori') is-invalid
                                            @enderror"
                                    name="id_kategori">
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach

                                </select>
                            </div>
                            @error('id_kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror


                            {{-- <label for="qty" class="col-form-label">Kuantitas(angka) :</label> --}}
                            <input style="font-size: 14px;" type="hidden"
                                class="form-control @error('qty')
                  is-invalid
              @enderror"
                                placeholder="Qty.." id="name" name="qty" value="0">
                            @error('qty')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
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
     @foreach ($barangs as $barang)
     <div class="modal modal-blur fade" id="editdata{{ $barang->id }}" tabindex="-1" role="dialog"
         aria-hidden="true" style="font-size: 14px;">
         <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title fs-6">Edit {{ $title }}</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form action="/editbarang" method="post">
                         @csrf
                         @method('PUT')
                         <input type="hidden" name="id_barang" value="{{ $barang->id }}">
                         <div class="form-group">
                             <label for="name" class="col-form-label">No. Barang :</label>
                             <input name="no_barang" style="font-size: 14px;" type="text"
                                 class="form-control @error('no_barang') fs-6 is-invalid @enderror" placeholder="No Barang.." id="name"
                                 value="{{ $barang->no_barang }}" readonly>
                             @error('no_barang')
                                 <div class="invalid-feedback">
                                     {{ $message }}
                                 </div>
                             @enderror

                             <label for="name" class="col-form-label">Nama Barang :</label>
                             <input name="nama_barang" style="font-size: 14px;" type="text"
                                 class="form-control @error('kode_aktiva') fs-6 is-invalid @enderror" placeholder="Nama Barang.." id="name"
                                 value="{{ $barang->nama_barang }}" required>
                             @error('nama_barang')
                                 <div class="invalid-feedback">
                                     {{ $message }}
                                 </div>
                             @enderror

                             <label for="kode_awal" class="col-form-label">Kode Unik(Untuk No. asset) :</label>
                             <input style="font-size: 14px;" type="text" value="{{ $barang->kode_awal }}"
                                 class="form-control @error('kode_awal')
                                 is-invalid
                                 @enderror"
                                 placeholder="Masukan kode unik untuk no. asset(KL atau MS atau LP).." id="name" name="kode_awal">
                             @error('kode_awal')
                                 <div class="invalid-feedback">
                                     {{ $message }}
                                 </div>
                             @enderror

                             <label for="name" class="col-form-label">Nama Kategori :</label>
                             <select style="font-size: 14px;" class="form-select @error('id_kategori') is-invalid @enderror"
                                name="id_kategori">

                                    <option value="{{ $barang->id_kategori }}" selected><b>{{ $barang->nama_kategori }}(Selected Now)</b></option>

                                    @foreach ($kategoris as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama_kategori }}</option>
                                    @endforeach

                            </select>
                             @error('id_kategori')
                                 <div class="invalid-feedback">
                                     {{ $message }}
                                 </div>
                             @enderror

                             {{-- <label for="name" class="col-form-label">Kuantitas(angka) :</label> --}}
                             <input name="qty" style="font-size: 14px;" type="hidden"
                                 class="form-control @error('kode_aktiva') fs-6 is-invalid @enderror" placeholder="Nama Barang.." id="name"
                                 value="{{ $barang->qty }}" required>
                             @error('qty')
                                 <div class="invalid-feedback">
                                     {{ $message }}
                                 </div>
                             @enderror
                         </div>

                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
                         Cancel
                     </button>
                     <button type="submit" class="btn btn-primary" style="font-size: 14px;">Edit Data</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 @endforeach
 {{-- end modal edit data --}}

  {{-- modal delete data --}}
  @foreach ($barangs as $barang)
  <div class="modal modal-blur fade" id="deletedata{{ $barang->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                  <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Nama Barang: *<b>{{ $barang->nama_barang }}</b>)...</div>
              </div>
              <div class="modal-footer">
                  <div class="w-100">
                      <div class="row">
                          <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                  aria-label="Close">
                                  Cancel
                              </button></div>
                          <form action="/deletebarang" method="post">
                              @csrf
                              @method('DELETE')
                              <input type="hidden" name="id_barang" value="{{ $barang->id }}">
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
  {{-- end modal delete data --}}


@endsection
