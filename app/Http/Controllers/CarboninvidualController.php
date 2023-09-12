<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\CarbonSubmit;
use App\Models\Cities;
use App\Models\Question;
use App\Models\Questioninput;
use App\Models\User;
use App\Models\UserForm;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class CarboninvidualController extends Controller
{
    public function index()
    {
        $questionInput = Questioninput::all();
        $questions = Question::with('Questioninput')->get();

        $totalQuestions = count($questions);

        $cities = Cities::all();

        return view('theme.page.carbon_invidiual',compact('questions','totalQuestions','questionInput','cities'));

    }
    public function Carboninvidual(Request $request)
    {

        $reqput = array();
        foreach ($request->inputs as $key => $val){
            //if val is empty set 0
            if (empty($val))
                $val = 0;
            $reqput[$key] = $val;
        }




        $UserForm = new UserForm();
        $UserForm->user_name = $request->user_name;
        $UserForm->user_mail = $request->user_mail;
        $UserForm->user_job = $request->user_job;
        $UserForm->save();

        $question= Question::all()->first();
        $carbonSubmit = new CarbonSubmit();
        $carbonSubmit->ip_address = $request->ip();
        $carbonSubmit->type = 'invidual';
        $carbonSubmit->created_at = date('Y-m-d H:i:s');
        $carbonSubmit->user_form_id = $UserForm->id;
        $carbonSubmit->user_name = $request->user_name;

        $carbonSubmit->save();




        foreach ($request->input as $questID => $qinputID) {
            if (!empty($qinputID)) {
                $answer = new Answer();
                $answer->question_inputs_id = $qinputID;
                $answer->question_id = $questID;
                $answer->quantity = Questioninput::where('id',$qinputID)->first()->quantity;
                $answer->created_at = date('Y-m-d H:i:s');
                $answer->carbon_submit_id = $carbonSubmit->id;
                $answer->save();
            }
        }

        foreach ($reqput as $inputId => $inputValue) {
            $questionInput = Questioninput::where('id',$inputId)->first();
            if (isset($inputValue)) {
                $answer = new Answer();
                $answer->question_inputs_id = $inputId;
                $answer->question_id = Questioninput::where('id',$inputId)->first()->question_id;
                $answer->quantity = $inputValue;
                $answer->created_at = date('Y-m-d H:i:s');

                $answer->carbon_submit_id = $carbonSubmit->id;


                if ($questionInput && is_numeric($inputValue)) {
                    $answer->quantity = (($inputValue) * priceToFloat($questionInput->quantity));
                    $answer->save();
                }
            }
        }



        $this->calcSubTotal($carbonSubmit->id);


        return redirect()->to('karbon-rapor-bireysel');

    }

    public function calcSubTotal($submitid){
        $carbonSubmit = CarbonSubmit::find($submitid);

        $sections = array();
        foreach ($carbonSubmit->answer as $item){
            $sections[$item->Question->section] = array();
        }


        foreach ($sections as $section => $value){
            $ansers = Answer::whereHas('Question', function ($query) use ($section) {
                $query->where('section', $section);
            })->where('carbon_submit_id',$submitid)->get();
            //set sub total
            $subTotal = 0;

            $i = 1;
            foreach ($ansers as $anser){
                if ($anser->Question->opr == 'inner')
                    $subTotal += $anser->quantity;
                else
                    $subTotal -= $anser->quantity;

                $sections[$section][$i] = $anser->quantity;
                $i++;
            }

            $sections[$section]['subTotal'] = $subTotal;

        }

        $sections['consumption']['calc'] =
            (
                $sections['consumption']['1'] +
                $sections['consumption']['2'] +
                $sections['consumption']['3'] +
                $sections['consumption']['4'] +
                $sections['consumption']['5'] +
                $sections['consumption']['6']
            ) * 12;
        $carbonSubmit->consumption_total =  $sections['consumption']['calc'];

        $sections['home']['calc'] =
            (
                $sections['home']['1'] *
                $sections['home']['2']
            ) /  $sections['home']['3'];
        $carbonSubmit->home_total =  $sections['home']['calc'];
        $sections['trans']['calc'] =
            (
                ( $sections['trans']['1'] *  $sections['trans']['2']) +
                ($sections['trans']['3']) + ( $sections['trans']['4'])
            ) * 12;
        $carbonSubmit->transport_total =  $sections['trans']['calc'];


        $sections['habit']['calc'] =
            (
                $sections['habit']['1'] +
                $sections['habit']['2'] -
                $sections['habit']['3'] +
                $sections['habit']['4']
            );
        $carbonSubmit->habit_total = $sections['habit']['calc'];


        $carbonSubmit->total = array_sum(array_column($sections, 'calc'));
        $carbonSubmit->total;
        $sections = json_encode($sections);
        $carbonSubmit->sub_totals = $sections;
        $carbonSubmit->save();


    }
    public function CarbonReport()
    {
        $userForm = UserForm::all()->last(); // Son formun kendisini alıyoruz

        if ($userForm) {
            $carbon = CarbonSubmit::where('user_form_id', $userForm->id)->first(); // İlgili kaydı alıyoruz

            if ($carbon) {
                $total = $carbon->total; // Kullanıcının total değeri
            } else {
                $total = 0;
            }
        } else {
            $total = 0;
        }

        return view('theme.page.carbon_report',compact('total'));
    }
    public function CertificatePdf()
    {
        $userForm = UserForm::all()->last(); // Son formun kendisini alıyoruz

        if ($userForm) {
            $carbon = CarbonSubmit::where('user_form_id', $userForm->id)->first(); // İlgili kaydı alıyoruz

            if ($carbon) {
                $UserName = $carbon->user_name;
                $created_at = $carbon->created_at;
                $total = $carbon->total; // Kullanıcının total değeri

            }
        }
        $logoPath = public_path('assets/img/logo4.png');
        $logo = public_path('assets/img/logo5.png');

        $carbons = public_path('assets/img/carbon.svg');

        $pdf = \PDF::loadView('theme.page.certificate',compact('UserName','created_at','logoPath','carbons','total','logo'));
        return $pdf->download('pdf.pdf', [
            'Content-Type' => 'application/pdf;charset=UTF-8',
        ]);    }
}
