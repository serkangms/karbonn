<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Complain;
use App\Models\ComplainImage;
use App\Models\ComplainVideo;
use App\Models\Council;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class ComplainController extends Controller
{
    public function index()
    {

        $user = auth()->user();
        $userRole = $user->determineRole();
        $Complain = new LengthAwarePaginator([], 0, 48);

        if ($userRole === User::ROLE_ADMIN) {
            $Complain = Complain::orderBy('id', 'desc')->paginate(48);
        } elseif ($userRole === User::ROLE_EDITOR) {
            $Complain = Complain::orderBy('id', 'desc')->paginate(48);
        } elseif ($userRole === User::ROLE_REGULAR) {
            $Complain = Complain::where('council_id', '=', $user->council_id)->orderBy('id', 'desc')->paginate(48);
        }

        return view('admin.Complain.index', compact('Complain', 'userRole', 'user'));
    }
    public function detail($id)
    {
        $Complain = new Complain();
        $Complain = $Complain->orderBy('id', 'desc')->paginate(48);
        $Complains= Complain::find($id);

        return view('admin.Complain.detail', compact('Complain', 'Complains'));
    }
    public function edit($id)
    {
        $Complain = new Complain();
        $Complains = Complain::where('id','=',$id)->first();
        $Complainss = Complain::all();
        $cities= Cities::all();
        $states= State::all();
        $council= Council::all();
        return view('admin.Complain.edit', compact('Complain', 'Complains', 'Complainss', 'cities', 'states', 'council'));
    }
    public function create()
    {
        $Complain = new Complain();
        $Complain = Complain::all();
        $cities= Cities::all();
        $states= State::all();
        $council= Council::all();
        return view('admin.Complain.create', compact('Complain', 'cities', 'states', 'council'));
    }
    public function replay($id)
    {
        $Complain = new Complain();
        $Complains = Complain::where('id','=',$id)->first();
        return view('admin.Complain.replay', compact('Complains',  'Complain'));
    }
    public function replayPost(Request $request)
    {
        $Complains = Complain::find($request->input('id'));
        if ($Complains) {
            $Complains->replay = $request->input('replay');
            $Complains->timestamps = false;
            $Complains->reply_at = now();
            $Complains->save();
        }

        return redirect('/admin/Complain/detail/'.$request->input('id'));
    }
    public function delete($id)
    {
        $Complain = Complain::find($id);
        $Complain->delete();

        // Flash a success message to the session
        session()->flash('success', 'Şikayet başarıyla silindi.');

        return redirect('/admin/Complain/index');
    }
    public function removeImage($id)
    {
        // Find the image in the database by its ID
        $image = ComplainImage::find($id);

        if (!$image) {
            // Image not found, return a response indicating the failure
            return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
        }

        // Delete the image from the storage
        Storage::delete($image->path);

        // Delete the image record from the database
        $image->delete();

        // Return a response indicating the success
        return response()->json(['success' => true]);
    }

    public function update(Request $request,$id)
    {

        $Complains = Complain::find($id);
        $Complains->update([
            'title' => $request->title,
            'council_id' => $request->council_id,
            'description' => $request->description,
            'city_id' => $request->city_id,
            'state_id' => $request->state_id,
            'image' => $request->image,
            'video' => $request->video,
            'updated_at' => $request->updated_at,
        ]);

        $onComplainsImages = ComplainImage::where('complain_id', $id)->get();
        $onComplainsVideos = ComplainVideo::where('complain_id', $id)->get();

        $onComplainsImagesIds = $onComplainsImages->pluck('id')->toArray();
        $onComplainsVideosIds = $onComplainsVideos->pluck('id')->toArray();

        $postremovedComplainsImagesIds = $request->input('images', []);
        $postremovedComplainsVideosIds = $request->input('videos', []);

        $fooImages = [];
        foreach ($postremovedComplainsImagesIds as $item){
            $baid = null;
            if ($baid = ComplainImage::where('complain_id', $id)->where('image_id', $item)->first()){
                $fooImages[] = $baid->id;
            }
           $fooImages[] = ComplainImage::where('complain_id', $id)->where('image_id', $item)->first()->id;
        }


        $removedComplainsImagesIds = array_diff($onComplainsImagesIds, $fooImages);
        $removedComplainsVideosIds = array_diff($onComplainsVideosIds, $postremovedComplainsVideosIds);


        if (count($removedComplainsImagesIds)){
            foreach ($removedComplainsImagesIds as $removedComplainsImagesId) {
                $image = ComplainImage::find($removedComplainsImagesId);
                if ($image) {
                    $image->delete();
                }
            }
        }

        if (count($removedComplainsVideosIds)){
            foreach ($removedComplainsVideosIds as $removedComplainsVideosId) {
                $video = ComplainVideo::find($removedComplainsVideosId);
                if ($video) {
                    $video->delete();
                }
            }
        }


        $Complains->save();

        return redirect('/admin/Complain/edit/'.$id);
    }
    public function upload($id)
    {
        $complain = Complain::find($id);

        if (!$complain) {
            return redirect()->route('admin.Complain.index')->with('error', 'Complaint not found.');
        }

        // Check the current status of the complain
        if ($complain->status == 0) {
            // If the complain is not published, set its status to 1 (published)
            $complain->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Şikayet başarıyla yayına alındı.');
        } else {
            // If the complain is already published, set its status to 0 (unpublished)
            $complain->update([
                'status' => 0,
            ]);
            session()->flash('success', 'Şikayet başarıyla yayından kaldırıldı.');
        }

        return redirect()->route('admin.Complain.index');
    }
}
