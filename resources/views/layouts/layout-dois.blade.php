<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ asset('css/drawer-custom.css') }}">
    @stack('styles')

    <style>
        body {
            overflow: hidden;
            height: 100%;
        }

        .layout-container {
            display: flex;
            height: 100vh;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .bar {
            display: flex;      
            align-items: center; 
            /* justify-content: center; */
            background-color: #007BFF;
            height: 60px;
            padding: 0 15px;            /* Espaçamento interno opcional */
        }


        .breadcrumb-wrapper {
            padding: 10px 15px;
            background-color: #fafafa;
            border-bottom: 1px solid #e0e0e0;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="bar" title= "Barra de Navegação" style=" background-color: #007BFF; height: 60px;">
        @yield('bar')
    </div>
    <div class="layout-container">
        @include('layouts.navbar')
        <div class="content-wrapper">
            @php
                $rotaAtual = Route::currentRouteName();
                $breadcrumbs = $breadcrumbs_list ?? [];
            @endphp

            @if ($rotaAtual != 'dashboard')
                <div class="breadcrumb-wrapper">
                    @include('layouts.breadcrumbs')
                </div>
            @endif

            <div class="main-content">
                @yield('content')

                <div id="loader" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(255,255,255,0.8); z-index:9999; justify-content:center; align-items:center;">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/load.js') }}"></script>
    @yield('js')
</body>
</html>
