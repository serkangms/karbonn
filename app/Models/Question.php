<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'question';
    protected $fillable = [
        'id',
        'title',
        'type',
    ];
    public $timestamps = false;

    public function Questioninput()
    {
        return $this->hasMany(Questioninput::class);
    }
    public function cities()
    {
        return $this->hasMany(Cities::class);
    }
}

