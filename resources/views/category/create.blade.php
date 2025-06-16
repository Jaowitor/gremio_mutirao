@extends('layouts.layout-dois')

@section('content')
<div class="container mt-4" style="width: 100%; height: 100; display: flex; align-items: center; justify-content: center;">
    <div class="card shadow-sm border-0" style="background-color: #f8f9fa; width: 100%; height: 100%; ">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">{{ isset($category) ? 'Editar Categoria' : 'Criar Categoria' }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}" method="POST">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="name_category" class="form-label">Nome da Categoria</label>
                    <input type="text" class="form-control" name="name_category" value="{{ $category->name_category ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control" name="description" rows="3">{{ $category->description ?? '' }}</textarea>
                </div>

            <div class="container-category" style="align-items: start;">
                <h3 class="text-center mb-4" style="font-weight: bold; font-size: 20px;">Selecione a faixa de idade</h3>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @foreach($types_category as $type)
                        <button type="button" class="btn btn-outline-primary px-3 py-2 type-category-btn"
                                data-type="{{ $type }}">
                            {{ $type }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" name="type_category" id="selectedTypeCategory">
            </div>

                <div class="text-end" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-success px-4"><i class="fas fa-save"></i> Salvar</button>
                    <a href="{{ route('category.index') }}" class="btn btn-secondary px-4"><i class="fas fa-arrow-left"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection