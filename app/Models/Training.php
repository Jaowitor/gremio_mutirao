<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'planejamento',
        'date_training',
    ];

    protected $casts = [
        'date_training' => 'datetime',
    ];

    /**
     * Um treino pode ter muitos registros de frequência de treino.
     */
    public function trainingFrequecies()
    {
        return $this->hasMany(TrainingFrequecy::class, 'training_id', 'id');
    }

    /**
     * Um treino pertence a muitos `CategoryStudent` através da tabela pivô `training_frequecies`.
     * Isso é como ele se liga a CategoryStudent, que então se liga a Category e Student.
     */
    public function categoryStudents()
    {
        return $this->belongsToMany(CategoryStudent::class, 'training_frequecies', 'training_id', 'categorystudent_id');
    }

    /**
     * Mutator para formatar a data de treino ao acessá-la.
     */
    public function getDateTrainingAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }
}
