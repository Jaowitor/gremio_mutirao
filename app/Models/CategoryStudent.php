<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryStudent extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'category_id'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'category_student');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_student');
    }

}