<?php

namespace App\Http\Controllers;

use App\Models\MainCategory;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class MainCategoryController extends Controller
{
    public static function index()
    {
        return view('admin.main-category', [
            'data' => MainCategory::with('type')->get(),
            'type' => Type::with('sub_category')->get()
        ]);
    }

    public static function add_main_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|numeric',
            'main_category' => 'required|regex:/^[\pL\s\-]+$/u',
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}

       $create = MainCategory::create
       ([
            'type_id' => $request->type_id,
            'main_category' => $request->main_category,
            'slug' =>   SlugService::createSlug(MainCategory::class, 'slug', $request->main_category),
       ]);

        if($create == true){
            return response()->json(['status'=>'1']);
        }

    }

    public static function veiw_main_category(Request $request)
    {
        if(!empty($request->id)){
            $data = MainCategory::where(['id' => $request->id])->get();
            foreach($data as $res){
                return response($res);
            }

        }
    }

    public static function edit_main_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|numeric',
            'main_category' => 'required|regex:/^[\pL\s\-]+$/u',
            'id' => 'required|numeric'
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}
        $update = MainCategory::where(['id'=> $request->id])->update
        ([
            'type_id' => $request->type_id,
            'main_category' => $request->main_category,
            'slug' =>   SlugService::createSlug(MainCategory::class, 'slug', $request->main_category),
        ]);

        if($update == true){
            return response()->json(['status'=>'1']);
        }
    }

    public static function delete_main_category(Request $request)
    {
        if(!empty($request->id)){
            $delete = MainCategory::where(['id' => $request->id])->delete();

            if($delete == true){
                return response()->json(['status'=>'1']);
            }
        }
    }
}
