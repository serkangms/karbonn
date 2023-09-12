<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Page extends Model
{
    use HasFactory, Translatable;

    protected $table = 'pages';

    public $translatedAttributes = [
        'title',
        'description',
        'keywords',
        'slug',
        'image_id',
        'imageurl',
        'deep_slug',
        'status',
        'meta_content',
        'content',
        'summary',
        'gallery',
        'galleryFormat',
        'ugmid',
        'menu_text',
        'form_id',
        'form',
        'publish_date',
        'sort_order',
        'list_image_id'
        ];

    protected $fillable = [
        'meta',
        'child_meta',
        'parent_id',
        'only_one_child',
        'list_dom_replace_1',
        'list_dom_replace_2',
        'list_dom_replace_3',
        'component_name',
        'locales',
        'ugmlangid',
        'type',
        'sidebar_text',
        'layout',
        'parent_menu',
        'template',
        'child_template',
        'hide_child_sections',
        'hide_sections',
        'hide_menu_sub_items',
        'component_only'
    ];

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id', 'id');
    }

    public function parents()
    {
        return $this->belongsTo(Page::class, 'parent_id', 'id')->with('parents');
    }

    public function parentMenu()
    {
        return $this->belongsTo(Page::class, 'parent_menu', 'id');
    }

    public function siblings()
    {
        return $this->hasMany(Page::class, 'parent_id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id')->orderBy('id', 'desc');
    }

    public function childrens()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id')->with('childrens');
    }

    public function getChildrenCountAttribute()
    {
        return DB::table('pages')->where('parent_id', $this->id)->count();
    }

    public function image()
    {
        return $this->belongsTo(Files::class, 'image_id', 'id');
    }

    public function getImageCoverAttribute()
    {
        return $this->image_id ? $this->image->cover200 : asset('assets/media/svg/files/blank-image.svg');
    }

    public function getAdminEditUrlAttribute(){
        return route('admin.page.edit', $this->id);
    }

    public function getAdminDeleteUrlAttribute(){
        return route('admin.page.delete', $this->id);
    }

    public function getUpperCategoriesAttribute()
    {
        $pages = [];
        $parent = $this->parent;
        while ($parent) {
            $pages[] = $parent;
            $parent = $parent->parent;
        }
        return $pages;
    }

    public function getMainParentAttribute()
    {
        $parent = $this->parent;
        while ($parent) {
            $main_parent = $parent;
            $parent = $parent->parent;
        }

        if (empty($main_parent))
            return $this;

        return $main_parent;
    }

    public function getSubCategoriesAttribute()
    {
        $pages = [];
        $children = $this->children;
        foreach ($children as $child) {
            $pages[] = $child;
        }
        return $pages;
    }

    public function getSubPages($parent_id){
        $pages = [];
        $children = $this->where('parent_id', $parent_id)->get();
        foreach ($children as $child) {
            $pages[] = $child;
        }
        return $pages;
    }

    public function getParentPages($parent_id){
        $pages = [];
        $parent = $this->where('id', $parent_id)->first();
        while ($parent) {
            $pages[] = $parent;
            $parent = $parent->parent;
        }
        return $pages;
    }

    public function getLinkAttribute()
    {
        if ($this->deep_slug){
            return url($this->deep_slug);
        }
        return null;
    }

}
