@extends('layouts.layout-dois')


@section('bar')
<div class="bar-content-wrapper">

    <div class="bar-title">
        Treinos
    </div>
    
    <div class="bar-search-container">
        <div class="bar-search-wrapper">
            <form method="GET" class="search-form" data-search-url="{{ route('students.index') }}">
                <input type="text" name="q" id="search-input" placeholder="Pesquisar aluno..." value="{{ request('q') }}">
            </form>
        </div>

        <a href="{{ route('training.create') }}" class="btn btn-success bar-action-button">
            <i class="fas fa-user-plus"></i> Novo Treino
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container mt-4">
    <div class="detailed-list">
        @forelse($trainings as $training)
            <div class="training-item">
                <div class="item-header">
                    <h5 class="item-date">{{ $training->dia_da_semana }} - {{ $training->dia_do_mes}} de {{ $training->mes_em_portugues }} - {{$training->time_training}} horas</h5>
                    <div class="item-actions" style="display: flex; gap: 10px;">
                        <a href="{{ route('training.edit', $training->id) }}" class="btn btn-warning btn-sm" style="justify-content: center; align-items: center;">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('training.showCategory', $training->id) }}" class="btn btn-outline-primary btn-sm" style="justify-content: center; align-items: center; display: flex;">
                            <i class="fas fa-edit"></i> Turma - Frequência
                        </a>
                        <form action="{{ route('training.destroy', $training->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>
                </div>
                <div class="item-body">
                    <p>{{ $training->description }}</p>
                    <small class="text-muted"><strong>Planejamento:</strong> {{ $training->planejamento }}</small>
                </div>
            </div>
        @empty
            <div class="text-center p-5 bg-light rounded">
                <p class="text-muted mb-0">Nenhum treino encontrado.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/training/training-index.css') }}">
@endpush