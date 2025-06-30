<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'type_category',
        'name_category',
        'description',
    ];

    /**
     * Uma categoria tem muitos estudantes através da tabela pivô `category_students`.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'category_students', 'category_id', 'student_id');
    }

    /**
     * Uma categoria tem muitos registros CategoryStudent.
     * Isso permite acessar diretamente os registros da tabela `category_students` que pertencem a esta categoria.
     */
    public function categoryStudents()
    {
        return $this->hasMany(CategoryStudent::class, 'category_id', 'id');
    }
}
