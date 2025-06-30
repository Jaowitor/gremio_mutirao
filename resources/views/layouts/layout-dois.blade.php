<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="{{ asset('css/drawer-custom.css') }}">
    @stack('styles')

    <style>
        html, body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .bar {
            display: flex;
            align-items: center;
            justify-items: start;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            background-color: #007BFF;
            height: 60px;
            color: white;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .layout-container {
            display: flex;
            flex-direction: row;
            min-height: calc(100vh - 60px);
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: visible !important; 

        }
        
        /* ✨ Estilo para o container do breadcrumb */
        .breadcrumb-wrapper {
            position: sticky;
            top: 60px; /* Altura da .bar */
            background-color: #fff; /* Fundo para não ser transparente */
            z-index: 1019;
            box-shadow: 0 2px 4px rgba(0,0,0,.1); /* Sombra para destacar */
        }

        .main-content {
            flex: 1;
            width: 100%;
            justify-content: flex-start;
            overflow: visible !important;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="bar" title="Barra de Navegação">
        <button id="menu-toggle-btn" class="btn btn-primary d-md-none">
            <i class="fas fa-bars"></i>
        </button>
        
        @yield('bar')
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto toast-title"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <span class="toast-message"></span>
            </div>
        </div>
    </div>

    <div class="layout-container">

        <div class="drawer-fixed">
            @include('layouts.drawer')
        </div>
        
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script src="{{ asset('js/mask.js') }}"></script>
    <script src="{{ asset('js/load.js') }}"></script>
    <script src="{{ asset('js/toasts.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')

    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast("{{ session('success') }}", 'Sucesso', 'success');
            @endif

            @if(session('error'))
                showToast("{{ session('error') }}", 'Erro', 'error');
            @endif

            @if(session('warning'))
                showToast("{{ session('warning') }}", 'Aviso', 'warning');
            @endif
        });
    </script>
</body>
</html>