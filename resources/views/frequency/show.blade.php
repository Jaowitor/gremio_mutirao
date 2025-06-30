@extends('layouts.layout-dois')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Histórico de Frequências - {{ $category->name_category }}</h2>
        <a href="{{ route('frequency.index', $category->id) }}" class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Voltar para Marcar Frequência
        </a>
    </div>

    @if (empty($trainingsWithFrequencies))
        <div class="alert alert-info">
            Nenhum registro de frequência encontrado para esta categoria.
        </div>
    @else
    
        @foreach ($trainingsWithFrequencies as $trainingData)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Treino em: {{ $trainingData['date_training'] }}</h5>
                    <small>Planejamento: {{ $trainingData['planejamento'] }}</small>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Estudante</th>
                                <th scope="col">Presença</th>
                                <th scope="col">Preenchido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainingData['frequencies'] as $index => $frequency)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $frequency['student_name'] }}</td>
                                    <td>
                                        <span class="badge {{ $frequency['presence'] === 'presente' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($frequency['presence']) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $frequency['filled'] === 'sim' ? 'bg-info' : 'bg-secondary' }}">
                                            {{ ucfirst($frequency['filled']) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
@endsection
