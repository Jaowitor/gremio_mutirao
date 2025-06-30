@extends('layouts.layout-dois')


@section('bar')
<div class="title text-white text-start py-3" style=" font-size: 24px; font-weight: bold;">
    {{ $name_category }}
</div>
@endsection

@section('content')
<div class="container">
    <div class="container mt-4 mb-4">
        <h3 class="text-start" style="font-weight: bold">Treino</h3>
    </div>

    <div class="container-planejamento" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(10, 7, 192, 0.1);">
        <h6> Planejamento: {{ $training->planejamento }} </h6>
        <h6>{{ $dia_da_semana }} - {{ $date_training }} de {{ $month }} </h6>
    </div>
    @if($is_future_training)
        <div class="alert alert-info d-flex align-items-center mt-4" role="alert">
            <i class="bi bi-calendar-x-fill me-2"></i>
            <div>
                <strong>Este treino está agendado para o futuro.</strong> A frequência só poderá ser registrada na data do treino.
            </div>
        </div>
    @endif

    <form 
        id="frequenciaForm" 
        method="POST" 
        action="{{ route('frequency.storeBulk') }}"
        class="{{ $is_future_training ? 'frequency-disabled' : '' }}"
    >
        @csrf
        <input type="hidden" name="training_id" value="{{ $training->id }}">
        <input type="hidden" name="category_id" value="{{ $category_id }}">
        <input type="hidden" id="frequenciesInput" name="frequencies">

        <h5 class="mt-4">Lista de Estudantes para Frequência</h5>

        @if(!$is_future_training) 
            @if($all_frequencies_filled)
                <div class="alert alert-success d-flex align-items-center mt-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>
                        A frequência para este treino já foi preenchida.
                    </div>
                </div>
                <div class="alert alert-warning d-flex align-items-center mt-3" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Você pode enviar novamente a frequência, se necessário.
                </div>
            @else
                <div class="alert alert-warning d-flex align-items-center mt-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        A frequência deste treino ainda está pendente. Marque todos os alunos e clique em "Enviar Frequência".
                    </div>
                </div>
            @endif
        @endif


        <div id="students-list" class="mt-3">
            @foreach ($students_custom as $user)
                @php
                    $student_id = $user['student_id'];
                    $frequency_info = $frequencies_by_student[$student_id] ?? ['presence' => 'ausente', 'filled' => 'não'];
                    $presence = $frequency_info['presence'];
                @endphp

                <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2 shadow-sm bg-white student-row" data-student-id="{{ $student_id }}">
                    <div>
                        <strong>{{ $loop->iteration }}.</strong> {{ $user['name'] ?? 'Sem nome' }}
                    </div>
                    
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presence-{{ $student_id }}" id="presente-{{ $student_id }}" value="presente" data-student-id="{{ $student_id }}" {{ $presence === 'presente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="presente-{{ $student_id }}">Presente</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presence-{{ $student_id }}" id="ausente-{{ $student_id }}" value="ausente" data-student-id="{{ $student_id }}" {{ $presence === 'ausente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ausente-{{ $student_id }}">Ausente</label>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-4">Enviar Frequência</button>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/frequency/frequency.js') }}"></script>
@endpush

@push('styles')
<style>
    .frequency-disabled {
        opacity: 0.6;
        pointer-events: none;
        cursor: not-allowed;
    }
</style>
@endpush