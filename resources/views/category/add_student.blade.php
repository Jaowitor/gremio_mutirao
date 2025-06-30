@extends('layouts.layout-dois')

@section('bar')
    <div class="bar-title" style="font-size: 24px;">
        <strong>Adicionar Alunos</strong>
    </div>
@endsection

@section('content')
<div style="padding: 15px;">
    <h3 class="mb-4" style="font-weight: bold; font-size: 20px;">
        Alunos disponíveis para adicionar
        <i class="fas fa-user-plus"></i>
    </h3>

    @if ($students->isNotEmpty())

        <form method="POST"
                action="{{ route('category.add_student_store', $category->id) }}"
                style="width: 100%; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; background-color: #fff;">
            @csrf
            
            <div class="d-flex justify-content-end mb-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Adicionar Selecionados
                </button>
            </div>

            <input type="hidden" name="category_id" value="{{ $category->id }}">

            <div class="list-group">
                @foreach ($students as $student)
                    <label class="list-group-item d-flex align-items-center">
                        <input class="form-check-input me-3"
                                style="width: 1.5em; height: 1.5em;"
                                type="checkbox"
                                name="student_ids[]"
                                value="{{ $student->id }}"
                                id="student-{{ $student->id }}">
                        {{ $student->user->name ?? 'Sem nome' }}
                    </label>
                @endforeach
            </div>
        </form>

    @else

        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading"><i class="fas fa-info-circle"></i> Tudo certo por aqui!</h4>
            <p>Parece que todos os alunos do sistema já foram adicionados a esta turma.</p>
            <hr>
            <p class="mb-0">Não há novos alunos disponíveis para adicionar no momento.</p>
        </div>
        
        <a href="{{ route('category.show', $category->id) }}" class="btn btn-primary mt-3">
            <i class="fas fa-arrow-left"></i> Voltar para a Turma
        </a>

    @endif

</div>
@endsection