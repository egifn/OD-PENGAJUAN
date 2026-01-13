<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Tirta Utama Abaid">
    <meta name="author" content="Tua">
    <meta name="keyword" content="Tirta Utama Abadi">

    @yield('title')

    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/treeview.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/pace-progress/css/pace.min.css') }}"
        rel="stylesheet">

    <!--datepicker-->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
        rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    <!--     -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--     -->

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">

    @include('layouts.module.header')

    <div class="app-body" id="dw">
        <div class="sidebar">

            @include('layouts.module.sidebar')

            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>

        @yield('content')

    </div>

    <footer class="app-footer">
        <div>
            <a style="color: #000" href="{{ route('home') }}">Tirta Utama Abadi</a>
            <span>&copy; 2021 TUA Group.</span>
        </div>
        <!--
        <div class="ml-auto">
            <span>Powered by</span>
            <a href="https://coreui.io">CoreUI</a>
        </div>
        -->
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil semua element alert
            const alerts = document.querySelectorAll('.alert');

            // Set timeout untuk setiap alert
            alerts.forEach(alert => {
                setTimeout(() => {
                    // Tambahkan animasi fade out
                    alert.style.transition = 'opacity 1s ease-out';
                    alert.style.opacity = '0';

                    // Hapus element setelah animasi selesai
                    setTimeout(() => {
                        alert.remove();
                    }, 1000);
                }, 3000); // Alert akan hilang setelah 3 detik (3000ms)
            });
        });

    </script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/coreui.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-tooltips.min.js') }}"></script>
    <script src="{{ asset('assets/js/treeview.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.js') }}"></script>

    <script src="{{ asset('assets/maskmoney/jquery.maskMoney.js') }}"></script>
    <script src="{{ asset('assets/maskmoney/jquery.maskMoney.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });

    </script>
    @include('sweetalert::alert')


    @yield('js')
</body>

</html>
