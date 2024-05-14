@extends('petugas.main')

@section('content')
<div class="card p-4" style="font-size: 14px;">
    <button onclick="ShowModal1()" type="button" class="btn btn-primary btn-sm mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#addpegawai">
    <i class="fa-solid fa-folder-plus me-1"></i> Tambah Data
</button>
    <table class="table table-striped" id="data-tables">
        <thead>
            <tr>
                <th>#</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Gender</th>

                {{-- <th>Alamat</th> --}}
                <th>No Telp</th>
                {{-- <th>Foto</th> --}}
                {{-- <th data-searchable="false">Action</th> --}}
            </tr>
        </thead>
         @foreach ($pegawais as $pegawai)
        @php
            $no = 1;
        @endphp
         <tr>
             <td>{{ $no++ }}</td>
             {{-- <td>{{ $city->id }}</td> --}}
             {{-- <td>lorem</td> --}}
             <td>{{ $pegawai->nik }}</td>
             <td>{{ $pegawai->nama_user }}</td>
             <td>
                 @if($pegawai->jenis_kelamin === 'L')
                     Laki-Laki
                 @else
                     Perempuan
                 @endif
             </td>
             {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
             {{-- <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut, ipsa.</td> --}}
             <td>{{ $pegawai->no_telepon }}</td>

             {{-- <td>
                 <button data-bs-toggle="modal" data-bs-target="#editdata{{ $pegawai->id }}"
                     style="margin-right: 10px" class="btn btn-primary mr-2"><i class="fa-regular fa-eye"></i></button>

                 <button data-bs-toggle="modal" data-bs-target="#editdata{{ $pegawai->id }}"
                     style="margin-right: 10px" class="btn btn-warning mr-2"><i class="fa fa-edit"></i></button>
                 <button data-bs-toggle="modal" data-bs-target="#deletedata{{ $pegawai->id }}"
                     class="btn btn-danger mt-1">
                     <i class="fa fa-trash"></i>
                 </button>
             </td> --}}
         </tr>



@endforeach
    </table>
</div>


{{-- modal add data --}}
<div class="modal modal-blur fade" id="addpegawai" tabindex="-1" role="dialog"
style="font-size: 14px;">
<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/addpegawai" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label">NIK :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('nik') is-invalid @enderror"
                                placeholder="NIK.." id="name" name="nik">
                                   @error('nik')
                                       <div class="invalid-feedback">
                                           {{ $message }}
                                       </div>
                                   @enderror
                            <label for="name" class="col-form-label">Nama pegawai :</label>
                            <input style="font-size: 14px;" type="text"
                                class="form-control @error('nama_user') is-invalid @enderror"
                                placeholder="Nama pegawai.." id="name" name="nama_user">
                                   @error('nama_user')
                                       <div class="invalid-feedback">
                                           {{ $message }}
                                       </div>
                                   @enderror
                            <label for="name" class="col-form-label">Gender :</label>
                            <div class="input-group">
                                <select style="font-size: 14px;"
                                   class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                   name="jenis_kelamin">
                                       <option value="L">Laki-Laki</option>
                                       <option value="P">Perempuan</option>
                                </select>
                            </div>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label for="name" class="col-form-label">Alamat :</label>
                            <textarea style="font-size: 14px;" type="text"
                               class="form-control @error('alamat') is-invalid @enderror"
                               placeholder="Alamat.." id="name" name="alamat"></textarea>
                                   @error('alamat')
                                       <div class="invalid-feedback">
                                           {{ $message }}
                                       </div>
                                   @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="col-form-label">No Telepon :</label>
                            <input style="font-size: 14px;" type="text"
                               class="form-control @error('no_telepon') is-invalid @enderror"
                               placeholder="No telepon.." id="name" name="no_telepon">
                                   @error('no_telepon')
                                       <div class="invalid-feedback">
                                           {{ $message }}
                                       </div>
                                   @enderror


                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-size: 14px;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="font-size: 14px;">Create Data</button>
            </div>
        </form>
    </div>

</div>
</div>
</div>
{{-- end modal add data --}}

  {{-- modal edit data --}}
  @foreach ($pegawais as $pegawai)
  <div class="modal modal-blur fade" id="editdata{{ $pegawai->id }}" tabindex="-1" role="dialog"
      aria-hidden="true" style="font-size: 14px;">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title fs-6">Tambah {{ $title }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="/editpegawai" method="post">
                @csrf
                  <div class="modal-body">
                      <div class="row">
                          @csrf
                          @method('PUT')
                          <input type="hidden" value="{{ $pegawai->id }}" name="id_user">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="name" class="col-form-label">NIK :</label>
                                  <input style="font-size: 14px;" type="text"
                                      class="form-control @error('nik') is-invalid @enderror"
                                      placeholder="NIK.." id="name" name="nik"
                                      value="{{ $pegawai->nik }}" required>
                                  @error('nik')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                                  <label for="name" class="col-form-label">Nama Pegawai :</label>
                                  <input style="font-size: 14px;" type="text"
                                      class="form-control @error('nama_user') is-invalid @enderror"
                                      placeholder="Nama pegawai.." id="name" name="nama_user"
                                      value="{{ $pegawai->nama_user }}" required>
                                  @error('nama_user')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                                  <label for="name" class="col-form-label">Gender :</label>
                                  <div class="input-group">
                                      @if ($pegawai->jenis_kelamin === 'L')
                                      <select style="font-size: 14px;"
                                          class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                          name="jenis_kelamin">

                                              <option value="L" selected><b>Laki-Laki</b></option>
                                              <option value="P">Perempuan</option>

                                          </select>
                                          @elseif($pegawai->jenis_kelamin === 'P')
                                          <select style="font-size: 14px;"
                                          class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                          name="jenis_kelamin">

                                              <option value="P" selected><b>Perempuan</b></option>
                                              <option value="L">Laki-Laki</option>

                                          </select>
                                          @endif
                                  </div>
                                  @error('jenis_kelamin')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                                  <label for="name" class="col-form-label">Alamat :</label>
                                  <textarea style="font-size: 14px;" type="text"
                                      class="form-control @error('alamat')
                                        is-invalid
                                    @enderror" placeholder="Alamat.."
                                      id="name" name="alamat">{{ $pegawai->alamat }}</textarea>
                                  @error('alamat')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="name" class="col-form-label">No Telepon :</label>
                                  <input style="font-size: 14px;" type="text"
                                      class="form-control @error('no_telepon')
                                            is-invalid
                                        @enderror"
                                      placeholder="No telepon.." id="name" name="no_telepon"
                                      value="{{ $pegawai->no_telepon }}">
                                  @error('no_telepon')
                                      <div class="invalid-feedback">
                                          {{ $message }}
                                      </div>
                                  @enderror

                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                          style="font-size: 14px;">
                          Cancel
                      </button>
                      <button type="submit" class="btn btn-primary" style="font-size: 14px;">Edit Data</button>
                  </div>
              </form>
          </div>

      </div>
  </div>
  </div>
@endforeach
{{-- end modal edit data --}}

 {{-- modal delete data --}}
 @foreach ($pegawais as $pegawai)
 <div class="modal modal-blur fade" id="deletedata{{ $pegawai->id }}" tabindex="-1" role="dialog"
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
                 <div class="text-muted">Yakin? Anda akan menghapus data ini <br> (Nama Pegawai:
                     *<b>{{ $pegawai->nama_user }}</b>)...</div>
             </div>
             <div class="modal-footer">
                 <div class="w-100">
                     <div class="row">
                         <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                 aria-label="Close">
                                 Cancel
                             </button></div>
                         <form action="/deletepegawai" method="post">
                             @csrf
                             @method('DELETE')
                             <input type="hidden" name="id_user" value="{{ $pegawai->id }}">
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
