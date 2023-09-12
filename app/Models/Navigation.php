<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $table = 'navigation';

    protected $fillable = [
        'name'
    ];

    public function items()
    {
        return $this->hasMany(NavigationItem::class)->where('parent_id', null)->orderBy('sort_order');
    }

    public function itemsAll()
    {
        return $this->hasMany(NavigationItem::class)->orderBy('id', 'desc');
    }

    //get all items with infinite subitems
    public function itemsRecursive($locale = null)
    {
        if (!$locale)
            $locale = app()->getLocale();

        return $this->items()->with('childrenRecursive')->where('locale',$locale);
    }
}
