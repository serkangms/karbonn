<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Vimeo\Laravel\Facades\Vimeo;

class FileController extends Controller
{
    public function __construct()
    {
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '2048M');
        ini_set('post_max_size', '2048M');
        ini_set('upload_max_filesize', '2048M');
        ini_set('max_input_time', 3000);
        ini_set('allow_url_fopen', 1);
    }
    public function getfiles(Request $request)
    {
        $files = Files::orderBy('id', 'desc')->paginate(85);
        foreach ($files as $file){
            $file->thumbnail = $file->resize200;
        }

        if (isset($request->fileType)){
            if($request->fileType == 'video'){
                $files = Files::orderBy('id', 'desc')->where('is_public', 1)->where('mime_type', 'like', 'video%')->paginate(48);
                foreach ($files as $file){
                    $file->thumbnail = url('storage/thumbnail/'.$file->raw_name.'_100x100.'.$file->extension);
                }
            }
        }

        return response()->json($files->items());
    }
    public function uploadfile(Request $request)
    {

        $file = $request->file('file');


        $filename = Str::random(32).'.'.$file->getClientOriginalExtension();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $fileextension = $file->getClientOriginalExtension();
        $fileorginalname = $file->getClientOriginalName();
        $file->move(public_path('storage'), $filename);
        $fileurl = url('storage/'.$filename);


        $file = new Files();
        $file->user_id = Auth::user()->id;
        $file->name = $filename;
        //raw_name no extension
        $file->raw_name = pathinfo($filename, PATHINFO_FILENAME);
        $file->path = 'storage/'.$filename;
        $file->mime_type = $filemime;
        $file->extension = $fileextension;
        $file->size = ($filesize / 1024);
        $file->url = $fileurl;
        $file->orginal_name = $fileorginalname;
        $file->is_public = 1;
        $file->is_image = 0;

        //video *
        if($file->mime_type == 'image/jpeg' || $file->mime_type == 'image/png' || $file->mime_type == 'image/gif' || $file->mime_type == 'image/bmp' || $file->mime_type == 'image/svg+xml' || $file->mime_type == 'image/webp' || $file->mime_type == 'image/tiff' || $file->mime_type == 'image/x-icon' || $file->mime_type == 'image/vnd.microsoft.icon'){
            $file->is_image = 1;
        }

        $file->image_width = 0;
        $file->image_height = 0;
        $file->image_type = 0;
        $file->save();


        $file->thumbnail = $file->resize200;

        return response()->json($file);

    }

    public function downloadfile($fileid)
    {
        $file = Files::where('id', $fileid)->first();
        if(!$file){
            return respose()->json(['error' => 'Dosya bulunamadı.']);
        }
        $file->download = $file->download + 1;
        $file->save();
        $filename = $file->orginal_name;
        return response()->download(public_path($file->path), $filename);
    }

    public function uploadvimeo(Request $request){
        $file = $request->file('file');
        //upload file storage/vimeo
        $filename = Str::random(32).'.'.$file->getClientOriginalExtension();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $fileextension = $file->getClientOriginalExtension();
        $fileorginalname = $file->getClientOriginalName();
        $file->move(public_path('storage/vimeo'), $filename);
        $fileurl = url('storage/vimeo/'.$filename);


        $client = Vimeo::upload(public_path('storage/vimeo/'.$filename), [
            'name' => $filename,
            'description' => 'Uploaded with Laravel',
        ]);



        //get vimeo video id
        $video_id = $client;
        $video_id = explode('/', $video_id);
        $video_id = end($video_id);
        $video_id = explode('.', $video_id);
        $video_id = $video_id[0];

        //get video thumbnail
        $video_thumbnail = Vimeo::request('/videos/'.$video_id, [], 'GET');
        $video_thumbnail = $video_thumbnail['body']['pictures']['sizes'][3]['link'];

        unlink(public_path('storage/vimeo/'.$filename));

        $data['video_id'] = $video_id;
        $data['video_thumbnail'] = $video_thumbnail;
        $data['video_url'] = 'https://vimeo.com/'.$video_id;
        return response()->json($data);





    }
}
