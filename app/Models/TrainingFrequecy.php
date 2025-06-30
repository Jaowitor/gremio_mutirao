<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Adicionado use para HasFactory

class TrainingFrequecy extends Model
{
    use HasFactory;

    protected $table = 'training_frequecies';

    protected $fillable = [
        'categorystudent_id',
        'training_id',
        'presence',
        'filled',
    ];

    /**
     * Cada registro `training_frequency` pertence a um treino.
     */
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    /**
     * Cada registro `training_frequency` pertence a um `category_student`.
     */
    public function categoryStudent()
    {
        return $this->belongsTo(CategoryStudent::class, 'categorystudent_id');
    }
}
