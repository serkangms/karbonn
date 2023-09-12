<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use App\Models\NavigationItem;
use App\Models\PageTranslation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index(){
        $navigations = Navigation::all();
        return view('admin.navigation.index', compact('navigations'));
    }

    public function edit($id,$locale = null){
        if (!$locale){
            $locale = app()->getLocale();
        }
        $navigation = Navigation::findOrFail($id);
        $map = $navigation->itemsRecursive($locale)->get();


        return view('admin.navigation.edit', compact('navigation', 'map','locale'));
    }

    public function store(Request $request){
        $navitem = new NavigationItem();


        if ($request->sort_order == null){
            if ($request->parent_id != null){
                $sibligscount = NavigationItem::where('navigation_id', $request->navigation_id)->where('parent_id', $request->parent_id)->count();
            }else{
                $sibligscount = NavigationItem::where('navigation_id', $request->navigation_id)->whereNull('parent_id')->count();
            }
            $order = $sibligscount + 1;
            $order = $order * 10;
            $request->merge(['sort_order' => $order]);
        }


        $navitem->fill($request->all());
        $navitem->save();

        cache()->tags(['nav'])->flush();

        return redirect()->route('admin.navigation.edit',$request->navigation_id)->with('success', 'Menü eklendi');
    }

    public function update(Request $request){

        if ($request->parent_id == $request->id){
            return redirect()->back()->with('error', 'Ebeveyn kimliği, kimlikle aynı olamaz');
        }

        $navitem = NavigationItem::findOrFail($request->id);
        $navitem->fill($request->all());
        $navitem->save();

        cache()->tags(['nav'])->flush();

        return redirect()->back()->with('success', 'Menü güncellendi');
    }

    public function getPageList(){
        $searchTerm = request()->input('searchTerm');
        $PageTranslation = PageTranslation::where('title', 'LIKE', "%{$searchTerm}%")->get();
        //return text & id
        $data = [];
        foreach ($PageTranslation as $key => $value) {
            $data[] = ['id' => $value->id, 'text' => $value->title];
        }
        return response()->json($data);
    }

    public function delete($id){
        $navitem = NavigationItem::findOrFail($id);

        foreach ($navitem->childrenRecursive as $key => $value) {
            $value->delete();
        }

        $navitem->delete();

        cache()->tags(['nav'])->flush();

        return redirect()->back()->with('success', 'Menü silindi');
    }
}
