@extends('layouts.layout-dois')

@section('bar')
<div class="bar-content-wrapper">
    <div class="bar-title">
        Turmas
    </div>
    
    <div class="bar-search-container">
        <div class="bar-search-wrapper">
            <form method="GET" class="search-form" data-search-url="{{ route('students.index') }}">
                <input type="text" name="q" id="search-input" placeholder="Pesquisar aluno..." value="{{ request('q') }}">
            </form>
        </div>

        <a href="{{ route('category.create') }}" class="btn btn-success bar-action-button">
            <i class="fas fa-user-plus"></i> Nova Turma
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        @forelse($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">{{ $category->name_category }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ $category->description }}</p>
                        <p><strong>Idade:</strong> {{ $category->type_category }}</p>
                    </div>
                    <div class="card-footer text-center" style="background-color: #f8f9fa; border-top: 1px solid #dee2e6; display: flex;">
                        <a href="{{ route('category.show', $category->id) }}" class="btn btn-outline-primary btn-sm" style="flex: 1; margin-right: 5px;">
                            <i class="fas fa-edit"></i> alunos
                        </a>

                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm" style="flex: 1; margin-left: 5px;">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" style="flex: 1; margin-left: 5px;" onclick="return confirm('Tem certeza que deseja excluir esta turma?')">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-5 bg-light rounded">
                <p class="text-muted mb-0">Nenhuma turma encontrado.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-3 d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/category/category-index.css') }}">
@endpush
@endsection


