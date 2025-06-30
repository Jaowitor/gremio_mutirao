<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Training;
use App\Http\Controllers\SistemaController;
use App\Models\TrainingFrequecy;
use App\Models\CategoryStudent;
use App\Models\Category;
use App\Models\Student;
use App\Models\User;


class TrainingController extends Controller
{

public function index() {
    $trainings = Training::orderBy('created_at', 'desc')->paginate(10);

    Carbon::setLocale('pt_BR');

    $trainings->getCollection()->transform(function ($training) {
        $carbonDate = Carbon::createFromFormat('d/m/Y H:i:s', $training->date_training);
        $training->dia_da_semana = $carbonDate->translatedFormat('l');
        $training->dia_do_mes = $carbonDate->translatedFormat('d');
        $training->mes_em_portugues = $carbonDate->translatedFormat('F');
        $training->time_training = $carbonDate->format('H:i');
        return $training;
    });

    $breadcrumbsController = new SistemaController();
    $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

    return view('training.index', compact('trainings', 'breadcrumbs_list'));
}


    public function create()
    {
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

        // Buscar os IDs das categorias existentes em CategoryStudent
        $categoryIds = CategoryStudent::distinct()->pluck('category_id');

        // Buscar só as categorias usadas
        $categories = Category::whereIn('id', $categoryIds)->get();

        //buscar todas as categorias
        $categoriesAll = Category::all()->toArray();
        // dd($categoriesAll);

        return view('training.create', compact('breadcrumbs_list', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'planejamento' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
            'time' => 'required|date_format:H:i',
            'category_id' => 'required|exists:categories,id',
        ]);

        DB::beginTransaction();

        try {
            $formattedDate = Carbon::createFromFormat('d/m/Y H:i', $request->date . ' ' . $request->time)->format('Y-m-d H:i:s');
            // Criar o treino
            $training = Training::create([
                'planejamento' => $request->planejamento,
                'date_training' => $formattedDate,
            ]);

            // Buscar todos os CategoryStudent dessa categoria
            $categoryStudents = CategoryStudent::where('category_id', $request->category_id)->get();

            // Criar TrainingFrequecy para cada CategoryStudent relacionado à categoria
            foreach ($categoryStudents as $cs) {
                TrainingFrequecy::create([
                    'training_id' => $training->id,
                    'categorystudent_id' => $cs->id,
                    'presence' => 'ausente',
                    'filled' => 'não',
                ]);
            }

            DB::commit();

            return redirect()->route('training.index')->with('success', 'Treinamento criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao cadastrar o treinamento: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

        $training = Training::findOrFail($id);

        // Busca as frequências do treino (TrainingFrequecy)
        $training_freq = TrainingFrequecy::where('training_id', $id)->get();

        // Busca o primeiro
        $firstFrequency = $training_freq->first();

        $category_id = null;

        if ($firstFrequency) {
            $categoryStudent = CategoryStudent::find($firstFrequency->categorystudent_id);
            if ($categoryStudent) {
                $category_id = $categoryStudent->category_id;
            }
        }

        // Buscar categorias ativas
        $categoryIds = CategoryStudent::distinct()->pluck('category_id');
        $categories = Category::whereIn('id', $categoryIds)->get();

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $training->getRawOriginal('date_training'))->format('d/m/Y');
        $time = Carbon::createFromFormat('Y-m-d H:i:s', $training->getRawOriginal('date_training'))->format('H:i');

        return view('training.create', compact('breadcrumbs_list', 'categories', 'training', 'category_id', 'date', 'time'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'planejamento' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
            'time' => 'required|date_format:H:i',
            'category_id' => 'required|exists:categories,id',
        ]);

        DB::beginTransaction();

        try {
            $formattedDate = Carbon::createFromFormat('d/m/Y H:i', $request->date . ' ' . $request->time)->format('Y-m-d H:i:s');

            $training = Training::findOrFail($id);
            $training->update([
                'planejamento' => $request->planejamento,
                'date_training' => $formattedDate,
            ]);

            // Deleta todas as frequências existentes para este treino
            TrainingFrequecy::where('training_id', $training->id)->delete();

            // Recria TrainingFrequecy para cada CategoryStudent relacionado à categoria
            $categoryStudents = CategoryStudent::where('category_id', $request->category_id)->get();
            foreach ($categoryStudents as $cs) {
                TrainingFrequecy::create([
                    'training_id' => $training->id,
                    'categorystudent_id' => $cs->id,
                    'presence' => 'ausente',
                    'filled' => 'não',
                ]);
            }

            DB::commit();

            return redirect()->route('training.index')->with('success', 'Treinamento atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao atualizar o treinamento: ' . $e->getMessage());
        }
    }


public function showCategory($id)
{
    // Define o local para português do Brasil para formatar datas
    Carbon::setLocale('pt_BR');
    
    // Carrega o treino específico que o usuário acessou
    $training = Training::findOrFail($id);
    
    $carbonTrainingDate = Carbon::createFromFormat('d/m/Y H:i:s', $training->date_training);

    $today = Carbon::now()->startOfDay();
    $is_future_training = $carbonTrainingDate->copy()->startOfDay()->isAfter($today);
    
    $date_training = $carbonTrainingDate->format('d');
    $time_training = $carbonTrainingDate->format('H:i');
    $dia_da_semana = $carbonTrainingDate->translatedFormat('l');
    $month = $carbonTrainingDate->translatedFormat('F');

    $breadcrumbsController = new SistemaController();
    $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

    $training_freq = TrainingFrequecy::where('training_id', $id)
        ->with('categoryStudent')
        ->get();

    $frequencies_by_student = [];
    foreach ($training_freq as $freq) {
        if ($freq->categoryStudent) {
            $student_id = $freq->categoryStudent->student_id;
            $frequencies_by_student[$student_id] = [
                'presence' => $freq->presence,
                'filled' => $freq->filled,
            ];
        }
    }

    $firstFrequency = $training_freq->first();
    $category_id = null;
    if ($firstFrequency && $firstFrequency->categoryStudent) {
        $category_id = $firstFrequency->categoryStudent->category_id;
    }

    if (!$category_id) {
        return redirect()->back()->with('error', 'Não foi possível encontrar a turma para este treino.');
    }

    $category = Category::findOrFail($category_id);
    $name_category = $category->name_category;

    $studentsCategory = CategoryStudent::where('category_id', $category_id)->get()->toArray();
    $students_list_ids = array_column($studentsCategory, 'student_id');
    $students = Student::whereIn('id', $students_list_ids)->with('user')->get()->toArray();
    $user_ids = array_column($students, 'user_id');
    $students_users = User::whereIn('id', $user_ids)->get()->toArray();

    $studentIdByUserId = [];
    foreach ($students as $student) {
        $studentIdByUserId[$student['user_id']] = $student['id'];
    }

    $students_custom = [];
    foreach ($students_users as $user) {
        $user['student_id'] = $studentIdByUserId[$user['id']] ?? null;
        $students_custom[] = $user;
    }
    usort($students_custom, fn($a, $b) => strcmp($a['name'], $b['name']));

    $total_students = count($students_custom);
    $filled_count = 0;
    foreach ($frequencies_by_student as $freq) {
        if ($freq['filled'] === 'sim') {
            $filled_count++;
        }
    }

    $all_frequencies_filled = ($total_students > 0 && $filled_count === $total_students);

    return view('training.category', compact(
        'breadcrumbs_list',
        'training',
        'frequencies_by_student',
        'category_id',
        'name_category',
        'date_training',
        'time_training',
        'dia_da_semana',
        'month',
        'students_custom',
        'all_frequencies_filled',
        'is_future_training'
    ));
}
    public function destroy($id)
    {
        Training::findOrFail($id)->delete();
        return redirect()->route('training.index')->with('success', 'Treinamento excluído com sucesso!');
    }
}
