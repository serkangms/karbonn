<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        return view('admin.panel');
    }

    public function blank()
    {
        return view('admin.blank');
    }

    public function search(Request $request){
        $reslut = array();
        $pages = Page::whereTranslationLike('title', '%'.$request->val.'%')->get();

        $reslut['pages'] = $pages;
        return view('admin.partials.component.search_item', compact('reslut'));
    }
}
