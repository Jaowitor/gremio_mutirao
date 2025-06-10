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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
