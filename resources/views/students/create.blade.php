@extends('layouts.layout-dois')

@section('bar')
    <div class="bar-title" style="font-size: 24px; font-weight: bold;">
        {{ isset($student) ? 'Editar Aluno' : 'Novo Aluno' }}
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-user-edit me-2"></i>
                Ficha Técnica
            </h4>
        </div>

        <div class="card-body p-4">
            <form 
                action="{{ isset($student) ? route('students.update', $student->id) : route('students.store') }}" 
                method="POST" 
                id="studentForm"
            >
                @csrf
                @if(isset($student))
                    @method('PUT')
                @endif
                <h5 class="mb-3 text-secondary">Dados Pessoais</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="user_name" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" value="{{ old('user_name', $student->user->name ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" value="{{ old('user_email', $student->user->email ?? '') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date_of_birth" class="form-label">Data de Nascimento</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', isset($student) ? $student->date_of_birth->format('Y-m-d') : '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nationality" class="form-label">Naturalidade</label>
                        <select class="form-select" name="nationality" id="nationality" required>
                            <option value="" selected disabled>Selecione...</option>
                            @foreach($countries as $nat)
                                <option value="{{ $nat }}" {{ old('nationality', $student->countries ?? '') == $nat ? 'selected' : '' }}>
                                    {{ $nat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="mb-3 text-secondary">Dados Físicos e Técnicos</h5>
                <div class="row">
                <div class="col-md-6 col-lg-3 mb-3">
                    <label for="position" class="form-label">Posição</label>
                    <select class="form-select" name="position" id="position-select" required>
                        <option value="" selected disabled>Selecione...</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos }}" {{ old('position', $student->position ?? '') == $pos ? 'selected' : '' }}>
                                {{ $pos }}
                            </option>
                        @endforeach
                    </select>
                </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="lateralidades" class="form-label">Lateralidade</label>
                        <select class="form-select" name="lateralidades" id="lateralidades" required>
                            <option value="" selected disabled>Selecione...</option>
                            @foreach($lateralidades as $lat)
                                <option value="{{ $lat }}" {{ old('lateralidades', $student->lateralidades ?? '') == $lat ? 'selected' : '' }}>
                                    {{ $lat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="height" class="form-label">Altura (m)</label>
                        <input type="number" step="0.01" class="form-control" id="height" name="height" value="{{ old('height', $student->height ?? '') }}">
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="weight" class="form-label">Peso (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{ old('weight', $student->weight ?? '') }}">
                    </div>
                </div>
                <hr class="my-4">
                <h5 class="mb-3 text-secondary">Informações Adicionais</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="medication" class="form-label">Usa medicação? Qual?</label>
                        <input type="text" class="form-control" id="medication" name="medication" value="{{ old('medication', $student->medication ?? '') }}" placeholder="Nenhuma ou descreva a medicação">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="date_end" class="form-label">Data de Fim(Opcional)</label>
                        <input type="date" class="form-control" id="date_end" name="date_end" value="{{ old('date_end', isset($student) && $student->date_end ? $student->date_end->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>
                        {{ isset($student) ? 'Atualizar Aluno' : 'Salvar Novo Aluno' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/student-form.css') }}">
@endpush

