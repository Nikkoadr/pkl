<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('partials.header')
    @yield('link')
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            @include('partials.navbar')
            @include('partials.asidebar')
            @yield('content')
            @include('partials.footer')
        </div>
        <!-- ./wrapper -->
        <!-- jQuery -->
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
        @yield('scripts')
    </body>
</html>
