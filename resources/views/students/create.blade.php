@extends('layouts.layout-dois')
@section('content')

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(old('date_of_birth'))
    <p>data digitada: {{ old('date_of_birth') }}</p>
@endif


<div class="form-container-student">
    <form 
        action="{{ isset($student) ? route('students.update', $student->id) : route('students.store') }}" 
        method="POST" 
        id="studentForm"
    >
        @csrf
        @if(isset($student))
            @method('PUT')
        @endif

        <div class="form-header">
            <h4>Ficha Técnica</h4>
            <div class="form-buttons">
                <button type="submit" class="btn-submit">Salvar</button>
            </div>
        </div>

        <div class="form-group-student">
            <label for="user_name">Nome</label>
            <input 
                type="text" 
                id="user_name" 
                name="user_name" 
                value="{{ old('user_name', isset($student) ? $student->user->name : '') }}" 
                required
            >
        </div>

        <div class="form-group-student">
            <label for="user_email">Email</label>
            <input 
                type="email" 
                id="user_email" 
                name="user_email" 
                value="{{ old('user_email', isset($student) ? $student->user->email : '') }}" 
                required
            >
        </div>

        <div class="form-row">
            <div class="form-group-student">
                <label for="nationality">Naturalidade</label>
                <select name="nationality" id="nationality" required>
                    <option value="">Selecione</option>
                    @foreach($countries as $nat)
                        <option value="{{ $nat }}" {{ old('nationality', isset($student) ? $student->countries : '') == $nat ? 'selected' : '' }}>
                            {{ $nat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-student">
                <label for="position">Posição</label>
                <select name="position" id="position" required>
                    <option value="">Selecione</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos }}" {{ old('position', isset($student) ? $student->position : '') == $pos ? 'selected' : '' }}>
                            {{ $pos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-student">
                <label for="height">Altura (m)</label>
                <input 
                    type="number" 
                    step="0.01" 
                    id="height" 
                    name="height" 
                    value="{{ old('height', isset($student) ? $student->height : '') }}"
                >
            </div>

            <div class="form-group-student">
                <label for="weight">Peso (kg)</label>
                <input 
                    type="number" 
                    step="0.01" 
                    id="weight" 
                    name="weight" 
                    value="{{ old('weight', isset($student) ? $student->weight : '') }}"
                >
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-student">
                <label for="lateralidades">Lateralidade</label>
                <select name="lateralidades" id="lateralidades" required>
                    <option value="">Selecione</option>
                    @foreach($lateralidades as $lat)    
                        <option value="{{ $lat }}" {{ old('lateralidades', isset($student) ? $student->lateralidades : '') == $lat ? 'selected' : '' }}>
                            {{ $lat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-student">
                <label for="date_of_birth">Data de Nascimento</label>
                <input 
                    type="date" 
                    id="date_of_birth" 
                    name="date_of_birth" 
                    value="{{ old('date_of_birth', isset($student) ? $student->date_of_birth->format('d-m-Y') : '') }}"
                    aria-errormessage="date_of_birth-error"
                    title="Data de Nascimento"
                    language="pt-BR"
                    required
                >
            </div>
            <div class="form-group-student">
                <label for="date_end">Data de Fim</label>
                <input 
                    type="date" 
                    id="date_end" 
                    name="date_end" 
                    value="{{ old('date_end', isset($student) && $student->date_end ? $student->date_end->format('d-m-Y') : '') }}"
                >
            </div>
        </div>

        <div class="form-group-student">
            <label for="medication">Medicação</label>
            <input 
                type="text" 
                id="medication" 
                name="medication" 
                value="{{ old('medication', isset($student) ? $student->medication : '') }}"
            >
        </div>

    </form>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/student-form.css') }}">
@endpush
@endsection
