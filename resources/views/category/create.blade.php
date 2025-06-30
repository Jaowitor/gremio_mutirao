@extends('layouts.layout-dois')
@section('bar')
<div class="title text-white text-center py-3" style="width: 20%; margin-left: 120px; font-size: 24px; background: linear-gradient(90deg, #007BFF, #2684e9); font-weight: bold; border-radius: 8px;">
    Criar Categoria
</div>
@endsection
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.type-category-btn');
        const hiddenInput = document.getElementById('selectedTypeCategory');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                // Remove 'active' de todos os botões
                buttons.forEach(btn => btn.classList.remove('active'));
                // Adiciona 'active' ao botão clicado
                this.classList.add('active');
                hiddenInput.value = this.dataset.type;
            });
        });
    });
</script>
@endpush
@push('styles')
<style>
    .type-category-btn.active {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
</style>    
@endpush
@endsection