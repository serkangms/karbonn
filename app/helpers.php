<?php

if (!function_exists('codepreview')){
    function codepreview($array){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
}

function priceToFloat($s){
    // convert "," to "."
    $s = str_replace(',','.',$s);
    // remove everything except numbers and dot "."
    $s = preg_replace("/[^0-9\.]/", "", $s);


    // return float
    return (float) $s;
}
function makeCustomThumb($file_id,$width,$height,$noplaceholder = true,$quality = 80){
    $file = \App\Models\Files::find($file_id);
    if(!$file) {
        $file = \App\Models\Files::where('path',$file_id)->first();
    }
    if(!$file) {
        return asset('assets/media/svg/files/blank-image.svg');
    }
    $fileext = $file->extension;
    $mime = $file->mime_type;
    if ($fileext == 'svg'){
        return $file->path;
    }

    if ($mime != 'image/jpg' && $mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif' && $mime != 'image/webp' && $mime != 'image/svg+xml' && $mime != 'image/bmp'){
        return $file->path;
    }

    $ext = 'webp';
    $name = $file->raw_name.'_'.$width.'x'.$height.'.'.$ext;

    if(file_exists(public_path('storage/thumbnail/'.$file->raw_name.'_'.$width.'x'.$height.'.'.$ext))){
        $file->thumbnail = url('storage/thumbnail/'.$file->raw_name.'_'.$width.'x'.$height.'.'.$ext);
        return  url('storage/thumbnail/'.$name);
    }

    if(!file_exists(public_path($file->path))){
        if($noplaceholder){
            return null;
        }else{
            return url('assets/images/placeholder.png');
        }
    }

    //fit and bg color white
    $img = \Image::make($file->path)->encode('webp', $quality);
    $img->resize($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    });

    $img->resizeCanvas($width, $height, 'center', false);

    $img->save(public_path('storage/thumbnail/' . $name), $quality);
    return url('storage/thumbnail/'.$name);

}

function makeCustomCover($file_id,$width,$height,$quality = 80){
    $file = \App\Models\Files::find($file_id);
    if(!$file) {
        $file = \App\Models\Files::where('path',$file_id)->first();
    }
    if(!$file) {
        return asset('assets/media/svg/files/blank-image.svg');
    }
    $fileext = $file->extension;
    $mime = $file->mime_type;
    if ($fileext == 'svg'){
        return $file->path;
    }

    if ($mime != 'image/jpg' && $mime != 'image/jpeg' && $mime != 'image/png' && $mime != 'image/gif' && $mime != 'image/webp' && $mime != 'image/svg+xml' && $mime != 'image/bmp'){
        return $file->path;
    }

    $ext = 'webp';
    $name = $file->raw_name.'_'.$width.'x'.$height.'_cover.'.$ext;

    if(file_exists(public_path('storage/thumbnail/'.$name))){
        $file->thumbnail = url('storage/thumbnail/'.$name);
        return  url('storage/thumbnail/'.$name);
    }

    $img = \Image::make($file->path)->encode('webp', $quality);
    $img->fit($width, $height, function ($constraint) {
        $constraint->aspectRatio();
    });


    $img->save(public_path('storage/thumbnail/' . $name), $quality);
    return url('storage/thumbnail/'.$name);

}

function getLang($lang = null){
    if ($lang == null){
        $lang = app()->getLocale();
    }
    //convert to stdclass
    return json_decode(json_encode(config('translatable.'.$lang)));
}

function activeLangs(){
    return  config('translatable.locales');
}

function getFilesPath($fileid){
    $file = \App\Models\Files::find($fileid);
    if ($file){
        return $file->path;
    }
    return null;
}

if (!function_exists('turkcetarih_formati')){
    function turkcetarih_formati($format, $datetime = 'now'){

        if(app()->getLocale() != 'tr'){
            return \Carbon\Carbon::parse($datetime)->format($format);
        }

        $z = date("$format", strtotime($datetime));
        $gun_dizi = array(
            'Monday'    => 'Pazartesi',
            'Tuesday'   => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday'  => 'Perşembe',
            'Friday'    => 'Cuma',
            'Saturday'  => 'Cumartesi',
            'Sunday'    => 'Pazar',
            'January'   => 'Ocak',
            'February'  => 'Şubat',
            'March'     => 'Mart',
            'April'     => 'Nisan',
            'May'       => 'Mayıs',
            'June'      => 'Haziran',
            'July'      => 'Temmuz',
            'August'    => 'Ağustos',
            'September' => 'Eylül',
            'October'   => 'Ekim',
            'November'  => 'Kasım',
            'December'  => 'Aralık',
            'Mon'       => 'Pts',
            'Tue'       => 'Sal',
            'Wed'       => 'Çar',
            'Thu'       => 'Per',
            'Fri'       => 'Cum',
            'Sat'       => 'Cts',
            'Sun'       => 'Paz',
            'Jan'       => 'Oca',
            'Feb'       => 'Şub',
            'Mar'       => 'Mar',
            'Apr'       => 'Nis',
            'Jun'       => 'Haz',
            'Jul'       => 'Tem',
            'Aug'       => 'Ağu',
            'Sep'       => 'Eyl',
            'Oct'       => 'Eki',
            'Nov'       => 'Kas',
            'Dec'       => 'Ara',
        );
        foreach($gun_dizi as $en => $tr){
            $z = str_replace($en, $tr, $z);
        }
        if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
        return $z;
    }
}

function numToPrice($num){
    return number_format($num, 2, ',', '.');
}

function getSetting($code,$locale = null){
    if ($locale == null){
        $locale = App::getLocale();
    }
    $setting = new \App\Models\SiteConfig();
    $setting = $setting->getLocale($code,$locale);
    return $setting;
}

function siteconfig($config){
    //explode .
    $configs = explode('.',$config);
    $setting = new \App\Models\SiteConfig();
    $config = $setting->get($configs[0]);
    return  $config->{$configs[1]};
}
function siteconfigLocaled($config){
    //explode .
    $configs = explode('.',$config);
    $setting = new \App\Models\SiteConfig();
    $config = $setting->getLocale($configs[0],app()->getLocale());
    return  $config->{$configs[1]};
}

function getFilesUrl($fileid){
    $file = \App\Models\Files::find($fileid);
    if ($file){
        return url($file->path);
    }
    return null;
}


function pageMetaToEmptyData($stack){
    $stack = json_decode($stack);
    $data = [];
    foreach ($stack as $key => $value){
        if (is_array($value)){
            $data[$key] = [];
            foreach ($value as $key2 => $value2){
                $data[$key][$key2] = '';
            }
            continue;
        }
        $data[$key] = '';
    }
    return $data;
}

function getComponent($name){
    $page = cache()->remember('component_'.$name, 60*60*24, function () use ($name) {
        return \App\Models\Page::where('component_name',$name)->first();
    });
    if($page){
        if($page->status != 1){
            return null;
        }
        return $page;
    }else{
        return null;
    }
}

function descToMetaDesc($text,$limit = 150){
    $text = html_entity_decode($text);
    $text = htmlspecialchars_decode($text);
    $text = strip_tags($text);
    $text = str_replace(array("\r\n", "\r", "\n"), " ", $text);
    $text = str_replace('"', "'", $text);
    $text = str_replace('  ', ' ', $text);
    $text = \Illuminate\Support\Str::limit($text, $limit);
    return $text;
}

function getNavigation($id){
    $locale = app()->getLocale();
    $navigation = cache()->remember('navigation_'.$locale.'_'.$id, 60*60*24, function () use ($id,$locale) {
        return \App\Models\Navigation::with('itemsRecursive')->find($id)->itemsRecursive($locale)->get();
    });
    if($navigation){
        return $navigation;
    }else{
        return null;
    }
}

function getNavigationOptimize($id){
    $locale = app()->getLocale();
    return cache()->tags(['nav'])->remember('navigation_'.$locale.'_'.$id, 60*60*24, function () use ($id,$locale) {
        $nav = DB::table('navigation_items')->where('navigation_id',$id)->where('locale',$locale)->orderBy('sort_order','asc')->get();
        $navigation = [];
        foreach ($nav as $item){
            $stack = $item;
            $stack->link = $stack->url;
            if ($stack->page_id){
                $stack->page = \App\Models\PageTranslation::select('id','title','slug','deep_slug','page_id')->where('id',$stack->page_id)->first()->toArray();
                if ($stack->page['page_id']){
                    $stack->text  = $stack->page['title'];
                    $stack->url = url($stack->page['deep_slug']);
                    $stack->link = $stack->url;
                }
            }
            $stack->name = $stack->text;
            $stack->camelname = tr_ucwords($stack->text);
            $navigation[$item->id] = $stack;
        }
        foreach ($navigation as $key => $item){
            if($item->parent_id != null){
                $navigation[$item->parent_id]->children[$item->id] = $item;
                unset($navigation[$key]);
            }
        }
        $navigation = json_decode(json_encode($navigation));
        return $navigation;
    });
}

function removefirstandlastp($text){
    $text = preg_replace('/<p[^>]*>([\s\S]*?)<\/p[^>]*>/', '$1', $text);
    return $text;
}

function contentToShortDesc($text){
    $text = html_entity_decode($text);
    $text = htmlspecialchars_decode($text);
    $text = strip_tags($text);
    $text = str_replace(array("\r\n", "\r", "\n"), " ", $text);
    $text = str_replace('"', "'", $text);
    $text = str_replace('  ', ' ', $text);
    $text = \Illuminate\Support\Str::limit($text, 150);
    return $text;
}

if(!function_exists('tr_ucwords')){
    function tr_ucwords($text)
    {
        if(app()->getLocale() == 'en'){
            return ucwords(strtolower($text));
        }

        $text = tr_strtolower($text);
        $result = '';
        $keywords = explode(" ", $text);
        foreach ($keywords as $keyword){
            $keywordlong = strlen($keyword);
            $firstchar = mb_substr($keyword,0,1,'UTF-8');

            if		($firstchar=='Ç' or $firstchar=='ç'){ $firstchar='Ç'; }
            elseif	($firstchar=='Ğ' or $firstchar=='ğ'){ $firstchar='Ğ'; }
            elseif	($firstchar=='I' or $firstchar=='ı'){ $firstchar='I'; }
            elseif	($firstchar=='İ' or $firstchar=='i'){ $firstchar='İ'; }
            elseif	($firstchar=='Ö' or $firstchar=='ö'){ $firstchar='Ö'; }
            elseif	($firstchar=='Ş' or $firstchar=='ş'){ $firstchar='Ş'; }
            elseif	($firstchar=='Ü' or $firstchar=='ü'){ $firstchar='Ü'; }
            else	{ $firstchar=mb_strtoupper($firstchar); }

            $others = mb_substr($keyword,1,$keywordlong,'UTF-8');
            $result .= $firstchar.tr_strtolower($others).' ';

        }

        return trim(str_replace('  ', ' ',$result));
	}
}

if(!function_exists('tr_strtolower')){
    function tr_strtolower($text)
    {
        if(app()->getLocale() == 'tr'){
            $search		= array("Ç","İ","I","Ğ","Ö","Ş","Ü");
            $replace	= array("ç","i","ı","ğ","ö","ş","ü");
            $text		= str_replace($search,$replace,$text);
        }
        return mb_strtolower($text);
    }
}

function getpagelink($pageid){
    $page = \App\Models\Page::find($pageid);
    if($page){
        return url($page->deep_slug);
    }else{
        return null;
    }
}

function downloadfile($id){
    return route('downloadfile',$id);
}

function _trans($key = null, $replace = [], $locale = null){
    if (is_null($key)) {
        return $key;
    }

    if(!\Illuminate\Support\Facades\Lang::has($key)){
        add_key_to_language_files($key);
    }

    return trans($key, $replace, $locale);
}

function add_key_to_language_files($key)
{
    foreach (array('en','tr') as $locale){
        $jsonString = file_get_contents(base_path('lang/'.$locale.'.json'));
        $dataJson = json_decode($jsonString, true);

        if (!isset($dataJson[$key])) {
            $dataJson[$key] = $key;
            $newJsonString = json_encode($dataJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents(base_path('lang/'.$locale.'.json'), stripslashes($newJsonString));
        }
    }
}


function getYoutubeData($id){
    $url = 'https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v='.$id.'&format=json';
    $data = json_decode(file_get_contents($url));
    return $data;
}


function sendSMS($phone,$text) {
    $url = "http://api.efetech.net.tr/v2/sms/basic";
    $headers = array(
        "Host: api.efetech.net.tr",
        "Authorization:Key vc5D5jUUiAiek5GxxJMgqgWhqguJcqudwEKFLpvHXPne",
        "Content-Type: application/json",
        "Accept: application/json"
    );

    $data = array(
        "originator" => "EFECELL",
        "message" => $text,
        "to" => array($phone),
        "encoding" => "auto"
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if($e = curl_error($ch)){
        echo $e;
    } else {
        echo $response;
    }

    curl_close($ch);
    return $response;
}


function diffhumantr($diff){

    $min = 'dakika';
    $hour = 'saat';
    $day = 'gün';
    $week = 'hafta';
    $month = 'ay';
    $year = 'yıl';

    $diff = str_replace('minutes', $min, $diff);
    $diff = str_replace('minute', $min, $diff);
    $diff = str_replace('hours', $hour, $diff);
    $diff = str_replace('hour', $hour, $diff);
    $diff = str_replace('days', $day, $diff);
    $diff = str_replace('day', $day, $diff);
    $diff = str_replace('weeks', $week, $diff);
    $diff = str_replace('week', $week, $diff);
    $diff = str_replace('months', $month, $diff);
    $diff = str_replace('month', $month, $diff);
    $diff = str_replace('years', $year, $diff);
    $diff = str_replace('year', $year, $diff);
    return $diff;
}
