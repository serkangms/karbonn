<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Council;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::where('id', '!=', 2)->get();
        return view('admin.user.index', compact('users'));
    }

    public function edit($id){
        $user = User::find($id);

        return view('admin.user.edit', compact('user'));
    }

    public function create(){
        $user = User::all();;
        return view('admin.user.create', compact('user'));
    }

    public function store(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->image_id = $request->input('image_id');

        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->back()->with('success', 'Kullanıcı oluşturuldu');
    }

    public function update(Request $request){

        $user = User::find($request->id);

        if (!$user){
            abort(404);
        }

        $user->fill($request->all());
        $user->save();

        return redirect()->back()->with('success', 'Kullanıcı güncellendi');
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Kullanıcı silindi');
    }



    public function updatePW(Request $request,$user_id){
        $user = User::find($user_id);

        $onPw = $request->old_password;
        if (password_verify($onPw, $user->password)){

            if ($request->password != $request->password_confirmation){
                return redirect()->back()->with('error', 'Şifreler uyuşmuyor');
            }

            $user->update([
                'password' => bcrypt($request->password)
            ]);

            return redirect()->back()->with('success', 'Şifre değiştirildi');

        }else{
            return redirect()->back()->with('error', 'Eski şifre yanlış');
        }

    }
}
