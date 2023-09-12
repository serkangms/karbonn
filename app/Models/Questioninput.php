<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questioninput extends Model
{
    use HasFactory;
    protected $table = 'question_input';
    protected $fillable = [
        'id',
        'question_id',
        'name',
        'quantity',
    ];
    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
    public function answer()
    {
        return $this->hasMany(Answer::class, 'question_input_id', 'id');
    }
}

