@extends('layouts.layout-dois')

@section('bar')
<div class="title text-white text-center py-3" style="font-size: 24px; background: linear-gradient(90deg, #007BFF, #00BFFF); font-weight: bold; border-radius: 8px; box-shadow: 2px 2px 8px rgba(0,0,0,0.1);">
    Categorias
</div>

<div class="container mt-3">
    <div class="d-flex justify-content-between">
        <div>
            <input type="text" class="form-control" placeholder="Pesquisar categoria..." id="search">
        </div>
        <a href="{{ route('category.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Nova Categoria
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        @foreach($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">{{ $category->name_category }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">{{ $category->description }}</p>
                        <p><strong>Idade:</strong> {{ $category->type_category }}</p>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-3 d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
</div>
{{-- <script>
    document.querySelectorAll('.type-category-btn').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.type-category-btn').forEach(btn => btn.classList.remove('active', 'btn-primary'));
            this.classList.add('active', 'btn-primary');
            document.getElementById('selectedTypeCategory').value = this.getAttribute('data-type');
        });
    });
</script> --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/category/category-index.css') }}">
@endpush
@endsection


