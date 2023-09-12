<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;
    protected $table = 'user_image';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'image_id',
    ];
    public function user()
    {
        return $this->belongsTo(Complain::class);
    }

    public function image()
    {
        return $this->belongsTo(Files::class);
    }

}
