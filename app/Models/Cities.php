<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';
    protected $fillable = ['name', 'state_id'];

    public $timestamps = false;

    public function CarbonSubmit()
    {
        return $this->hasMany(CarbonSubmit::class);
    }
    public function Question()
    {
        return $this->belongsTo(Question::class);
    }

}
