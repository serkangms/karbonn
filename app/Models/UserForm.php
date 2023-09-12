<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserForm extends Model
{
    use HasFactory;
    protected $table = 'user_form';
    public $timestamps = false;
    protected $fillable = [
        'user_name',
        'user_email',
        'user_job',
        'city_id',
        'user_file',
    ];
    public function city()
    {
        return $this->belongsTo(Cities::class,'city_id');
    }
    public function CarbonSubmit()
    {
        return $this->hasMany(CarbonSubmit::class,'user_form_id');
    }
}
