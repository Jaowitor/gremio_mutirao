<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nationality',
        'position', 'laterality',
        'height', 'weight', 'medication',
        'date_init', 'date_end',
        'date_of_birth',
        'active'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'date_init' => 'date',
        'date_end' => 'date',
    ];

    /**
     * Um estudante pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Um estudante pertence a muitas categorias através da tabela pivô `category_students`.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_students', 'student_id', 'category_id');
    }

    /**
     * Um estudante tem muitos registros CategoryStudent.
     * Isso permite acessar diretamente os registros da tabela `category_students` que pertencem a este estudante.
     */
    public function categoryStudents()
    {
        return $this->hasMany(CategoryStudent::class, 'student_id', 'id');
    }
}