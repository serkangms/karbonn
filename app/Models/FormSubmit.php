<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmit extends Model
{
    use HasFactory;

    protected $table = 'form_submits';

    protected $fillable = [
        'form_id',
        'answers',
        'ip_address',
        'user_agent',
        'created_at',
        'updated_at',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }

    public function getAnswersFormatAttribute()
    {
        return json_decode($this->answers, true);
    }


}
