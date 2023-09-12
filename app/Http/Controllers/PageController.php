<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
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
    public function index($deep_slug){

        $pagetransid = DB::table('page_translations')->where('deep_slug', '=', $deep_slug)->where('status', '=', 1)->select('id')->first();
        if (!$pagetransid){
            return abort(404);
        }



        $pagetrans = new PageTranslation();
        $pagetrans = $pagetrans->find($pagetransid->id);

        $page = $pagetrans->page;
        $mainpage = $page->MainParent;

        if($pagetrans->locale != app()->getLocale()){
            if ($pagetrans->page->parent_id == '109'){
                app()->setLocale('tr');
                session()->put('locale', 'tr');
            }

            $otherlang = $pagetrans->page->translate(app()->getLocale());
            if ($otherlang){
                $newurl = $otherlang->deep_slug;
                $newurl = url($newurl);
                return redirect($newurl);
            }
        }



        $menuitems = null;
        $menutext = null;

        if ($page->menu_text){
            $menutext = $page->menu_text;
        }


        $sidebarmenu = null;
        if ($page->siblings_menu){
            $sidebarmenu = $page->siblings;
        }

        if ($page->parent_menu){
            $sidebarmenu = Page::find($page->parent_menu);
            $menutext = $sidebarmenu->menu_text ? $sidebarmenu->menu_text : $sidebarmenu->title;
        }

        if(!$sidebarmenu){
            $sidebarmenu = $mainpage;
        }

        if (!$menutext){
            $menutext = $mainpage->menu_text ? $mainpage->menu_text : $mainpage->title;
        }


        if($pagetrans && $page->type != 'component' && $page->type != 'category' && $page->status == 1){
            $template = 'default';
            if ($page->parent){
                if ($page->parent->child_template){
                    $template = $page->parent->child_template;
                }
            }

            if ($page->layout == 'full'){
                $template = 'full';
            }

            if ($page->template){
                $template = $page->template;
            }

            $seoMeta['meta_title'] = $pagetrans->meta_title ?? $pagetrans->title;
            $seoMeta['meta_description'] = $pagetrans->meta_description ?? descToMetaDesc($pagetrans->description);
            $seoMeta['meta_keywords'] = $pagetrans->meta_keywords;
            $seoMeta['meta_image'] = $pagetrans->image_id ?? null;
            $seoMeta['locale'] = $pagetrans->locale;

            return view('theme.page.'.$template, compact('page', 'sidebarmenu', 'menutext', 'mainpage','pagetrans', 'seoMeta'));
        }else{
            return abort(404);
        }
    }

    public function search(){
        if(request()->q == null){
            return redirect()->route('home');
        }
        return view('theme.page.search');
    }

    public function search_fetch(Request $request){
        $search = $request->q;
        if(!$search){
            return "<div class='search-result-item'>".__('No results')."</div>";
        }

        $pageTrans = PageTranslation::where('title', 'LIKE', "%{$search}%")->orWhere('description', 'LIKE', "%{$search}%")->where('status', '=', 1)->where('locale', '=', app()->getLocale())->limit(20)->get();
        $html = '';
        foreach ($pageTrans as $item){
            $html .= view('theme.partials.search_item', compact('item'))->render();
        }
        return $html;
    }
}
