<div id="bdSidebar" style="overflow: auto" class="d-flex flex-column flex-shrink-0 p-3 bg-white offcanvas-md offcanvas-start"
    style="width: 280px;">
    <div class="navbar-brand d-flex mt-2">
        <div class="ms-3"><img src="assets/image/logoPTDIterbarucrop.jpg" width="50" alt=""></div>
        <div class="ms-3 fw-bold"><h5>Management <br>Assets - LC</h5></div>
    </div>
    <hr class="mb-1">
    <ul class="mynav nav nav-pills flex-column mb-auto mt-3">
        <li class="nav-item mb-1">
            <a href="/dashboard" class="{{ $title === 'Dashboard' ? 'active' : ''}}">
                <i class="fa-solid fa-gauge"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item active mb-0 dropdown-custom
        {{ $active === 'Data Petugas' || 'Data Pegawai' || 'Kategori Barang' || 'Tipe Ruangan' || 'Data Barang' || 'Data Ruangan' ? 'dropdown-active-custom' : '';  }}
        ">

            <button  onclick="toggleDataDropdown()" href="">
                <i class="fa-solid fa-database button-icon"></i>
                Data
                <i class="fa-solid fa-chevron-down down"></i>
            </button>


            <ul class="ms-2" id="dataDropdown">
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
                <li class="nav-item mb-0 dropdown-custom-child ms-2 {{ $active === 'data' ? 'dropdown-active-custom' : '' }}">
                    <button onclick="toggleDataDropdown3()" href=""
                        class="{{ $active === 'data' ? 'active-custom' : '' }}">
                        <i class="fa-solid fa-share-from-square"></i>
                        Kategori {{-- Jangan Panjang Panhjang ntar rusak --}}
                        <i class="fa-solid fa-chevron-down down"></i>
                    </button>
                    <ul id="dataDropdown3">
                        <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                            <a href="/admin-officer" class="{{ $title === 'Officer' ? 'active' : '' }}">
                                <i class="fa-solid fa-dolly"></i>
                                Kategori Barang
                            </a>
                        </li>
                        <li class="nav-item mb-1" style="background: #f7f7f7; border-radius: 8px;">
                            <a href="/admin-user" class="{{ $title === 'User' ? 'active' : '' }}">
                                <i class="fa-solid fa-tags"></i>
                                Tipe Ruangan
                            </a>
                        </li>



                    </ul>
                </li>
                <li class="nav-item mb-1">
                    <a href="/barang"  class="{{ $title === 'Data Barang' ? 'active' : '' }}">
                        <i class="fa-solid fa-computer"></i>
                        Barang - Properti
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/ruangan" class="{{ $title === 'Data Ruangan' ? 'active' : '' }}">
                        <i class="fa-solid fa-door-closed"></i>Ruangan
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mb-1">
            <a href="/admin-transactions" class="{{ $title === 'Transaction' ? 'active' : '' }}">
                <i class="fa-solid fa-chalkboard-user"></i>
                Training / Programs
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/admin-transactions" class="{{ $title === 'Transaction' ? 'active' : '' }}">
                <i class="fa-solid fa-cash-register"></i>
                Transactions
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/admin-reports" class="{{ $title === 'Reports' ? 'active' : '' }}">
                <i class="fa-solid fa-scroll"></i>
                Reports
            </a>
        </li>
    </ul>
    <hr class="mt-0 hr-custom">
    <div class="d-flex user-custom mb-0">
            <img src="assets/image/user.png" class="img-fluid rounded me-2"
                style="width: 50px; height: 50px; margin-top: 4px" alt="">
        <span style="margin-top: 4px">
            <h6 class="mt-1 mb-0">User</h6>
            <small>Super User</small>
        </span>
        <div class="logout" style="margin-bottom: 100px">
            <form action="/logout" method="POST">
                @csrf
                <button class="btn btn-primary" type="submit">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>

</div>
