<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return view('admin.forms.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.forms.create');
    }

    public function edit($id)
    {
        $form = Form::find($id);
        return view('admin.forms.create', compact('form'));
    }

    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'fields' => 'required|array',
            'name' => 'required|string',
            'form.description' => 'nullable|string',
            'form.image_id' => 'nullable|integer',
            'form.max_submit' => 'nullable|integer',
        ], [
            'fields.required' => 'Lütfen form alanlarını doldurunuz.',
            'fields.array' => 'Lütfen form alanlarını doldurunuz.',
            'name.required' => 'Lütfen form adını doldurunuz.',
            'name.string' => 'Lütfen form adını doldurunuz.',
            'form.description.string' => 'Lütfen form açıklamasını doldurunuz.',
            'form.image_id.integer' => 'Lütfen form görselini doldurunuz.',
            'form.max_submit.integer' => 'Lütfen form maksimum gönderim sayısını doldurunuz.',
        ])->validate();



        $meta = $request->fields;
        $meta = json_encode($meta, JSON_UNESCAPED_UNICODE);


        $form = new Form();
        if ($request->form['id'] ?? null) {
            $form = $form->find($request->form['id']);
        }
        $form->name = $request->form['name'] ?? null;
        $form->description = $request->form['description'];
        $form->image_id = $request->form['image_id'] ?? null;
        $form->max_submit = $request->form['max_submit'];
        $form->locale =  $request->form['locale'] ?? 'tr';
        $form->meta = $meta;
        $form->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Form başarıyla oluşturuldu.',
            'redirect' => route('admin.form.index')
        ]);
    }

    public function delete($id)
    {
        $form = Form::find($id);
        $form->delete();
        return redirect()->route('admin.form.index');
    }

    public function submissions($formid){
        $sumissions = FormSubmit::where('form_id',$formid)->orderBy('id','desc')->get();
        return view('admin.forms.submissions',compact('sumissions'));
    }

    public function submission($id){
        $submission = FormSubmit::find($id);
        return view('admin.forms.submission',compact('submission'));
    }

    public function submissionDelete($id){
        $submission = FormSubmit::find($id);
        $formid = $submission->form_id;
        $submission->delete();
        return redirect()->route('admin.form.submissions',$formid);
    }
}
