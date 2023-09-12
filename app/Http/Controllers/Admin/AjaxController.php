<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Council;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getCityToCouncil(Request $request){
        $council = Council::where('city_id', $request->id)->get();
        return response()->json($council);
    }
}
