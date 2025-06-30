<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Student;
use App\Http\Controllers\SistemaController;


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
            'type_category' => 'required|in:' . implode(',', $this->types_category),
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
            'types_category' => $this->types_category
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
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();
        
        $category = Category::findOrFail($id);

        // Busca todos os students associados à categoria via a tabela pivot
        $students = Student::whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->with('user')->get()->sortBy(function ($student) {
            return $student->user->name ?? '';
        })->values();

        return view('category.show', compact('category', 'breadcrumbs_list', 'students'));
    }

    public function addStudentIndex(Category $category)
    {
        $breadcrumbs_list = (new SistemaController())->getBreadcrumbs();

        // IDs dos alunos que JÁ ESTÃO na turma.
        $existingStudentIds = $category->students()->pluck('students.id')->all();

        $students = Student::with('user')
                        ->whereNotIn('id', $existingStudentIds)
                        ->get()
                        ->sortBy(fn($s) => $s->user->name)
                        ->values();

        return view('category.add_student', 
                    compact('breadcrumbs_list', 'students', 'category'));
    }

    public function addStudentStore(Request $request, Category $category)
    {
        $request->validate([
            'student_ids'   => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $category->students()
                ->syncWithoutDetaching($request->student_ids);

        return redirect()
            ->route('category.show', $category->id)
            ->with('success','Alunos adicionados com sucesso!');
    }

}