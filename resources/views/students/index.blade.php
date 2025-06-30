
@extends('layouts.layout-dois')
@section('bar')
<div class="bar-content-wrapper">

    <div class="bar-title">
        Alunos
    </div>
    
    <div class="bar-search-container">
        <div class="bar-search-wrapper">
            <form method="GET" class="search-form" data-search-url="{{ route('students.index') }}">
                <input type="text" name="q" id="search-input" placeholder="Pesquisar aluno..." value="{{ request('q') }}">
            </form>
        </div>

        <a href="{{ route('students.create') }}" class="btn btn-success bar-action-button">
            <i class="fas fa-user-plus"></i> Novo Aluno
        </a>
    </div>
</div>

@endsection


@section('content')
<div class="students-container" style="flex: 1; margin-left: auto; margin-right: auto; height: 100vh; background: white; justify-content: flex-start; box-shadow: none; display: flex; flex-direction: column;">
    {{-- Listagem de alunos --}}
    <div class="students-list">
        @include('students.partials.list', ['students' => $students])
    </div>

    {{-- Paginação --}}
    <div class="pagination-container">
        @if ($students->lastPage() > 1)
            <ul class="pagination">
                @if ($students->currentPage() > 1)
                    <li class="nav-button">
                        <a href="{{ $students->previousPageUrl() }}">← Anterior</a>
                    </li>
                @endif

                @for ($i = 1; $i <= $students->lastPage(); $i++)
                    <li class="page-number {{ $students->currentPage() == $i ? 'active' : '' }}">
                        <a href="{{ $students->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                @if ($students->currentPage() < $students->lastPage())
                    <li class="nav-button">
                        <a href="{{ $students->nextPageUrl() }}">Próximo →</a>
                    </li>
                @endif
            </ul>
        @endif
    </div>
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/students-index.css') }}">
@endpush
@endsection
