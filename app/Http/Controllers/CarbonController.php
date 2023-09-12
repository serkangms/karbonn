<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\CarbonSubmit;
use App\Models\Question;
use App\Models\Questioninput;
use App\Models\UserForm;
use Illuminate\Http\Request;
use Dompdf\Dompdf;


class CarbonController extends Controller
{
    public function index()
    {
        $questionInput = Questioninput::all();
        $questions = Question::with('Questioninput')->get();

        $totalQuestions = count($questions);

        return view('theme.page.carbon',compact('questions','totalQuestions','questionInput'));

    }

    public function SubmitForm(Request $request)
    {
        $UserForm = new UserForm();
        $UserForm->user_name = $request->user_name;
        $UserForm->user_mail = $request->user_email;
        $UserForm->state = $request->state;
        $UserForm->save();
        $question= Question::all()->first();
        $carbon = new CarbonSubmit();
        $carbon->ip_address = $request->ip();
        $carbon->type = $question->type;
        $carbon->created_at = date('Y-m-d H:i:s');
        $carbon->user_form_id = $UserForm->id;
        $carbon->save();
        $carbonSubmit = CarbonSubmit::find($carbon->id);
        $innerTotalSum = 0;
        $outerTotalSum = 0;
        foreach ($request->inputs as $inputId => $inputValue) {

            if (!empty($inputValue)) {
                $answer = new Answer();
                $answer->question_inputs_id = $inputId;
                $answer->question_id = Questioninput::where('id',$inputId)->first()->question_id;
                $answer->quantity = $inputValue;
                $answer->created_at = date('Y-m-d H:i:s');

                $answer->carbon_submit_id = $carbon->id;

                $questionInput = new Questioninput();
                $questionInput = $questionInput->where('id',$inputId)->first();
                echo $questionInput->quantity."<br>";

                if ($questionInput && is_numeric($inputValue) && is_numeric($questionInput->quantity)) {

                    if ($questionInput->type == 'inner') {
                        $carbonSubmit->inner_total = $inputValue * floatval($questionInput->quantity);
                        $innerTotalSum += $inputValue * floatval($questionInput->quantity);

                    } else {
                        $carbonSubmit->outer_total = $inputValue * floatval($questionInput->quantity);
                        $outerTotalSum += $inputValue * floatval($questionInput->quantity);

                    }

                    $total = $innerTotalSum - $outerTotalSum;
                    $carbonSubmit->total = $total;
                    $carbonSubmit->save();
                    $answer->save();
                }
            }
        }
        return redirect()->to('karbon-rapor-kurumsal');

    }
    public function generatePdf()
    {
        $CarbonSubmit = UserForm::all()->last();
        $UserName = '';
        $total = 0;

        if ($CarbonSubmit) {
            $carbon = CarbonSubmit::where('user_form_id', $CarbonSubmit->id)->first();

            if ($carbon) {
                $UserName = $carbon->user_name;
                $total = $carbon->total;
                $outertotal = $carbon->outer_total;
                $roundedTotal = ceil(abs($total) / 300);
            }
        }


        $pdf = \PDF::loadView('theme.page.pdf', compact('UserName', 'total','outertotal','roundedTotal')); // Değişkenleri compact fonksiyonu ile aktarıyoruz
        return $pdf->download('pdf.pdf', [
            'Content-Type' => 'application/pdf;charset=UTF-8',
        ]);    }

    public function CarbonReports()
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

        return redirect()->to('karbon-rapor-bireysel',compact('total'));
    }
}
