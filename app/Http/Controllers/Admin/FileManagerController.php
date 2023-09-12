<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileManagerController extends Controller
{
    public function index()
    {
        $files = new Files();
        $files = $files->orderBy('id', 'desc')->paginate(48);
        return view('admin.filemanager.index', compact('files'));
    }

    public function update(Request $request){
        //validate return json
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'required',
        ], [
            'id.required' => 'ID gereklidir',
            'id.integer' => 'ID sayı olmalıdır',
            'name.required' => 'Dosya adı gereklidir',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['errors' => $errors], 400);
        }

        $file = Files::find($request->id);
        if (!$file){
            return response()->json(['errors' => ['id' => 'Dosya bulunamadı']], 400);
        }

        $file->orginal_name = $request->name;
        $file->save();

        return response()->json(['success' => 'Dosya adı güncellendi'], 200);

    }
}
