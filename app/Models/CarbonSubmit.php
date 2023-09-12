<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonSubmit extends Model
{
    use HasFactory;
    protected $table = 'carbon_submit';
    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'created_at',
        'updated_at',
        'type',
        'total',

    ];
    public $timestamps = false;

    public function answer()
    {
        return $this->hasMany(Answer::class, 'carbon_submit_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cities()
    {
        return $this->belongsTo(Cities::class, 'city_id');
    }
    public function userForm()
    {
        return $this->belongsTo(UserForm::class, 'user_form_id');
    }
    public function carbonTotal()
    {
        return $this->hasOne(CarbonTotal::class); // CarbonTotal modelini kullanarak ilişkilendirme yapılabilir
    }
}
