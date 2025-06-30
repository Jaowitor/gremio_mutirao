@extends('layouts.layout-dois')

@section('content')
    <form id="frequenciaForm" method="POST" action="{{ route('frequency.storeBulk') }}">
    @csrf
    @if ($latestTraining)
        <input type="hidden" name="training_id" value="{{ $latestTraining->id }}">
        <input type="hidden" name="category_id" value="{{ $category->id }}">
        <input type="hidden" id="frequenciesInput" name="frequencies">
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $category->name_category }} — Frequência</h2>
        <div class="d-flex">
            <button class="btn btn-outline-warning btn-sm me-2" type="button" data-bs-toggle="collapse" data-bs-target="#treinosPendentesCollapse" aria-expanded="false" aria-controls="treinosPendentesCollapse">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Frequências Pendentes
                @if($pendingTrainings->count() > 0)
                    <span class="badge bg-danger ms-1">{{ $pendingTrainings->count() }}</span>
                @endif
            </button>
            <a href="{{ route('frequency.show', $category->id) }}" class="btn btn-info btn-sm">
                <i class="bi bi-calendar-check me-1"></i> Histórico de Frequências
            </a>
        </div>
    </div>

    <div class="collapse mt-3" id="treinosPendentesCollapse">
        <div class="card card-body">
            @if($pendingTrainings->isEmpty())
                <div class="alert alert-success mb-0">
                    <i class="bi bi-check-circle-fill me-2"></i> Parabéns! Não há frequências pendentes para treinos passados nesta categoria.
                </div>
            @else
                <h5>Treinos com Frequências Pendentes:</h5>
                <ul class="list-group list-group-flush">
                    @foreach($pendingTrainings as $pendingTraining)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Treino em: <strong>
                                @php
                                    $formattedDate = 'N/A';
                                    if ($pendingTraining->date_training) {
                                        if ($pendingTraining->date_training instanceof \Carbon\Carbon) {
                                            $formattedDate = $pendingTraining->date_training->format('d/m/Y H:i');
                                        } else {
                                            try {
                                                $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $pendingTraining->date_training)->format('d/m/Y H:i');
                                            } catch (\Exception $e) {
                                                $formattedDate = 'Data Inválida';
                                            }
                                        }
                                    }
                                    echo $formattedDate;
                                @endphp
                            </strong> ({{ $pendingTraining->planejamento }})</span>

                            <a href="{{ route('frequency.editPending', ['category' => $category->id, 'training' => $pendingTraining->id]) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square me-1"></i> Preencher
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    @if ($latestTraining)
        <h5 class="mt-5">Lista de Estudantes para o Treino de
            @php
                $formattedLatestDate = 'N/A';
                if ($latestTraining->date_training) {
                    if ($latestTraining->date_training instanceof \Carbon\Carbon) {
                        $formattedLatestDate = $latestTraining->date_training->format('d/m/Y H:i');
                    } else {
                        try {
                            $formattedLatestDate = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $latestTraining->date_training)->format('d/m/Y H:i');
                        } catch (\Exception $e) {
                            $formattedLatestDate = 'Data Inválida';
                        }
                    }
                }
                echo $formattedLatestDate;
            @endphp
        </h5>
        <div id="students-list">
            @foreach ($students as $student)
                @php
                    $presence = $currentFrequencies[$student->id]['presence'] ?? 'ausente';
                    $filled = $currentFrequencies[$student->id]['filled'] ?? 'não';
                    $isFilled = ($filled === 'sim');
                @endphp
                <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2 shadow-sm bg-white student-row" data-student-id="{{ $student->id }}">
                    <div>
                        <strong>{{ $loop->iteration }}.</strong> {{ $student->user->name ?? 'Sem nome' }}
                        @if($isFilled)
                            <span class="badge bg-success ms-2">Frequência Preenchida</span>
                        @else
                            <span class="badge bg-warning ms-2">Aguardando Preenchimento</span>
                        @endif
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presence-{{ $student->id }}" id="presente-{{ $student->id }}" value="presente" data-student-id="{{ $student->id }}" {{ $presence === 'presente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="presente-{{ $student->id }}">Presente</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="presence-{{ $student->id }}" id="ausente-{{ $student->id }}" value="ausente" data-student-id="{{ $student->id }}" {{ $presence === 'ausente' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ausente-{{ $student->id }}">Ausente</label>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-4">Enviar Frequência</button>
    @else
        <div class="alert alert-info mt-5">
            Não há um treino recente com frequências associadas a esta turma para marcar.
            Certifique-se de que a turma possui alunos e que um treino foi criado e associado a esta turma.
        </div>
    @endif
</form>

@push('scripts')
    <script src="{{ asset('js/frequency/frequency.js') }}"></script>
@endpush
@endsection