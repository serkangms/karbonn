<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormController extends Controller
{
    public function submit(Request $request,$id){
        $form = new Form();
        $form = $form->find($id);


        if(!$form){
            return redirect()->back()->withErrors(['Form bulunamadı.']);
        }

        $page = $request->page;
        if (!$page) {
            abort(404);
        }

        //unset token and page
        $request->request->remove('_token');
        $request->request->remove('page');

        $fileds = $form->fields;
        $names = [];
        foreach ($fileds as $key => $value) {
            $names[] = Str::slug($value->name,'').'_'.$key;
        }


        if(count($names) != count($request->all())){
            return redirect()->back()->withErrors(['Form alanları eksik.']);
        }

        foreach ($names as $key => $value) {
            if(!isset($request->{$value})){
                return redirect()->back()->withErrors(['Form alanları eksik.']);
            }
        }

        $names = array_flip($names);

        $answers = [];
        foreach ($fileds as  $key => $item){
            if ($item->type == 'file'){
                $file = $request->file(Str::slug($item->name,'').'_'.$key);
                $orginalName = $file->getClientOriginalName();
                $filename = Str::random(32).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('storage/form_submits/'), $filename);
                $answers[$item->name] = ['type' => 'file', 'val' =>$filename, 'orginalName' => $orginalName];
            }else{
                $answers[$item->name] = ['type' => 'text', 'val' => $request->{Str::slug($item->name,'').'_'.$key}];
            }
        }

        $formSubmit = new FormSubmit();
        $formSubmit->form_id = $form->id;
        $formSubmit->ip_address = request()->ip();
        $formSubmit->answers = json_encode($answers);
        $formSubmit->save();

        return redirect()->back()->with('success','Form başarıyla gönderildi.');

    }
}
