<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Http\Controllers\SistemaController;
use App\Models\Category;
use App\Models\Student;
use App\Models\CategoryStudent;
use App\Models\Training;
use App\Models\TrainingFrequecy;


class FrequencyController extends Controller
{
    /**
     * Exibe o formulário para marcar a frequência de uma categoria.
     */
    public function index(Category $category)
    {
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

        // Carrega os estudantes que pertencem à categoria
        $students = Student::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->with('user')->get()->sortBy(fn($s) => $s->user->name ?? '')->values();

        $latestTraining = null;
        $currentFrequencies = [];
        $pendingTrainings = collect();

        // Pega todos os IDs de CategoryStudent para a categoria atual
        $categoryStudentIds = CategoryStudent::where('category_id', $category->id)->pluck('id')->toArray();

        // Só tenta buscar treinos se existirem CategoryStudentIds para esta categoria
        if (!empty($categoryStudentIds)) {
            $trainingIdsInFrequency = TrainingFrequecy::whereIn('categorystudent_id', $categoryStudentIds)->pluck('training_id')->unique()->toArray();

            if (!empty($trainingIdsInFrequency)) {
                // encontrar o treino com a data mais próxima de hoje
                $today = Carbon::today();
                $allRelevantTrainings = Training::whereIn('id', $trainingIdsInFrequency)->get();

                $closestTraining = null;
                $minDiff = PHP_INT_MAX;

                foreach ($allRelevantTrainings as $training) {

                    if ($training->date_training instanceof Carbon) {
                        $trainingDate = $training->date_training; 
                    } else {
                        try {

                            $trainingDate = Carbon::parse($training->date_training); 
                        } catch (\Exception $e) {
                            Log::warning("Erro ao parsear data '{$training->date_training}' para o treino ID {$training->id}: " . $e->getMessage());
                            continue;
                        }
                    }
                    
                    $diff = abs($today->diffInDays($trainingDate));

                    if ($diff < $minDiff) {
                        $minDiff = $diff;
                        $closestTraining = $training;
                    } elseif ($diff === $minDiff) {
                        // Se houver empate na diferença, priorize a data mais recente
                        if ($closestTraining === null || $trainingDate->greaterThan($closestTraining->date_training)) {
                            $closestTraining = $training;
                        }
                    }
                }
                $latestTraining = $closestTraining;

                // Pega todos os treinos passados (anteriores a hoje)
                $pastTrainings = Training::whereIn('id', $trainingIdsInFrequency)
                    ->whereDate('date_training', '<', $today)
                    ->get();

                foreach ($pastTrainings as $pastTraining) {
                    // Verifica se existe pelo menos uma frequência 'não' preenchida para este treino
                    $notFilledCount = TrainingFrequecy::where('training_id', $pastTraining->id)
                        ->whereIn('categorystudent_id', $categoryStudentIds)
                        ->where('filled', 'não')
                        ->count();

                    if ($notFilledCount > 0) {
                        // Se houver pelo menos um registro 'não' preenchido, adiciona o treino à lista de pendentes
                        $pendingTrainings->push($pastTraining);
                    }
                }
            }
        }

        // Se encontrou um treino recente (ou o mais próximo), busca o status de presença e preenchimento para cada estudante
        if ($latestTraining) {
            $frequenciesData = TrainingFrequecy::where('training_id', $latestTraining->id)
                ->whereIn('categorystudent_id', $categoryStudentIds)
                ->with('categoryStudent') 
                ->get()
                ->keyBy(function($item) {
                    return $item->categoryStudent->student_id;
                });

            foreach ($students as $student) {
                if ($frequenciesData->has($student->id)) {
                    $freq = $frequenciesData[$student->id];
                    $currentFrequencies[$student->id] = [
                        'presence' => $freq->presence,
                        'filled' => $freq->filled,
                    ];
                } else {
                    // Define valores padrão se não houver um registro de frequência existente
                    $currentFrequencies[$student->id] = [
                        'presence' => 'ausente',
                        'filled' => 'não',
                    ];
                }
            }
        }

        return view('frequency.index', compact('category', 'students', 'breadcrumbs_list', 'latestTraining', 'currentFrequencies', 'pendingTrainings'));
    }

    /**
     * Atualiza a presença dos estudantes para um treino específico em massa.
     */
    public function storeBulk(Request $request)
    {
        $request->validate([
            'training_id' => 'required|exists:trainings,id',
            'category_id' => 'required|exists:categories,id',
            'frequencies' => 'required|json',
        ]);

        $trainingId = $request->input('training_id');
        $categoryId = $request->input('category_id');
        $frequenciesData = json_decode($request->input('frequencies'), true);

        DB::beginTransaction();

        try {
            foreach ($frequenciesData as $data) {
                $studentId = $data['student_id'];
                $presence = $data['presence'];

                $categoryStudent = CategoryStudent::where('student_id', $studentId)
                                                    ->where('category_id', $categoryId)
                                                    ->first();

                if (!$categoryStudent) {
                    Log::warning("CategoryStudent não encontrado para student_id: {$studentId} e category_id: {$categoryId}.");
                    continue;
                }

                $categorystudentId = $categoryStudent->id;

                $trainingFrequency = TrainingFrequecy::where('training_id', $trainingId)
                                                    ->where('categorystudent_id', $categorystudentId)
                                                    ->first();

                if ($trainingFrequency) {
                    $trainingFrequency->presence = $presence;
                    $trainingFrequency->filled = 'sim';
                    $trainingFrequency->save();
                } else {
                    TrainingFrequecy::create([
                        'training_id' => $trainingId,
                        'categorystudent_id' => $categorystudentId,
                        'presence' => $presence,
                        'filled' => 'sim',
                    ]);
                    Log::info("Registro TrainingFrequecy criado para training_id: {$trainingId} e categorystudent_id: {$categorystudentId}.");
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Frequências atualizadas com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erro ao atualizar frequências: " . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar as frequências. Por favor, tente novamente.');
        }
    }

    /**
     * Exibe o histórico de frequências para uma categoria.
     */
    public function showFrequencies(Category $category)
    {
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

        $categoryStudentIds = CategoryStudent::where('category_id', $category->id)->pluck('id');

        $allFrequencies = TrainingFrequecy::whereIn('categorystudent_id', $categoryStudentIds)
            ->with(['training', 'categoryStudent.student.user'])
            ->orderBy('training_id', 'desc')
            ->get();

        $groupedFrequencies = $allFrequencies->groupBy('training_id');

        $trainingsWithFrequencies = [];
        foreach ($groupedFrequencies as $trainingId => $frequenciesCollection) {
            $training = $frequenciesCollection->first()->training;

            $dateTrainingFormatted = $training->date_training instanceof Carbon 
                                    ? $training->date_training->format('d/m/Y H:i') 
                                    : ($training->date_training ? Carbon::createFromFormat('d/m/Y H:i:s', $training->date_training)->format('d/m/Y H:i') : 'N/A');

            $trainingsWithFrequencies[] = [
                'id' => $training->id,
                'date_training' => $dateTrainingFormatted,
                'planejamento' => $training->planejamento,
                'frequencies' => $frequenciesCollection->map(function($freq) {
                    return [
                        'student_name' => $freq->categoryStudent->student->user->name ?? 'N/A',
                        'presence' => $freq->presence,
                        'filled' => $freq->filled,
                    ];
                })->toArray(),
            ];
        }

        return view('frequency.show', compact('category', 'trainingsWithFrequencies', 'breadcrumbs_list'));
    }

    public function editPendingFrequency(Category $category, Training $training)
    {
        $breadcrumbsController = new SistemaController();
        $breadcrumbs_list = $breadcrumbsController->getBreadcrumbs();

        $students = Student::whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->with('user')->get()->sortBy(fn($s) => $s->user->name ?? '')->values();

        $currentFrequencies = [];

        $categoryStudentIds = CategoryStudent::where('category_id', $category->id)->pluck('id')->toArray();

        if ($training && !empty($categoryStudentIds)) {
            $frequenciesData = TrainingFrequecy::where('training_id', $training->id)
                ->whereIn('categorystudent_id', $categoryStudentIds)
                ->with('categoryStudent')
                ->get()
                ->keyBy(function ($item) {
                    return $item->categoryStudent->student_id;
                });

            foreach ($students as $student) {
                if ($frequenciesData->has($student->id)) {
                    $freq = $frequenciesData[$student->id];
                    $currentFrequencies[$student->id] = [
                        'presence' => $freq->presence,
                        'filled' => $freq->filled,
                    ];
                } else {
                    $currentFrequencies[$student->id] = [
                        'presence' => 'ausente',
                        'filled' => 'não',
                    ];
                }
            }
        }

        $pendingTrainings = collect();
        if (!empty($categoryStudentIds)) {
            $trainingIdsInFrequency = TrainingFrequecy::whereIn('categorystudent_id', $categoryStudentIds)->pluck('training_id')->unique()->toArray();
            $today = Carbon::today();

            $pastTrainings = Training::whereIn('id', $trainingIdsInFrequency)
                ->whereDate('date_training', '<', $today)
                ->where('id', '!=', $training->id)
                ->orderBy('date_training', 'desc')
                ->get();

            foreach ($pastTrainings as $pastTraining) {
                $notFilledCount = TrainingFrequecy::where('training_id', $pastTraining->id)
                    ->whereIn('categorystudent_id', $categoryStudentIds)
                    ->where('filled', 'não')
                    ->count();

                if ($notFilledCount > 0) {
                    $pendingTrainings->push($pastTraining);
                }
            }
        }
        return view('frequency.edit-pending', [
            'category' => $category,
            'students' => $students,
            'breadcrumbs_list' => $breadcrumbs_list,
            'latestTraining' => $training,
            'currentFrequencies' => $currentFrequencies,
            'pendingTrainings' => $pendingTrainings,
            'isPendingView' => true,
        ]);
    }
}