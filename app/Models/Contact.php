<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Contact extends Model
{
    use HasFactory;
    protected  $table = 'contact';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'description',
        'title',
        'created_at',

    ];
}
