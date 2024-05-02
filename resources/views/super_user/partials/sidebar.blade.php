<div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-white offcanvas-md offcanvas-start"
    style="width: 280px;">
    <div class="navbar-brand d-flex mt-2">
        <div class="ms-3"><img src="assets/image/logoPTDIterbarucrop.jpg" width="50" alt=""></div>
        <div class="ms-3 fw-bold"><h5>Management <br>Assets</h5></div>
    </div>
    <hr class="mb-1">
    <ul class="mynav nav nav-pills flex-column mb-auto mt-3">
        <li class="nav-item mb-1">
            <a href="admin-dashboard" class="{{ $title === 'Dashboard' ? 'active' : '' }}">
                <i class="fa-solid fa-gauge"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item mb-0 dropdown-custom {{ $active === 'data' ? 'dropdown-active-custom' : '' }}">
            <button onclick="toggleDataDropdown()" href=""
                class="{{ $active === 'data' ? 'active-custom' : '' }}">
                <i class="fa-solid fa-database button-icon"></i>
                Data
                <i class="fa-solid fa-chevron-down down"></i>
            </button>
            <ul id="dataDropdown">
                <li class="nav-item mb-1">
                    <a href="/admin-officer" class="{{ $title === 'Officer' ? 'active' : '' }}">
                        <i class="fa-solid fa-user"></i>
                        Officer
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin-user" class="{{ $title === 'User' ? 'active' : '' }}">
                        <i class="fa-solid fa-user"></i>
                        User
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin-provinces" class="{{ $title === 'Provinces' ? 'active' : '' }}">
                        <i class="fa-solid fa-map-location-dot"></i>
                        Provinces
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin-city" class="{{ $title === 'City' ? 'active' : '' }}">
                        <i class="fa-solid fa-city"></i>
                        Cities
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin-countries" class="{{ $title === 'Countries' ? 'active' : '' }}">
                        <i class="fa-solid fa-globe"></i>
                        Countries
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin-catalog" class="{{ $title === 'Catalog' ? 'active' : '' }}">
                        <i class="fa-solid fa-list"></i>
                        Catalogs
                    </a>
                </li>

                {{-- <li class="nav-item mb-1">
                    <a href="/admin-transportations" class="{{ $title === 'Transportation' ? 'active' : '' }}">
                        <i class="fa-solid fa-car"></i>
                        Transportations
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin-payments" class="{{ $title === 'Payment Method' ? 'active' : '' }}">
                        <i class="fa-solid fa-credit-card"></i>
                        Payments Method
                    </a>
                </li> --}}
            </ul>
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
