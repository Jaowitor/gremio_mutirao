@extends('layouts.layout-dois')
@section('bar')
<div class="bar-title" style="font-size: 24px; font-weight: bold;">
    Turma: <span style="font-weight: normal">{{ $category->name_category }}</span>
</div>

@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">{{ $category->name_category }}</h2>

    <div class="d-flex justify-content-end mb-3" style="gap: 10px;">
    <a href="{{ route('frequency.index', $category->id) }}" class="btn btn-outline-secondary">
        <i class="fas fa-clipboard"></i> Fazer Frequência
    </a>
    <a href="{{ route('category.add_student', $category->id) }}" class="btn btn-outline-success">Adicionar alunos
        <i class="fas fa-user-plus"></i>
    </a>
        
    </div>
    

    @forelse ($students as $student)
        <div class="d-flex align-items-center justify-content-between border rounded p-3 mb-2 shadow-sm bg-white">
            <div>
                <strong>{{ $loop->iteration }}.</strong> {{ $student->user->name ?? 'Sem nome' }}
            </div>
        </div>
    @empty
        <div class="alert alert-warning">
            Nenhum estudante associado a esta categoria.
        </div>
    @endforelse
</div>
@endsection