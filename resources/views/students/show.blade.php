@extends('layouts.layout-dois')
@section('content')

<div class="container-show-student" style="border: 1px solid red; display:flex;">

    <div class="photo-student" style="flex:1; display: flex; align-items: flex-start; height: auto; border: 1px solid black; box-sizing: border-box;">
        {{-- <img src="https://randomuser.me/api/portraits/men/31.jpg" alt="Foto do Aluno" style="display: block; width: 80%; height: auto;"> --}}
    </div>

        <div class="info-student" style="flex:1; padding: 30px;">
            <h2>{{ $student->user->name ?? 'N/A' }}</h2>
            <p><strong>Idade:</strong> {{ $student_any ?? 'N/A' }}</p>
            <p><strong>Posição:</strong> {{ $student->position ?? 'N/A' }}</p>
            <p><strong>Lateralidade:</strong> {{ $student->laterality ?? 'N/A' }}</p>
            <p><strong>Altura:</strong> {{ $student->height ?? 'N/A' }}</p>
            <p><strong>Peso:</strong> {{ $student->weight ?? 'N/A' }}</p>
            <p><strong>Medicação:</strong> {{ $student->medication ?? 'N/A' }}</p>
            <p><strong>Observações:</strong> {{ $student->observations ?? 'N/A' }}</p>
        </div>
        <div class= "buttons-student-editar" style="align-self: flex-end; padding: 30px; height: auto;">
            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-warning">Editar</a>
        </div>
@endsection