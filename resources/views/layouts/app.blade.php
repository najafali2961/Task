<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Support- Ticket">
    <meta name="author" content="AdminKit">
    <title>Support - Ticket</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('assets/img/icons/icon-48x48.png') }}" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">


</head>

<body>
    <div class="wrapper">

        @include('layouts.sidebar')
        <div class="main">
            @include('layouts.navbar')
            <main class="content">
                <div class="container-fluid p-0">

                    @yield('content')
                </div>
            </main>

            @include('layouts.footer')
        </div>
    </div>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @if ($errors->any())
        <script>
            var notyf = new Notyf();
            @foreach ($errors->all() as $error)
                notyf.error("{{ $error }}");
            @endforeach
        </script>
    @endif
    @if (session('success'))
        <script>
            var notyf = new Notyf();
            notyf.success("{{ session('success') }}");
        </script>
    @endif
    @if (session('error'))
        <script>
            var notyf = new Notyf();
            notyf.error("{{ session('error') }}");
        </script>
    @endif
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    @yield('scripts')
</body>

</html>
