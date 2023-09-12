<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $table = 'content';

    protected $fillable = [
        'id',
        'parent',
        'order',
        'lang_id',
        'title',
        'header_img',
        'list_img',
        'pdf',
        'summary',
        'content',
        'description',
        'keywords',
        'egitimkategorisi',
        'extra',
        'created_date',
        'updated_date',
        'lang',
        'active',
        'slider',
        'is_like',
    ];


    public function parent()
    {
        return $this->hasOne(Content::class, 'id', 'parent');
    }

    public function children()
    {
        return $this->hasMany(Content::class, 'parent', 'id');
    }

    public function childrens()
    {
        return $this->hasMany(Content::class, 'parent', 'id')->with('childrens');
    }


    public function contentGallery()
    {
        return $this->hasMany(ContentGallery::class, 'parent', 'id');
    }

    public function lang()
    {
        return $this->hasOne(Lang::class, 'id', 'lang_id');
    }

    //get all sub children
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function getSubPages($parent_id){
        $pages = [];
        $children = $this->where('parent', $parent_id)->get();
        foreach ($children as $child) {
            $pages[] = $child;
        }
        return $pages;
    }


}
