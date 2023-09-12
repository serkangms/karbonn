<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected  $table = 'answer';
    protected $fillable = [
        'question_id',
        'question_input_id',
        'quantity',
        'user_id',
        'inner_total',
        'outer_total',
        'created_at',
    ];
    public $timestamps = false;

    public function Question()
    {
        return $this->belongsTo(Question::class);
    }

    public function Questioninput()
    {
        return $this->belongsTo(Questioninput::class,'question_input_id','id');
    }
    public function CarbonSubmit()
    {
        return $this->belongsTo(CarbonSubmit::class,'carbon_submit_id','id');
    }
}
