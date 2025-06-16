<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\SistemaController;
use App\Models\CategoryStudent;

class CategoryController extends Controller
{
    //tipos de categoria 
    private array $types_category = ['10', '11', '12', '13', '14', '15', '16', '17', 'livre'];

    // Listar categorias
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(10);
        $breadcrumbs_list = (new SistemaController())->getBreadcrumbs();

        return view('category.index', compact('categories', 'breadcrumbs_list'));
    }

    // Criar nova categoria (exibir formulário)
    public function create()
    {
        $breadcrumbs_list = (new SistemaController())->getBreadcrumbs();
        
        // dd($this->types_category);

        return view('category.create', [
            'breadcrumbs_list' => $breadcrumbs_list,
            'types_category' => $this->types_category
        ]);
    }

    // Salvar categoria no banco
    public function store(Request $request)
    {
        $request->validate([
            'name_category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_category' => 'required|in:' . implode(',', $this->types_category), // Usa a propriedade
        ]);

        Category::create($request->all());

        return redirect()->route('category.index')->with('success', 'Categoria criada com sucesso!');
    }

    // Editar categoria (exibir formulário)
    public function edit(Category $category)
    {
        $breadcrumbs_list = (new SistemaController())->getBreadcrumbs();
        
        return view('category.create', [
            'category' => $category,
            'breadcrumbs_list' => $breadcrumbs_list,
            'types_category' => $this->types_category // Usa a propriedade global
        ]);
    }

    // Atualizar categoria no banco
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_category' => 'required|in:' . implode(',', $this->types_category), // Usa a propriedade
        ]);

        $category->update($request->all());

        return redirect()->route('category.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    // Deletar categoria
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Categoria excluída com sucesso!');
    }

    public function show($id) {
        $category = CategoryStudent::with('category')->findOrFail($id);
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();


        // return view('category.show', compact('student', 'breadcrumbs_list'));
    }
}