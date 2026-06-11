<!DOCTYPE html>
<html lang="en">

@include('layout.head')

<body>
    <div id="app">

        @include('layout.sidebar')

        <div id="main">

            @include('layout.navbar')

            <div class="page-content">
                @yield('content')
            </div>

            @include('layout.footer')

        </div>
    </div>

<script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
<script src="{{ asset('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/compiled/js/app.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>