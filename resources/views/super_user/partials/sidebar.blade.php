<div id="bdSidebar" style="overflow: hidden; height: 100vh;"
    class="d-flex flex-column flex-shrink-0 p-3 bg-white offcanvas-md offcanvas-start" style="width: 280px;">
    <div class="navbar-brand d-flex mt-2">
        <div class="ms-3"><img src="assets/image/logoPTDIterbarucrop.jpg" width="50" alt=""></div>
        <div class="ms-3 fw-bold">
            <h5>Management <br>Assets - LC</h5>
        </div>
    </div>
    <hr class="mb-1">
    <div style="height: 100%; width: 245px; overflow-y: scroll; margin-bottom: 5px;">

        <ul class="mynav nav nav-pills d-flex flex-column mb-auto mt-3" style="margin-right: 2px;">
            <li class="nav-item mb-1">
                <a href="/dashboard" class="{{ $title === 'Dashboard' ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i>
                    Dashboard
                </a>
            </li>
            <li
                class="nav-item active mb-0 dropdown-custom @if (
                    $active == 'Data Petugas' ||
                        'Data Pegawai' ||
                        'DataKategori Barang' ||
                        'Data Tipe Ruangan' ||
                        'Data Barang' ||
                        'Data Ruangan') dropdown-active-custom @endif
        {{-- {{ $active === 'Data Petugas' || 'Data Pegawai' || 'Kategori Barang' || 'Tipe Ruangan' || 'Data Barang' || 'Data Ruangan' ? 'dropdown-active-custom' : '' }} --}}
        ">

                <button onclick="toggleDataDropdown()" href="">
                    <div class="customtoogle">
                        <i class="fa-solid fa-database button-icon"></i>
                        Data
                    </div>
                    <i class="fa-solid fa-chevron-down down mt-1"></i>
                </button>
                <ul class="ms-2" id="dataDropdown"
                    @if ($open == 'yes') style="display: block;" @else style="display: none;" @endif>
                    <li class="nav-item mb-1">
                        <a href="/petugas" class="{{ $title === 'Data Petugas' ? 'active' : '' }}">
                            <i class="fa-solid fa-user-gear"></i>
                            Petugas
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/pegawai" class="{{ $title === 'Data Pegawai' ? 'active' : '' }}">
                            <i class="fa-solid fa-users"></i>
                            Pegawai
                        </a>
                    </li>
                    <li
                        class="nav-item mb-0 dropdown-custom-child {{ $active === 'data' ? 'dropdown-active-custom' : '' }}">
                        <button onclick="toggleDataDropdown3()" href=""
                            class="{{ $active === 'data' ? '' : '' }}">
                            <div class="customtoogle">
                                <i class="fa-solid fa-share-from-square"></i>
                                Kategori {{-- Jangan Panjang Panhjang ntar rusak --}}
                            </div>
                            <i class="fa-solid fa-chevron-down down mt-1"></i>
                        </button>
                        <ul id="dataDropdown3" class="ms-2">
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/kategori-barang"
                                    class="{{ $title === 'Data Kategori Barang' ? 'active' : '' }}">
                                    <i class="fa-solid fa-dolly"></i>
                                    Kategori Barang
                                </a>
                            </li>
                            <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                                <a href="/tipe-ruangan" class="{{ $title === 'Data Tipe Ruangan' ? 'active' : '' }}">
                                    <i class="fa-solid fa-tags"></i>
                                    Tipe Ruangan
                                </a>
                            </li>



                        </ul>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/barang" class="{{ $title === 'Data Barang' ? 'active' : '' }}">
                            <i class="fa-solid fa-computer"></i>
                            Barang - Properti
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/ruangan" class="{{ $title === 'Data Ruangan' ? 'active' : '' }}">
                            <i class="fa-solid fa-door-closed"></i>Ruangan
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="/data-training" class="{{ $title === 'Data Training' ? 'active' : '' }}">
                            <i class="fa-solid fa-chalkboard-user"></i>Training
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item mb-1 mt-1">
                <a href="/training" class="{{ $title === 'Data Jadwal Training' ? 'active' : '' }}">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Training / Programs
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="/admin-reports" class="{{ $title === 'Reports' ? 'active' : '' }}">
                    <i class="fa-solid fa-scroll"></i>
                    Reports
                </a>
            </li>
        </ul>
    </div>
    <hr class="mt-0 hr-custom">
    <div class="d-flex user-custom">
        <a href="/profile">
            @if (auth()->user()->foto == null)
                <img src="assets/image/user.png" class="img-fluid rounded rounded-circle me-2"
                    style="width: 50px; height: 50px; margin-top: 4px;" alt="">
            @else
                <img src="{{ asset('storage/' . auth()->user()->foto) }}" class="img-fluid rounded rounded-circle me-2"
                    style="width: 50px; height: 50px; margin-top: 4px;" alt="">
            @endif
        </a>
        <span style="margin-top: 4px;">
            <h6 class="mt-1 mb-0" style="font-size: 14px;">{{ auth()->user()->username }}</h6>
            <div class="d-flex">
                <small class="me-1">Super</small>
                <small>User</small>
            </div>
        </span>
        <div class="logout" style="margin-bottom: 100px">
            <button class="btn" style="background: #0d3b66" data-bs-toggle="modal" data-bs-target="#logout">
                <i class="fa-solid fa-power-off text-white"></i>
            </button>
        </div>
    </div>

</div>

<div class="modal modal-blur fade" id="logout" tabindex="-1" role="dialog" aria-hidden="true">
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
                <div class="text-muted">Yakin? Anda akan Keluar dari halaman ini...</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><button class="btn w-100 mb-2" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button></div>
                        <form action="/logout" method="post">
                            @csrf
                            {{-- @method('DELETE') --}}
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
