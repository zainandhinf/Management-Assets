<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MALc | {{ $title }}</title>

    {{-- JQuery --}}
    <script src="assets/jquery/jquery-3.7.1.min.js"></script>
    <script src="../assets/jquery/jquery-3.7.1.min.js"></script>
    <script src="assets/jquery/jquery-3.7.0.js"></script>
    <script src="../assets/jquery/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- end JQuery --}}

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="assets/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/Bootstrap/css/bootstrap.min.css">
    <script src="assets/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/Bootstrap/js/bootstrap.min.js"></script>
    <link href="/assets/demo/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/demo/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/demo/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/demo/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="/assets/demo/dist/css/demo.min.css?1684106062" rel="stylesheet" />
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

    {{-- Style --}}
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/ruangan.css">
    {{-- end Style --}}

    <style>
        @import url('https://rsms.me/inter/inter.css');


        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        @font-face {
            font-family: 'Inter';
            src:
                url('/assets/fonts/Inter-Medium.ttf') format('truetype'),
                url('/assets/fonts/Inter-Regular.ttf') format('truetype'),
                url('/assets/fonts/Inter-SemiBold.ttf') format('truetype'),
                url('/assets/fonts/Inter-Thin.ttf') format('truetype'),
                url('/assets/fonts/Inter-VariableFont_slnt,wght.ttf') format('truetype');
            font-weight: 900;
        }

        /* ANIMASI MASUK */
        @keyframes transitionIn {
            from {
                opacity: 0;
                /* transform: rotateX(-10deg); */
                margin-left: 20px;
            }

            to {
                opacity: 1;
                /* transform: rotateX(0); */
                margin-left: 0px;
            }

        }



        body {
            font-feature-settings: "cv03", "cv04", "cv11";
            font-family: 'Inter';
        }

        .page-content {
            animation: transitionIn 0.55s;

        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #e2e3e5;
        }
    </style>

</head>

<body style="font-family: 'Inter';">
    @include('sweetalert::alert')

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
                    @if (session()->has('success'))
                        <div class="alert alert-success position-absolute end-0 me-5 z-1" role="alert"
                            style="margin-top: -10px;">
                            {{ session('success') }}
                        </div>
                    @elseif (session()->has('error'))
                        <div class="alert alert-warning position-absolute end-0 me-5 z-1" role="alert"
                            style="margin-top: -10px;">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
                <hr>
                <div class="row">
                    <div class="col page-content">
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
            var dataDropdown3 = document.getElementById('dataDropdown3');

            // Toggle display dari <ul> ketika tautan diklik
            if (dataDropdown.style.display === 'block') {
                dataDropdown.style.display = 'none';
            } else {
                dataDropdown.style.display = 'block';
                dataDropdown3.style.display = 'none';
            }
        }

        // function toggleDataDropdown2() {
        //     // console.log("berhasil");
        //     var dataDropdown = document.getElementById('dataDropdown2');
        //     var dataDropdown2 = document.getElementById('dataDropdown');

        //     // Toggle display dari <ul> ketika tautan diklik
        //     if (dataDropdown.style.display === 'block') {
        //         dataDropdown.style.display = 'none';
        //     } else {
        //         dataDropdown.style.display = 'block';
        //         dataDropdown2.style.display = 'none';
        //     }
        // }

        function toggleDataDropdown3() {
            // console.log("berhasil");
            var dataDropdown3 = document.getElementById('dataDropdown3');

            // Toggle display dari <ul> ketika tautan diklik
            if (dataDropdown3.style.display === 'block') {
                dataDropdown3.style.display = 'none';
            } else {
                dataDropdown3.style.display = 'block';
                // dataDropdown2.style.display = 'none';

            }
        }

        $(document).ready(function() {
            $('#data-tables').DataTable();
        });
        $(document).ready(function() {
            $('#data-tables-detail').DataTable();
        });

        $(document).ready(function() {
            if ($(".alert-success").length > 0) {
                setTimeout(function() {
                    $(".alert-success").fadeOut(
                        500); // Ubah nilai 500 dengan durasi fade out yang diinginkan (dalam milidetik)
                }, 3000); // Ubah nilai 3000 dengan waktu tunda sebelum fade out (dalam milidetik)
            }
        });
        $(document).ready(function() {
            if ($(".alert-warning").length > 0) {
                setTimeout(function() {
                    $(".alert-warning").fadeOut(
                        500); // Ubah nilai 500 dengan durasi fade out yang diinginkan (dalam milidetik)
                }, 3000); // Ubah nilai 3000 dengan waktu tunda sebelum fade out (dalam milidetik)
            }
        });
    </script>


</body>

</html>
