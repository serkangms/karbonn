<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';

    protected $fillable = [
        'name',
        'code',
        'flag',
        'rtl',
        'status',
        'is_main',
        'created_at',
        'updated_at',
    ];
}
