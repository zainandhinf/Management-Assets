<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    {{-- JQuery --}}
    <script src="assets/jquery/jquery-3.7.1.min.js"></script>
    <script src="../assets/jquery/jquery-3.7.1.min.js"></script>
    <script src="assets/jquery/jquery-3.7.0.js"></script>
    <script src="../assets/jquery/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script> --}}
    {{-- end JQuery --}}

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="assets/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/Bootstrap/css/bootstrap.min.css">
    <script src="assets/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/Bootstrap/js/bootstrap.min.js"></script>
    {{-- end Bootstrap --}}

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    {{-- end Font Awesome --}}

    {{-- DataTables --}}
    <link rel="stylesheet" href="assets/DataTables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js">
    <link rel="stylesheet" href="../assets/DataTables/dataTables.bootstrap5.min.css">
    <script src="assets/DataTables/jquery.dataTables.min.js"></script>
    <script src="../assets/DataTables/jquery.dataTables.min.js"></script>
    <script src="assets/DataTables/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/DataTables/dataTables.bootstrap5.min.js"></script>
    {{-- <link href="assets/DataTables/DataTables-1.13.6/css/jquery.dataTables.css" rel="stylesheet">
    <link href="../assets/DataTables/DataTables-1.13.6/css/jquery.dataTables.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" /> --}}
    {{-- end DataTables --}}

    {{-- Select2 --}}
    <link href="assets/select2/select2.min.css" rel="stylesheet" />
    <link href="../assets/select2/select2.min.css" rel="stylesheet" />
    <script src="assets/select2/select2.min.js"></script>
    <script src="../assets/select2/select2.min.js"></script>
    {{-- <link rel="stylesheet" href="assets/dselect-main/source/css/dselect.scss"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    {{-- end Select2 --}}

    {{-- Dropzone --}}
    <script src="assets/dropzone/min/dropzone.min.js"></script>
    <script src="../assets/dropzone/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="assets/dropzone/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="../assets/dropzone/min/dropzone.min.css" type="text/css" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.js"
    integrity="sha512-9e9rr82F9BPzG81+6UrwWLFj8ZLf59jnuIA/tIf8dEGoQVu7l5qvr02G/BiAabsFOYrIUTMslVN+iDYuszftVQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"
    integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    {{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> --}}
    {{-- end Dropzone --}}

    {{-- Style --}}
    <link rel="stylesheet" href="assets/css/sidebar.css">
    {{-- end Style --}}





    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500&display=swap" rel="stylesheet"> --}}
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        @font-face {
            font-family: 'Inter';
            src:
                /* url('fonts/Inter-Black.ttf') format('truetype'), */
                /* url('fonts/Inter-Bold.ttf') format('truetype'), */
                /* url('fonts/Inter-ExtraBold.ttf') format('truetype'), */
                /* url('fonts/Inter-ExtraLight.ttf') format('truetype'), */
                /* url('fonts/Inter-Light.ttf') format('truetype'), */
                url('fonts/Inter-Medium.ttf') format('truetype'),
                url('fonts/Inter-Regular.ttf') format('truetype'),
                url('fonts/Inter-SemiBold.ttf') format('truetype'),
                url('fonts/Inter-Thin.ttf') format('truetype'),
                url('fonts/Inter-VariableFont_slnt,wght.ttf') format('truetype');

            font-weight: 900;

            /* Tambahkan format-font lain jika Anda menyertakan format lainnya */
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
            font-family: 'Inter';
        }
    </style>

</head>

<body>
    <div class="container-fluid p-0 d-flex container-custom">
        @include('super_user.partials.sidebar')

        <div class="bg-light flex-fill overflow-auto" style="width: 200px">
            <div class="p-2 d-md-none d-flex text-white bg-success">
                <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                    <i class="fa-solid fa-bars"></i>
                </a>
                <span class="ms-3">Learning Center</span>
            </div>
            <div class="p-4" style="height: 100vh">
                <nav style="--bs-breadcrumb-divider:'>';font-size:14px">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="fa-solid fa-house"></i></li>
                        <li class="breadcrumb-item">Super User</li>
                        <li class="breadcrumb-item">{{ $title }}</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between">
                    <h3>{{ $title }}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        @yield('content')
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- JQuery --}}
    <script src="assets/jquery/jquery-3.7.1.min.js"></script>
    <script src="../assets/jquery/jquery-3.7.1.min.js"></script>
    <script src="assets/jquery/jquery-3.7.0.js"></script>
    <script src="../assets/jquery/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    {{-- <script src="assets/js/jquery-3.7.1.min.js"></script> --}}
    {{-- end JQuery --}}

    {{-- Bootstrap --}}
    <script src="assets/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/Bootstrap/js/bootstrap.min.js"></script>
    {{-- <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script> --}}
    {{-- end Bootstrap --}}

    {{-- DataTables --}}
    <script src="assets/DataTables/jquery.dataTables.min.js"></script>
    <script src="../assets/DataTables/jquery.dataTables.min.js"></script>
    <script src="assets/DataTables/dataTables.bootstrap5.min.js"></script>
    <script src="../assets/DataTables/dataTables.bootstrap5.min.js"></script>
    {{-- <script src="assets/DataTables/DataTables-1.13.6/js/jquery.dataTables.js"></script>
    <script src="../assets/DataTables/DataTables-1.13.6/js/jquery.dataTables.js"></script> --}}
    {{-- end DataTables --}}

    {{-- Select2 --}}
    <script src="assets/select2/select2.min.js"></script>
    <script src="../assets/select2/select2.min.js"></script>
    {{-- <script src="assets/dselect-main/source/js/dselect.js"></script> --}}
    {{-- end Select2 --}}

    {{-- Dropzone --}}
    <script src="assets/dropzone/min/dropzone.min.js"></script>
    <script src="../assets/dropzone/min/dropzone.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script> --}}
    {{-- end Dropzone --}}


    {{-- Js --}}
    {{-- <script src="assets/js/admin.js"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="../assets/js/sidebar.js"></script>
    <script src="assets/js/data.js"></script>
    <script src="../assets/js/data.js"></script> --}}
    {{-- end Js --}}

    {{-- Masknumber --}}
    <script src="assets/js/jquery.masknumber.js"></script>
    <script src="../assets/js/jquery.masknumber.js"></script>
    {{-- end Masknumber --}}
    <script>
        function toggleDataDropdown() {
            // console.log("berhasil");
            var dataDropdown = document.getElementById('dataDropdown');
            var dataDropdown2 = document.getElementById('dataDropdown2');

            // Toggle display dari <ul> ketika tautan diklik
            if (dataDropdown.style.display === 'block') {
                dataDropdown.style.display = 'none';
            } else {
                dataDropdown.style.display = 'block';
                dataDropdown2.style.display = 'none';
            }
        }

        function toggleDataDropdown2() {
            // console.log("berhasil");
            var dataDropdown = document.getElementById('dataDropdown2');
            var dataDropdown2 = document.getElementById('dataDropdown');

            // Toggle display dari <ul> ketika tautan diklik
            if (dataDropdown.style.display === 'block') {
                dataDropdown.style.display = 'none';
            } else {
                dataDropdown.style.display = 'block';
                dataDropdown2.style.display = 'none';
            }
        }
    </script>

</body>

</html>
