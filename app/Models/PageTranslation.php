<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Str;

class PageTranslation extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'page_translations';

    protected $fillable = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_content',
        'status',
        'image_id',
        'publish_date',
        'slug',
        'deep_slug',
        'summary',
        'use_custom_slug',
        'gallery',
        'ugmid',
        'menu_text',
        'form_id',
        'sort_order',
        'list_image_id',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs();
    }

    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if(!$model->use_custom_slug){
                $model->deep_slug = $model->parent_slug;
            }
        });

        static::creating(function ($model) {
            if(!$model->use_custom_slug){
                $model->deep_slug = $model->parent_slug;
            }
        });
    }

    public function getParentSlugAttribute()
    {
        $locale = $this->locale;
        $parent = null;
        if ($this->page->parent_id) {
            $parent = $this->page->parent->translations->where('locale', $locale)->first();
        }

        $parentSlug = '';
        while ($parent) {
            $parentSlug = Str::slug($parent->slug) . '/' . Str::slug($parentSlug);
            $parent = $parent->parent;
        }
        $newSLug = $parentSlug.'/'.Str::slug($this->title);
        $newSLug = str_replace('//', '/', $newSLug);

        $countOther = PageTranslation::where('deep_slug', $newSLug)->where('id', '!=', $this->id)->count();

        while (PageTranslation::where('deep_slug', $newSLug)->where('id', '!=', $this->id)->first()) {
            $lastid = explode('-', $newSLug);
            if(count($lastid) > 1){
                $lastid = end($lastid);
                if(!is_numeric($lastid)){
                    $lastid = 1;
                }else{
                    $newSLug = str_replace('-' . $lastid, '-' . ($lastid + 1), $newSLug);
                }
            }else{
                $newSLug = $newSLug.'-1';
            }
        }

        if($this->locale == 'tr'){
            $newSLug = $newSLug;
        }else{
            $newSLug = $this->locale.'/'.$newSLug;
        }

        $newSLug = str_replace('//', '/', $newSLug);

        //if first char is / remove it
        if(substr($newSLug, 0, 1) == '/'){
            $newSLug = substr($newSLug, 1);
        }

        return $newSLug;
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function image()
    {
        return $this->belongsTo(Files::class, 'image_id', 'id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }

    public function getimageurlAttribute()
    {
        return $this->image_id ? $this->image->cover200 : asset('assets/media/svg/files/blank-image.svg');
    }

    //get other language
    public function getOtherLangAttribute($lang)
    {
        $otherLang = $this->page->translations->where('locale', '!=', $lang)->first();
        return $otherLang ? $otherLang->slug : '';
    }

    public function getcontentAttribute(){
        return json_decode($this->meta_content);
    }

    public function getgalleryFormatAttribute(){
        return json_decode($this->gallery);
    }
}
