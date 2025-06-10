{{-- filepath: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- drawer --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <link rel="stylesheet" href="{{ asset('css/student-form.css') }}">

    @stack('styles')
    @push('scripts')
    <title>Grêmio Mutirão</title>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (!Request::is('students/create'))
                var elems = document.querySelectorAll('select');
                M.FormSelect.init(elems);
            @endif
        });
    </script>

    @endpush

</head>
<body>
    {{-- <div class="container"> --}}
        @yield('content')
    {{-- </div> --}}
    <!-- Materialize JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    @stack('scripts')
</body>
</html>