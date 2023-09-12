<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Complain;
use App\Models\ComplainImage;
use App\Models\Council;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use DateTime;

class CouncilController extends Controller
{
    public function index()
    {

        $cities = Cities::all();

        $council = new Council();
        $query = $council->newQuery();

        if (request()->has('city_id')) {
            if (request('city_id') != '') {
                $query->where('city_id', request('city_id'));
            }
        }

        if (request()->has('name')) {
            if (request('name') != '') {
                $query->where('name', 'like', '%' . request('name') . '%');
            }
        }

        if (request()->has('email')) {
            if (request('email') != '') {
                $query->where('email', 'like', '%' . request('email') . '%');
            }
        }

        $council = $query->paginate(25);

        return view('admin.Council.index', compact('council', 'cities'));
    }
    public function detail($id)
    {
        $council = Council::where('id', '=', $id)->first();
        return view('admin.Council.detail', compact('council'));
    }
    public function edit($id)
    {
        $council = Council::where('id', '=', $id)->first();
        return view('admin.Council.edit', compact('council'));
    }
    public function update(Request $request)
    {
        $council = Council::find($request->input('id'));
        if ($council) {
            $council->name = $request->input('name');
            $council->website = $request->input('website');
            $council->email = $request->input('email');
            $council->phone = $request->input('phone');
            $council->address = $request->input('address');
            $council->logo_id = $request->input('logo_id');
            $council->timestamps = false;
            $council->save();

        }

        return redirect('/admin/Council/index');
    }



    public function create()
    {
        $council = new Council();

        return view('admin.Council.create', compact('council'));
    }
    public function CouncilReport()
    {
        $user = auth()->user();
        $council = $user->council;
        $complain = $council->complain;
        $complains= Complain::all();
        return view('admin.Council.report', compact('council', 'complain','complains'));
    }

    public function store(Request $request)
    {
        $council = new Council();
        $council->name = $request->input('name');
        $council->website = $request->input('website');
        $council->email = $request->input('email');
        $council->phone = $request->input('phone');
        $council->address = $request->input('address');
        $council->logo_id = $request->input('logo_id');
        $council->slug = $request->input('slug');

        $council->timestamps = false;
        $council->save();

        $cityName = $request->input('city_id');

        $city = Cities::where('name', $cityName)->first();

        if (!$city) {
            $city = new Cities(['name' => $cityName]);
            $city->save();
        }

        $council->city()->associate($city);

        $council->save();
        return redirect('/admin/Council/index');
    }
    public function delete(Request $request)
    {
        $council = Council::find($request->input('id'));
        if ($council) {
            $council->delete();
        }
        return redirect('/admin/Council/index');
    }

}
