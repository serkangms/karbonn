<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

class SiteConfig extends Model
{
    use HasFactory;


    protected $table = 'site_configs';

    protected $fillable = [
        'code',
        'key',
        'value',
    ];

    //get code all config

    public function get($code,$locale = null)
    {
        if ($locale){
            $locale = app()->getLocale();
        }
        $configs = $this->where('code', $code)->get();
        $config = [];
        foreach ($configs as $item) {
            $config[$item->key] = $item->value;
        }
        return (object)$config;
    }

    public function getLocale($code,$locale = null){
        if (!$locale){
            $locale = app()->getLocale();
        }
        $configs = $this->where('code', $code)->where('locale', $locale)->get();
        $config = [];
        foreach ($configs as $item) {
            $config[$item->key] = $item->value;
        }
        return (object)$config;
    }

    public function getAllLocale($code){
        $configs = $this->where('code', $code)->get();
        $config = [];
        foreach ($configs as $item) {
            $config[$item->locale][$item->key] = $item->value;
        }

        foreach ($config as $key => $value){
            if(!$key){
                $config['global'] = $value;
                unset($config[$key]);
            }
        }

        return (object)$config;
    }

    public function set($code,$key, $value){
        $config = $this->where('code', $code)->where('key', $key)->first();
        if ($config){
            $config->value = $value;
            $config->save();
        }else{
            $this->create([
                'code' => $code,
                'key' => $key,
                'value' => $value,
            ]);
        }
    }

    public function updateConfig($data){
        foreach ($data as $key => $value){
            if (is_array($value)){
                foreach ($value as $k => $v){
                    if (is_file($v)){
                        $filename = time().'_'.$v->getClientOriginalName();
                        $v->move(public_path('uploads'), $filename);
                        $this->set($key,$k, $filename);
                    }else{
                        $this->set($key,$k,$v);
                    }

                }
            }
        }
    }


}
