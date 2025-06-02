<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="login-container">
    <h1>Instituto Grêmio Mutirão</h1>
<img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="custom-input-wrapper">
            <span class="input-icon left">
                <i class="fas fa-envelope"></i>
            </span>
            <input 
                type="email" 
                name="email" 
                placeholder="Digite seu e-mail"
                class="custom-input has-left-icon"
                value="{{ old('email') }}"
                required
            >
        </div>

            <div class="custom-input-wrapper">
                <span class="input-icon left">
                    <i class="fas fa-lock"></i>
                </span>
                
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Digite sua senha"
                    class="custom-input has-left-icon has-right-icon"
                    id="password-input"
                >
                
                <span class="input-icon right toggle-password">
                    <i class="fas fa-eye"></i>
                </span>
            </div>


        <button type="submit" class="btn">Entrar</button>
    </form>

    @if($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            {{ $errors->first() }}
        </div>
    @endif
</div>

<div class="decorative-icons-bg">
    @php
        $iconClasses = [
            'fa-futbol',      // Bola de futebol
            'fa-trophy',      // Troféu
            'fa-whistle',     // Apito (use 'fa-solid fa-whistle' se tiver Font Awesome Pro, senão troque por outro)
            'fa-shirt',       // Camisa de futebol
            'fa-flag-checkered', // Bandeira de chegada
            'fa-users',       // Jogadores
        ];
        $colors = [
            'rgba(10,123,255,0.18)',   // azul claro
            'rgba(40,167,69,0.15)',   // verde
            'rgba(255,193,7,0.13)',   // amarelo
            'rgba(220,53,69,0.13)',   // vermelho
            'rgba(255,255,255,0.10)', // branco
        ];
        $icons = [];
        for ($i = 0; $i < 30; $i++) {
            $left = rand(0, 95); // porcentagem
            $top = rand(0, 95);
            $size = 22 + ($i % 3) * 10;
            $color = $colors[$i % count($colors)];
            $icon = $iconClasses[$i % count($iconClasses)];
            $icons[] = "<i class='fa-solid $icon decorative-icon' style='left:{$left}vw;top:{$top}vh;font-size:{$size}px;color:{$color};'></i>";
        }
        echo implode('', $icons);
    @endphp
</div>

<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
