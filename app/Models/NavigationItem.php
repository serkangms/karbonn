<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NavigationItem extends Model
{
    use HasFactory;

    protected $table = 'navigation_items';

    protected $fillable = [
        'text',
        'url',
        'locale',
        'parent_id',
        'navigation_id',
        'sort_order',
        'status',
        'page_id'
    ];

    public function navigation()
    {
        return $this->belongsTo(Navigation::class);
    }

    public function parent()
    {
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(NavigationItem::class, 'parent_id');
    }

    public function siblings()
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')->where('id', '!=', $this->id);
    }

    public function page()
    {
        return $this->belongsTo(PageTranslation::class, 'page_id', 'id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive')->with('page');
    }

    public function getNameAttribute()
    {
        if($this->page_id){
            return $this->page->title ?? $this->text;
        }
        return $this->text;
    }

    public function getCamelNameAttribute()
    {
        return Str::title($this->name);
    }

    public function getLinkAttribute()
    {
        if($this->page_id){
            return url($this->page->deep_slug);
        }
        return $this->url;
    }

}
