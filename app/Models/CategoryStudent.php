<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryStudent extends Model
{
    use HasFactory;

    protected $table = 'category_students';

    // A coluna 'id' desta tabela é o 'categorystudent_id' mencionado em TrainingFrequecy
    protected $fillable = ['student_id', 'category_id'];

    /**
     * Cada registro `category_student` pertence a um estudante.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Cada registro `category_student` pertence a uma categoria.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Um registro `CategoryStudent` pode ter muitos registros de frequência de treino associados.
     */
    public function trainingFrequecies()
    {
        return $this->hasMany(TrainingFrequecy::class, 'categorystudent_id', 'id');
    }
}