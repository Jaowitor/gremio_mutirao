<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Student;

class SistemaController extends Controller
{
    public function dashboard()
    {
        $totalJogadores = Student::count();
        $breadcrumbs_list = $this->getBreadcrumbs();
        return view('dashboard', compact('totalJogadores', 'breadcrumbs_list'));
    }

    public function getBreadcrumbs()
    {
        // Capturar IDs corretamente das rotas e inputs
        $studentId = request()->route('id') ?? request()->input('student_id');
        $categoryId = request()->route('category') ?? request()->input('category_id');
        $trainingId = request()->route('training') ?? request()->input('training_id'); 
        $rotaAtual = request()->route()->getName();

        // Breadcrumb inicial
        $breadcrumbs = [
            ['name' => 'Inicio', 'method' => 'GET', 'url' => route('dashboard')],
        ];

        // Breadcrumbs dinâmicos para alunos
        if (strpos($rotaAtual, 'students') !== false) {
            $breadcrumbs[] = ['name' => 'Alunos', 'method' => 'GET', 'url' => route('students.index')];

            if ($rotaAtual === 'students.create') {
                $breadcrumbs[] = ['name' => 'Criar Aluno', 'method' => 'POST', 'url' => route('students.create')];
            } elseif ($rotaAtual === 'students.edit' && $studentId) {
                $breadcrumbs[] = ['name' => 'Editar Aluno', 'method' => 'PUT', 'url' => route('students.edit', ['id' => $studentId])];
            } elseif ($rotaAtual === 'students.show' && $studentId) {
                $breadcrumbs[] = ['name' => 'Ficha', 'method' => 'GET', 'url' => route('students.show', ['id' => $studentId])];
            }
        }

        // Breadcrumbs dinâmicos para categorias
        if (strpos($rotaAtual, 'category') !== false) {
            $breadcrumbs[] = ['name' => 'Turmas', 'method' => 'GET', 'url' => route('category.index')];

            if ($rotaAtual === 'category.create') {
                $breadcrumbs[] = ['name' => 'Criar Categoria', 'method' => 'POST', 'url' => route('category.create')];
            } elseif ($rotaAtual === 'category.edit' && $categoryId) {
                $breadcrumbs[] = ['name' => 'Editar Turma', 'method' => 'PUT', 'url' => route('category.edit', ['category' => $categoryId])];
            } elseif ($rotaAtual === 'category.show' && $categoryId) {
                $breadcrumbs[] = ['name' => 'Alunos', 'method' => 'GET', 'url' => route('category.show', ['category' => $categoryId])];
            } elseif ($rotaAtual === 'category.add_student' && $categoryId) {
                $breadcrumbs[] = ['name' => 'Alunos', 'method' => 'GET', 'url' => route('category.show', ['category' => $categoryId])];
                $breadcrumbs[] = ['name' => 'Adicionar Alunos', 'method' => 'GET', 'url' => route('category.add_student', ['category' => $categoryId])];
            }
        }

        // Breadcrumbs dinâmicos para frequência
        if (strpos($rotaAtual, 'frequency') !== false) {
            $breadcrumbs[] = ['name' => 'Turmas', 'method' => 'GET', 'url' => route('category.index')];
            $breadcrumbs[] = ['name' => 'Alunos', 'method' => 'GET', 'url' => route('category.show', ['category' => $categoryId])];
            $breadcrumbs[] = ['name' => 'Frequencia', 'method' => 'GET', 'url' => route('frequency.index', ['category' => $categoryId])];
        }

        // Breadcrumbs dinâmicos para treinamentos
        if (strpos($rotaAtual, 'training') !== false) {
            $breadcrumbs[] = ['name' => 'Treinos', 'method' => 'GET', 'url' => route('training.index')];

            if ($rotaAtual === 'training.create') {
                $breadcrumbs[] = ['name' => 'Criar Treino', 'method' => 'POST', 'url' => route('training.create')];
            } 

            elseif ($rotaAtual === 'training.edit' && $trainingId) {
                $breadcrumbs[] = ['name' => 'Editar Treino', 'method' => 'PUT', 'url' => route('training.edit', ['training' => $trainingId])];
            }  elseif ($rotaAtual === 'training.showCategory' && $trainingId) {
                $breadcrumbs[] = ['name' => 'Frequência', 'method' => 'GET', 'url' => route('training.showCategory', ['training' => $trainingId])];
            }
        }

        return $breadcrumbs;
    }
}