@extends('layouts.layout-dois')

@section('bar')
<div class="title text-white text-center py-3" style=" font-size: 24px; font-weight: bold;">
    Agendar treino
</div>
@endsection

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="form-container-training" style="width: 100%; height: 100%; padding: 20px;">
    <form id="training-form"
        action="{{ isset($training) ? route('training.update', $training->id) : route('training.store') }}"
        method="POST">
        @csrf
        @if(isset($training))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="planejamento" class="form-label">Planejamento</label>
            <textarea class="form-control" id="planejamento" name="planejamento" rows="4" required>{{ old('planejamento', $training->planejamento ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoria</label>
            <select style="height: 50px" class="form-control" id="category_id" name="category_id" required>
                <option value="" disabled {{ !isset($training) ? 'selected' : '' }}>Selecione a categoria</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (isset($training) && $category_id == $category->id) ? 'selected' : '' }}>
                        {{ $category->name_category }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">Data do Treinamento</label>
                <div class="input-group">
                    <input style="height: 50px"
                        type="text"
                        class="form-control datepicker"
                        id="date"
                        name="date"
                        value="{{ old('date', $date ?? '') }}"
                        placeholder="dd/mm/yyyy"
                        required>
                    <button class="btn btn-outline-secondary" type="button" id="date-icon"><i class="fa fa-calendar"></i></button>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="time" class="form-label">Horário</label>
                <div class="input-group">
                    <input style="height: 50px"
                        type="text"
                        class="form-control timepicker"
                        id="time"
                        name="time"
                        value="{{ old('time', $time ?? '') }}"
                        placeholder="hh:mm"
                        required>
                    <button class="btn btn-outline-secondary" type="button" id="time-icon"><i class="fa fa-clock"></i></button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-bottom: 10px; max-width: 200px; margin-left: 12px;">
            {{ isset($training) ? 'Atualizar' : 'Cadastrar' }}
        </button>
    </form>

</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/training/training-form.css') }}">
@endpush

@endsection