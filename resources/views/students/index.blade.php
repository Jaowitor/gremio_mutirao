@extends('layouts.layout-dois')
@section('bar')
<div class="title" style="font-size: 20px; background: linear-gradient(90deg, #007BFF, #00BFFF); color: #fff; font-weight: bold; padding: 8px 10px 10px 30px; border-radius: 8px; box-shadow: 2px 2px 8px rgba(0,0,0,0.1); 
margin-left: 70px;">Alunos</div>
    <div class="search-container">
        <div class="search-wrapper">
            <form method="GET" class="search-form" data-search-url="{{ route('students.index') }}">
                <input type="text" name="q" id="search-input" placeholder="Pesquisar aluno..." value="{{ request('q') }}">
                <i class="material-icons search-icon">search</i>
            </form>
        </div>

        <a href="{{ route('students.create') }}" class="btn btn-success" >
            <i class="fas fa-user-plus" style="margin-right: 8px; font-size: 16px;"></i> Novo Aluno
        </a>
    </div>
@endsection


@section('content')
<div class="students-container">
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
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
