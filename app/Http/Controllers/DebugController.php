<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Council;
use App\Models\Files;
use App\Models\Navigation;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DebugController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '2048M');
        ini_set('post_max_size', '2048M');
        ini_set('upload_max_filesize', '2048M');
        ini_set('max_input_time', 3000);
        ini_set('allow_url_fopen', 1);
    }


    public function fileurlfix(){
        $files = Files::all();
        foreach ($files as $file) {
            $file->url = url('storage/'.$file->name);
            $file->save();
        }
    }

}
