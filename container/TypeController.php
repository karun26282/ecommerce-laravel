<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class TypeController extends Controller
{
    public static function index()
    {
        return view('admin.type', [
            'data' => Type::with('sub_category')->get(),
            'sub_category' => SubCategory::with('category')->get()
        ]);
    }

    public static function add_type(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_cat_id' => 'required|numeric',
            'type' => 'required|regex:/^[\pL\s\-]+$/u',
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}

       $create = Type::create
       ([
            'sub_cat_id' => $request->sub_cat_id,
            'type' => $request->type,
            'slug' =>   SlugService::createSlug(Type::class, 'slug', $request->type),
       ]);

        if($create == true){
            return response()->json(['status'=>'1']);
        }

    }

    public static function veiw_type(Request $request)
    {
        if(!empty($request->id)){
            $data = Type::where(['id' => $request->id])->get();
            foreach($data as $res){
                return response($res);
            }

        }
    }

    public static function edit_type(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_cat_id' => 'required|numeric',
            'type' => 'required|regex:/^[\pL\s\-]+$/u',
            'id' => 'required|numeric'
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}
        $update = Type::where(['id'=> $request->id])->update
        ([
            'sub_cat_id' => $request->sub_cat_id,
            'type' => $request->type,
            'slug' =>   SlugService::createSlug(Type::class, 'slug', $request->type),
        ]);

        if($update == true){
            return response()->json(['status'=>'1']);
        }
    }

    public static function delete_type(Request $request)
    {
        if(!empty($request->id)){
            $delete = Type::where(['id' => $request->id])->delete();

            if($delete == true){
                return response()->json(['status'=>'1']);
            }
        }
    }
}
