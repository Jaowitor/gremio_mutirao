<?php

namespace App\Http\Controllers;
use App\Models\Student;


class SistemaController extends Controller {

    public function dashboard()
    {
        $totalJogadores = Student::count();
        $breadcrumbs_list = $this->getBreadcrumbs();
        return view('dashboard', compact('totalJogadores', 'breadcrumbs_list'));
    }
    public function getBreadcrumbs()
    {

        $studentId = request()->route('id') ?? request()->input('student_id');
        return [
            ['name' => 'Inicio', 'method' => 'GET', 'url' => route('dashboard')],
            ['name' => 'Alunos', 'method' => 'GET', 'url' => route('students.index')],
            ['name' => 'Criar Aluno', 'method' => 'POST', 'url' => route('students.create')],
            ['name' => 'Editar Ficha', 'method' => 'PUT', 'url' => $studentId ? route('students.edit', ['id' => $studentId]) : '#'],
            ['name' => 'Ficha', 'method' => 'GET', 'url' => $studentId ? route('students.show', ['id' => $studentId]) : '#']
        ];
    }
    }