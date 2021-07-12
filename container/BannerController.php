<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public static function banner()
    {
        return view('admin.banner',[
            'data' => Banner::latest()->get()
        ]);
    }

    public static function addBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner' => 'required|image'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $upload_image = $request->file('banner')->store('public/banner');
        $image = explode('/', $upload_image);
        $ban = $image['1'].'/'.$image['2'];

        $banner = Banner::create
        ([
            'image' => $ban,
            'link' => '1'
        ]);

        if($banner == true){
            return response()->json(['status' => '1']);
        }
    }

    public static function viewBanner(Request $request){
        if(!empty($request->id))
        {
            $data = Banner::where(['id' => $request->id])->get();
            foreach($data as $res){
                return response($res);
            }
        }
    }

    public static function editBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner' => 'required|image',
            'id' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $upload_image = $request->file('banner')->store('public/banner');
        $image = explode('/', $upload_image);
        $ban = $image['1'].'/'.$image['2'];

        $banner = Banner::where(['id' => $request->id])->update
        ([
            'image' => $ban,
            'link' => '1'
        ]);

        if($banner == true){
            return response()->json(['status' => '1']);
        }
    }

}
