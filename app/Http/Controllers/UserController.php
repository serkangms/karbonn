<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Complain;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::where('id', '!=', Auth::user()->id)->get();
        $userComplains = Complain::where('user_id', Auth::user()->id)->get();
        return view('theme.page.user_complains', compact('user', 'userComplains'));
    }

    public function destroy(Complain $usercomplain, Request $request)
    {
        $usercomplain->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Complaint deleted successfully.']);
        }

        return redirect()->back()->with('success', 'Complaint deleted successfully.');
    }

    public function delete(user $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Kullanıcı başarıyla silindi.');

    }
    public function settings()
    {
        $users = Auth::user();
        $name = $users->name;
        $initial = strtoupper(substr($name, 0, 1));
        return view('theme.page.user_settings', compact('users', 'initial'));

    }
    public function update(Request $request, $id)
    {



        $user = User::find($id);
        if ($user) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->address = $request->input('address');

            if ($request->hasFile('profile_photo')) {
                $fileController = new FileController();

                $mewRequest = new Request();
                $mewRequest->setMethod('POST');
                $mewRequest->files->add(['file' => $request->file('profile_photo')]);


                $file = $fileController->uploadfile($mewRequest);
                $file = json_decode($file->getContent());
                $user->image_id = $file->id;
            }

            if (isset($request->images)){
                foreach ($request->images as $image){
                    $upimage = new UserImage();
                    $upimage->user_id = $user->id;
                    $upimage->image_id = $image;
                    $upimage->save();
                }
            }
            $user->save();
            return redirect('/UserSettings')->with('success', 'Kullanıcı ayarları başarıyla güncellendi.');
        } else {
            return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');
        }
    }
    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Kullanıcı bulunamadı.');
        }

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()->back()->with('error', 'Mevcut şifrenizi yanlış girdiniz.');
            }
        }
        $user->save();

        return redirect('/UserSettings')->with('success', 'Şifre başarıyla güncellendi.');
    }


}
