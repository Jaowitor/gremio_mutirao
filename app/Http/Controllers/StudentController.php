<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\SistemaController;


class StudentController extends Controller 
{

    public function index(Request $request) 
    {
        
        $query = Student::query()->orderBy('created_at', 'desc');
        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%');
            });
        }

        $students = $query->with('user')->paginate(5)->withQueryString();
        $totalJogadores = Student::count(); 

        // if ($request->ajax()) {
        //     return response()->json([
        //         'data' => $students->items(),
        //         'pagination' => [
        //             'current_page' => $students->currentPage(),
        //             'last_page' => $students->lastPage(),
        //             'per_page' => $students->perPage(),
        //             'total' => $students->total(),
        //         ],
        //         'totalJogadores' => $totalJogadores
        //     ]);
        // }

        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

        
        return view('students.index', compact('students', 'totalJogadores', 'breadcrumbs_list'));
    }

    public function create()
    {
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

        $countries = ['Brasil', 'Argentina', 'Uruguai', 'Portugal', 'Espanha', 'França', 'Alemanha', 'Itália', 'Inglaterra', 'Japão'];
        $positions = ['Goleiro', 'Lateral Direito', 'Zagueiro', 'Lateral Esquerdo', 'Volante', 'Meia', 'Meia Ofensivo', 'Ponta Direita', 'Ponta Esquerda', 'Atacante'];
        $lateralidades =['Destro', 'Canhoto', 'Ambidestro'];
        return view('students.create', compact('breadcrumbs_list', 'countries', 'positions', 'lateralidades'));
    }


    // Salva o User e o Student juntos, de forma atômica
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'nationality' => 'required|string',
            'position' => 'nullable|string',
            'laterality' => 'required|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'medication' => 'nullable|string',
            'date_end' => 'nullable|date|after_or_equal:date_init',
            'date_of_birth' => 'required|date|before:today',
        ], [
            'user_email.unique' => 'Este e-mail já está em uso.',
            'date_end.after_or_equal' => 'A data final deve ser igual ou posterior à inicial.',
            'date_of_birth.before' => 'A data de nascimento deve ser anterior a hoje.',
        ]);

        DB::beginTransaction();

        try {
            // Cria o usuário
            $user = User::create([
                'name' => $request->user_name,
                'email' => $request->user_email,
                'password' => bcrypt('root123'),
            ]);

            // Cria o aluno
            Student::create([
                'user_id' => $user->id,
                'nationality' => $request->nationality,
                'position' => $request->position,
                'laterality' => $request->laterality,
                'height' => $request->height,
                'weight' => $request->weight,
                'medication' => $request->medication,
                'date_init' => now()->toDateString(),
                'date_end' => $request->date_end,
                'date_of_birth' => $request->date_of_birth,
                'active' => true,
            ]);

            DB::commit();
            // dd($user);
            return redirect()->route('students.index')->with('success', 'Aluno e usuário criados com sucesso!');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao criar aluno e usuário: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id) {
        $student = Student::with('user')->findOrFail($id);
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();
        
        // lista do menu suspenso
        $countries = ['Brasil', 'Argentina', 'Uruguai', 'Portugal', 'Espanha', 'França', 'Alemanha', 'Itália', 'Inglaterra', 'Japão'];
        $positions = ['Goleiro', 'Lateral Direito', 'Zagueiro', 'Lateral Esquerdo', 'Volante', 'Meia', 'Meia Ofensivo', 'Ponta Direita', 'Ponta Esquerda', 'Atacante'];
        $lateralidades =['Destro', 'Canhoto', 'Ambidestro'];

        return view('students.create', compact('student', 'breadcrumbs_list', 'countries', 'positions', 'lateralidades'));
    }

    
    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);
        $user = $student->user;
        // dd($request);
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email,' . $user->id,
            'nationality' => 'required|string',
            'position' => 'nullable|string',
            'laterality' => 'required|string',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'medication' => 'nullable|string',
            'date_end' => 'nullable|date|after_or_equal:date_init',
            'date_of_birth' => 'required|date|before:today',
        ]);

        DB::beginTransaction();
        try {

            // Obtém o estudante e o usuário associado
            $student = Student::findOrFail($id);
            $user = $student->user;

            // Atualiza dados do usuário
            $user->update([
                'name' => $request->user_name,
                'email' => $request->user_email,
            ]);

            // Atualiza dados do estudante
            $student->update([
                'nationality' => $request->nationality,
                'position' => $request->position,
                'laterality' => $request->laterality,
                'height' => $request->height,
                'weight' => $request->weight,
                'medication' => $request->medication,
                'date_end' => $request->date_end,
                'date_of_birth' => $request->date_of_birth,
            ]);

            DB::commit();
            return redirect()->route('students.index')->with('success', 'Aluno atualizado com sucesso!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao atualizar aluno: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id) {

        $student = Student::with('user')->findOrFail($id);
        $student_any = $student->date_of_birth->age ;
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();
        return view('students.show', compact('student', 'breadcrumbs_list', 'student_any'));
    }
}
