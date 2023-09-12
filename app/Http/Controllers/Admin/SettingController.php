<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\SiteConfig;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function basicEdit($code){
        $setting = new SiteConfig();
        $setting = $setting->getAllLocale($code);
        return view('admin.settings.basic', compact('code','setting'));
    }

    public function update(Request $request){
        $stack = request()->all();
        unset($stack['_token']);

        foreach ($stack as $key=>$item){
            if(is_array($item)){
                foreach ($item as $k=>$i){
                    $exlodeditem = explode('|', $k);
                    $codeitem = $exlodeditem[0];
                    $keyitem = $exlodeditem[1];
                    $locale = $key;



                    $config = SiteConfig::where('code', $codeitem)->where('key', $keyitem)->where('locale', $locale)->first();
                    if ($config){
                        $config->update([
                            'value' => $i
                        ]);
                    }else{
                        SiteConfig::create([
                            'code' => $codeitem,
                            'key' => $keyitem,
                            'value' => $i,
                            'locale' => $locale
                        ]);
                    }
                }
            }else{
                $exlodeditem = explode('|', $key);
                $codeitem = $exlodeditem[0];
                $keyitem = $exlodeditem[1];
                $locale = '';
                if (isset($exlodeditem[2])) {
                    $locale = $exlodeditem[2];
                }

                $config = SiteConfig::where('code', $codeitem)->where('key', $keyitem)->where('locale', $locale)->first();
                if ($config){
                    $config->update([
                        'value' => $item
                    ]);
                }else{
                    SiteConfig::create([
                        'code' => $codeitem,
                        'key' => $keyitem,
                        'value' => $item,
                        'locale' => $locale
                    ]);
                }
            }
        }

        $allSettings = SiteConfig::all();
        foreach ($allSettings as $setting){
            if($setting->write_env){
                $env = $setting->key;
                $value = $setting->value;
                $path = base_path('.env');
                if (file_exists($path)) {
                    file_put_contents($path, str_replace(
                        $env.'='.env($env), $env.'='.$value, file_get_contents($path)
                    ));
                }
            }
        }

        return back()->with('success', 'Ayarlar Güncellendi');
    }

    public function cacheStats(){
        $memcached = new \Memcached();
        $memcached->addServer('127.0.0.1', 11211);
        $stats = $memcached->getAllKeys();
        $keys = [];
        foreach ($stats as $key => $value) {
            $keys[] = $value;
        }
        return view('admin.settings.cache', compact('keys'));
    }

    public function translate(){

        $languages = Language::all();

        $data = [];
        $keys = [];
        $langData = [];
        foreach ($languages as $language){
            $jsonString = file_get_contents(base_path('lang/'.$language->code.'.json'));
            $data[$language->code] = json_decode($jsonString, true);
            $data[$language->code] = array_filter($data[$language->code], function ($value) {
                return $value !== null;
            });
            $keys[$language->code] = array_keys($data[$language->code]);
        }

        foreach ($data as $lang => $value){
            foreach ($value as $key => $item){
                $langData[$key][$lang] = $item;
            }
        }

        //if lang null set null
        foreach ($langData as $key => $item){
            foreach ($languages as $language){
                if(!isset($item[$language->code])){
                    $langData[$key][$language->code] = null;
                }
            }
        }

        return view('admin.settings.translate', compact('languages', 'langData'));
    }

    public function translateUpdate(Request $request){
        $key = $request->key;

        if ($key == null){
            return response()->json(['status' => 'error', 'message' => 'Key bulunamadı']);
        }


        $data = array();
        foreach (config('translatable.locales') as $locale){
            $data[$locale] = $request[$locale];
        }

        //update json file
        foreach (config('translatable.locales') as $locale){
            $jsonString = file_get_contents(base_path('lang/'.$locale.'.json'));
            $dataJson = json_decode($jsonString, true);
            $dataJson[$key] = $data[$locale];
            $newJsonString = json_encode($dataJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents(base_path('lang/'.$locale.'.json'), stripslashes($newJsonString));
        }

        return response()->json(['status' => 'success', 'message' => 'Güncellendi']);
    }


}
