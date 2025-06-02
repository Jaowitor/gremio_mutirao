<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Home - Clube de Futebol</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <div class="drawer">
        <h2>Menu</h2>
        <ul>
            <li><i class="fas fa-home"></i> Home</li>
            <li><i class="fas fa-users"></i> Jogadores</li>
            <li><i class="fas fa-futbol"></i> Partidas</li>
            <li><i class="fas fa-cog"></i> Configurações</li>
            <li>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:#fff;cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="total-jogadores">
                <i class="fas fa-users"></i>
                Total de jogadores: <span style="margin-left:8px;">
                    {{ 4 }}
                </span>
            </div>
            <h1>Grêmio Mutirão</h1>
        </div>
        <div class="modulos">
            <div class="modulo-card">
                <i class="fas fa-users"></i>
                <div>Jogadores</div>
            </div>
            <div class="modulo-card">
                <i class="fas fa-futbol"></i>
                <div>Partidas</div>
            </div>
            <div class="modulo-card">
                <i class="fas fa-bullhorn"></i>
                <div>Avisos</div>
            </div>
        </div>
        <div class="avisos-dashboard">
            <h3>Avisos</h3>
            {{-- Exemplo de avisos. Troque por foreach do banco depois --}}
            <div class="aviso">
                <img src="https://randomuser.me/api/portraits/men/31.jpg" class="aviso-img" alt="Jogador">
                <div>
                    <span class="aviso-texto">O jogagor <span class="aviso-jogador">Lucas Silva</span> chegou a marca de 5 gols em duas partidas</span>
                </div>
            </div>
            <div class="aviso">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="aviso-img" alt="Jogador">
                <div>
                    <span class="aviso-texto">RISCO: O jogador <span class="aviso-jogador">Pedro Rocha</span> está com dois cartões amarelo.</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>