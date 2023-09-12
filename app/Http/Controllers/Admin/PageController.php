<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageTranslation;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function index($parent_id = null){
        return view('admin.pages.index', compact('parent_id'));
    }

    public function fetch(Request $request){
        //search - per_page - parent_id
        $parentId = $request->parent_id ?? 0;
        $pageTrans  = new PageTranslation();




        $pageTrans = PageTranslation::where('locale', app()->getLocale())
            ->whereHas('page', function ($query){
                $query->where('component_only', 0);
            })
            ->orderBy('sort_order', 'asc')->with('page');

        if ($request->search) {
            $searchTerm = '%' . $request->search . '%';
            $pageTrans = $pageTrans->where(function ($query) use ($searchTerm) {
                $query->whereRaw('LOWER(title) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(deep_slug) LIKE ?', [$searchTerm]);
            });
        }else{
            $pageTrans = $pageTrans
                ->whereHas('page', function ($query) use ($parentId) {
                    $query->where('parent_id', $parentId);
                });
        }


        $pages = $pageTrans->paginate($request->per_page ?? 10);

        $pages->getCollection()->transform(function ($item) {
            return $item->page;
        });

        $pages->map(function($page){
            $page->status = $page->status;
            $page->image_url = $page->image_cover;
            $page->ChildrenCount = $page->ChildrenCount;
            $page->AdminEditUrl = $page->AdminEditUrl;
            $page->AdminDeleteUrl = $page->AdminDeleteUrl;
            $page->SiteUrl = url($page->deep_slug);

            if($page->parent_id){
                $page->parent_title = $page->parent->title;
            }else{
                $page->parent_title = '';
            }

            if ($page->parent_id){
                if (isset($page->parent->list_dom_replace_1)){
                    $page->title = $page->content->{$page->parent->list_dom_replace_1} ?? '';
                }
                if (isset($page->parent->list_dom_replace_2)){
                    $page->deep_slug = $page->content->{$page->parent->list_dom_replace_2} ?? '';
                }
                if (isset($page->parent->list_dom_replace_3)){
                    $page->image_url = $page->content->{$page->parent->list_dom_replace_3}->id ?? '';
                    if ($page->image_url){
                        $page->image_url = makeCustomCover($page->image_url,100,100) ?? '';
                    }
                }
            }

            $page->title = Str::limit($page->title, 60);
            $page->deep_slug = Str::limit($page->deep_slug, 50);

            return $page;
        });

        if ($request->parent_id){
            $parent_map = new Page();
            $parent_map = $parent_map->getParentPages($request->parent_id);
        }else{
            $parent_map = array();
        }


        return response()->json([
            'status' => 'success',
            'pages' => $pages->setCollection($pages->getCollection()->sortBy('sort_order')),
            'parent_map' => array_reverse($parent_map),
            'languages' => config('translatable.locales'),
        ]);
    }

    public function create($parent_id = null){
        $page = new Page();
        $pageData = $page->toArray();
        $page->parent_id = $parent_id;
        $pageTranslations = array();
        foreach(config('translatable.locales') as $locale){
            $pageData['translations'][$locale] = new PageTranslation([
                'title' => '',
                'page_id' => '',
                'locale' => '',
                'slug' => '',
                'image_id' => '',
                'description' => '',
                'keywords' => '',
                'created_at' => '',
                'updated_at' => '',
                'meta_title' => '',
                'meta_description' => '',
                'status' => '',
                'image_url' => '',
                'use_custom_slug' => 0,
            ]);
        }

        $parentPage = Page::find($parent_id);

        $meta = array();
        $page_meta_data = array();

        if ($parentPage){
            if ($parentPage->type == 'component_group') {
                foreach (activeLangs() as $locale) {
                    $page_meta_data[$locale] = pageMetaToEmptyData($parentPage->child_meta);
                }
                $meta = $parentPage->child_meta;
            }
        }

        if (!$page_meta_data){
            foreach (activeLangs() as $locale) {
                $page_meta_data[$locale] = array();
            }
        }
        if (!$meta){
            $meta = 'null';
        }

        $locales = config('translatable.locales');
        if ($parentPage){
            if($parentPage->locales){
                $locales = json_decode($parentPage->locales);
            }
        }

        if ($parentPage){
            $sections = config('constants.page.type.'.$parentPage->type.'.sub_sections');
        }else{
            $sections = config('constants.page.type.page.sections');
        }



        return view('admin.pages.edit',compact('page','pageTranslations','pageData','parent_id','parentPage','meta','page_meta_data','sections','locales'));
    }

    public function edit($id){
        $page = Page::find($id);
        $pageData = $page->toArray();
        $pageData['parents'] = collect($page->getParentPages($id))->reverse()->toArray();
        $pageData['translations'] = array_combine(array_column($pageData['translations'], 'locale'), $pageData['translations']);
        $pageData['translations'] = array_map(function($translation){
            $translation['image_url'] =  getFilesPath($translation['image_id']);
            $translation['list_image_url'] =  getFilesPath($translation['list_image_id']);
            $translation['gallery'] =  json_decode($translation['gallery']);
            return $translation;
        }, $pageData['translations']);

        $parent_id = $page->parent_id;
        $parentPage = Page::find($parent_id);

        $meta = array();
        $meta = $page->meta;
        if (!$meta){
            if ($parentPage){
                if ($parentPage->child_meta) {
                    $meta = $parentPage->child_meta;
                }
            }
        }

        $page_meta_data = array_combine(array_column($pageData['translations'], 'locale'), array_column($pageData['translations'], 'meta_content'));


        if ($parentPage){
            if ($parentPage->type == 'component_group') {
                $meta = $parentPage->child_meta;
            }
        }else{
            $meta = $pageData['meta'];
        }

        foreach ($page_meta_data as $key => $val){
            $page_meta_data[$key] = json_decode($val, true);
        }




        if (!$meta){
            $meta = 'null';
        }


        // fill empty meta data with parent meta data
        if ($meta != 'null'){
            foreach (pageMetaToEmptyData($meta) as $key => $val){
                foreach (activeLangs() as $locale){
                    if (!isset($page_meta_data[$locale][$key])){
                        $page_meta_data[$locale][$key] = $val;
                    }
                }
            }
        }

        $locales = config('translatable.locales');

        if ($page->locales){
            $locales = json_decode($page->locales);
        }

        if ($parentPage){
            if($parentPage->locales){
                $locales = json_decode($parentPage->locales);
            }
        }

        $sections = array();
        $sections = config('constants.page.type.'.$page->type.'.sections');
        if ($parentPage){
            $sections = config('constants.page.type.'.$parentPage->type.'.sub_sections');
        }



        return view('admin.pages.edit',compact('page','pageData','parent_id','parentPage','page_meta_data','meta','sections','locales'));
    }

    public function delete($id){
        $page = Page::find($id);
        foreach ($page->translations as $translation){
            $translation->delete();
        }
        $page->delete();

        //if request is post
        if (isset(request()->isAjax)){
            return response()->json([
                'status' => 'success',
                'message' => 'Sayfa başarıyla silindi'
            ]);
        }
        return redirect()->route('admin.page.index');
    }

    public function update(Request $request)
    {


        $redirectUrl = null;
        $mode = 'edit';
        if ($request->page_id){
            $page = Page::find($request->page_id);
        }else{
            $page = new Page();
            $page->created_at = date('Y-m-d H:i:s');
            $mode = 'create';
        }


        $pageData = $request->page;
        if ($pageData['parent_id'] == '' || $pageData['parent_id'] == null){
            $pageData['parent_id'] = 0;
        }

        $page->fill($pageData);


        foreach($request->locales as $locale){
            $page->translateOrNew($locale)->title = $request->pagetranslations[$locale]['title'];
            $page->translateOrNew($locale)->description = $request->pagetranslations[$locale]['description'];
            $page->translateOrNew($locale)->meta_title = $request->pagetranslations[$locale]['meta_title'] ?? $request->pagetranslations[$locale]['title'];
            $page->translateOrNew($locale)->meta_description =  Str::limit($request->pagetranslations[$locale]['meta_description'],150) ?? descToMetaDesc($request->pagetranslations[$locale]['description']);
            $page->translateOrNew($locale)->status = $request->pagetranslations[$locale]['status'] ?? 0;
            $page->translateOrNew($locale)->summary = $request->pagetranslations[$locale]['summary'] ?? '';
            $page->translateOrNew($locale)->image_id = $request->pagetranslations[$locale]['image_id'] ?? 0;
            $page->translateOrNew($locale)->list_image_id = $request->pagetranslations[$locale]['list_image_id'] ?? 0;
            $page->translateOrNew($locale)->menu_text = $request->pagetranslations[$locale]['menu_text'] ?? 0;
            $page->translateOrNew($locale)->form_id = $request->pagetranslations[$locale]['form_id'] ?? 0;
            $page->translateOrNew($locale)->publish_date = $request->pagetranslations[$locale]['publish_date'] ?? date('Y-m-d H:i:s');
            $page->translateOrNew($locale)->use_custom_slug = $request->pagetranslations[$locale]['use_custom_slug'] ?? 0;
            $page->translateOrNew($locale)->sort_order = 0;
            if(isset($request->data[$locale])){
                $page->translateOrNew($locale)->meta_content = json_encode($request->data[$locale]);
            }
            if(isset($request->pagetranslations[$locale]['gallery'])){
                $page->translateOrNew($locale)->gallery = json_encode($request->pagetranslations[$locale]['gallery']);
            }
            if ($page->translateOrNew($locale)->use_custom_slug){
                $page->translateOrNew($locale)->deep_slug = $request->pagetranslations[$locale]['deep_slug'] ?? '';
            }

        }
        $page->updated_at = date('Y-m-d H:i:s');
        $page->save();

        if ($mode == 'create'){
            $redirectUrl = route('admin.page.edit',$page->id);
        }



        return response()->json([
            'status' => 'success',
            'message' => 'Sayfa başarıyla güncellendi.',
            'redirectUrl' => $redirectUrl,
            'mode' => $mode
        ]);
    }

    public function updateStatus(Request $request){

        $pageTranslation = PageTranslation::findOrFail($request->id);
        if(!$pageTranslation->status){
            if($pageTranslation->title == null){
                //return response()->json(['status' => 'error', 'message' => 'Sayfa başlığı olmayan sayfaları aktif edemezsiniz.']);
            }
        }
        $pageTranslation->status = !$pageTranslation->status;
        $pageTranslation->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sayfa başarıyla güncellendi.'
        ]);
    }

    public function developerSetting($page_id){
        $page = Page::find($page_id);
        return view('admin.pages.developer',compact('page'));
    }

    public function componentList(){
        $components = Page::where('component_only',1)->get();
        return view('admin.pages.components',compact('components'));
    }

    public function clonepage(Request $request){
        $page = Page::find($request->pageid);
        if (!$page){
            return response()->json(['message' => 'Sayfa bulunamadı'], 200);
        }
        $newPage = $page->replicate();
        $newPage->save();

        foreach (activeLangs() as $locale){
            $pageTranslation = $page->translate($locale);
            $newPageTranslation = new PageTranslation();
            $newPageTranslation = $newPage->translate($locale);
            $newPageTranslation->save();
        }

        return response()->json(['message' => 'Sayfa başarıyla kopyalandı'], 200);
    }

    public function updateOrder(Request $request){
        $values = [];
        $ids = [];

        foreach ($request->data as $item) {
            $ids[] = $item['id'];
            $values[] = "WHEN {$item['id']} THEN {$item['sort_order']}";
        }

        $ids = implode(',', $ids);
        $values = implode(' ', $values);

        $query = "UPDATE page_translations
          SET sort_order = (CASE page_id
                            {$values}
                            END)
          WHERE page_id IN ({$ids})";

        DB::statement($query);

        return response()->json([
            'status' => 'success',
            'message' => 'Sıralama başarıyla güncellendi'], 200);
    }
}
