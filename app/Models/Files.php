<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Files extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'files';

    protected $fillable = [
        'user_id',
        'name',
        'raw_name',
        'path',
        'mime_type',
        'extension',
        'size',
        'url',
        'orginal_name',
        'is_public',
        'is_image',
        'image_width',
        'image_height',
        'image_type',
        'uploaded_place'
    ];

    protected $casts = [
        'user_id' => 'string',
        'name' => 'string',
        'raw_name' => 'string',
        'path' => 'string',
        'mime_type' => 'string',
        'extension' => 'string',
        'size' => 'string',
        'url' => 'string',
        'orginal_name' => 'string',
        'is_public' => 'integer',
        'is_image' => 'integer',
        'image_width' => 'string',
        'image_height' => 'string',
        'image_type' => 'string',

    ];

    protected $dates = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function council()
    {
        return $this->belongsTo(Council::class);
    }


    public function getIsPublicAttribute($value)
    {
        return (bool) $value;
    }

    public function getIsImageAttribute($value)
    {
        return (bool) $value;
    }

    public function getImageWidthAttribute($value)
    {
        return (int) $value;
    }

    public function getImageHeightAttribute($value)
    {
        return (int) $value;
    }

    public function getImageTypeAttribute($value)
    {
        return (int) $value;
    }

    public function getCover200Attribute()
    {
        return makeCustomCover($this->id,200,200);
    }

    public function getResize200Attribute()
    {
        if($this->is_image == 1){
            return makeCustomThumb($this->id,200,200);
        }else{
            return null;
        }
    }

    public function getCover100Attribute()
    {
        return makeCustomCover($this->id,100,100);
    }

    public function getCover400Attribute()
    {
        return makeCustomCover($this->id,400,400);
    }

}
