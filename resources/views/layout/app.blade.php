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

    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>