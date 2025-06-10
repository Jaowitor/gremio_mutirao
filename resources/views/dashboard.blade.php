@extends('layouts.layout-dois')

@section('content')
    <div class="header">
        <div class="total-jogadores">
            <i class="fas fa-users"></i>
            Total de jogadores: <span style="margin-left:8px;">
                {{ $totalJogadores ?? '0' }}
            </span>
        </div>

        <h1>Grêmio Mutirão</h1>
    </div>

    <div class="modulos">
        <a href="{{ route('students.index') }}" class="modulo-link">
            <div class="modulo-card">
                <i class="fas fa-users"></i>
                <div>Jogadores</div>
            </div>
        </a>
        <a href="{{ route('students.create') }}" class="modulo-link">
        <div class="modulo-card">
            <i class="fas fa-futbol"></i>
            <div>Partidas</div>
        </div>
        </a>
        <div class="modulo-card">
            <i class="fas fa-bullhorn"></i>
            <div>Avisos</div>
        </div>
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
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@endsection