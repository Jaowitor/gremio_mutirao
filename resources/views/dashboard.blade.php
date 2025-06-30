@extends('layouts.layout-dois')

@section('content')
    <div class="header" style="display: flex; align-items: start; padding: 20px; justify-content: space-between; background-color: #f8f9fa; border-bottom: 1px solid #dee2e6;">
        <div class="total-jogadores">
            <i class="fas fa-users"></i>
            Total de Atletas: <span style="margin-left:8px;">
                {{ $totalJogadores ?? '0' }}
            </span>
        </div>
    </div>

    <div class="modulos" style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">
        <a href="{{ route('students.index') }}" class="modulo-link" style="text-decoration: none;">
            <div class="modulo-card" >
                <i class="fas fa-users"></i>
                <div>Alunos</div>
            </div>
        </a>
        <a href="{{ route('category.index') }}" class="modulo-link" style="text-decoration: none;">
        <div class="modulo-card">
            <i class="fas fa-clipboard"></i>
            <div>Turmas</div>
        </div>
        </a>
        <div class="modulo-card" id="aviso-module" style="cursor: pointer;">
            <i class="fas fa-bullhorn"></i>
            <div>Avisos</div>
        </div>
        <a href="{{ route('training.index') }}" class="modulo-link" style="text-decoration: none;">
        <div class="modulo-card">
            <i class="fas fa-futbol"></i>
            <div>Treinos</div>
        </div>
        </a>
    </div>

    <div class="avisos-dashboard">
        <h3>Avisos</h3>
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

@push('scripts')
<script>
    document.getElementById('aviso-module').addEventListener('click', function() {
        showToast('Este módulo ainda está em desenvolvimento.', 'Em Breve!', 'warning');
    });
</script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@endsection