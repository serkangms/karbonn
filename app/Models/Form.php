<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = 'forms';

    protected $fillable = [
        'name',
        'description',
        'image_id',
        'meta',
        'locale',
        'max_submit',
        'status',
    ];

    public function submit()
    {
        return $this->hasMany(FormSubmit::class, 'form_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(Files::class, 'image_id', 'id');
    }

    public function getFieldsAttribute()
    {
        return json_decode($this->meta);
    }



}
