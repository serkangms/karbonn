<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email_or_phone' => [
                Rule::exists('users')->where(function ($query) use ($request) {
                    return $query->where('email', $request->input('email_or_phone'))
                        ->orWhere('phone', $request->input('email_or_phone'));
                }),
            ],
            'password' => ['required', 'string'],
        ], [
            'email_or_phone.exists' => 'Girilen E-posta veya Telefon kayıtlı değil veya geçerli değil.',
            'password.required' => 'Lütfen şifrenizi girin.',
        ]);
    }
    protected function credentials(Request $request)
    {
        $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return [
            $field => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }
    public function redirectTo()
    {
        return 'admin/panel';
    }
}
