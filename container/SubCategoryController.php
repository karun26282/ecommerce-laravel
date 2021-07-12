<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class SubCategoryController extends Controller
{
    public static function index()
    {
        $data = SubCategory::with('category')->get();
        return view('admin.sub-category', [
            'data' => $data,
            'category' => Category::all()
        ]);
    }

    public static function add_sub_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|numeric',
            'sub_category' => 'required|regex:/^[\pL\s\-]+$/u',
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}

       $create = SubCategory::create
       ([
           'cat_id' => $request->category,
           'sub_category' => $request->sub_category,
           'slug' =>   SlugService::createSlug(Category::class, 'slug', $request->sub_category),
       ]);

        if($create == true){
            return response()->json(['status'=>'1']);
        }

    }

    public static function veiw_sub_category(Request $request)
    {
        if(!empty($request->id)){
            $data = SubCategory::where(['id' => $request->id])->get();
            foreach($data as $res){
                return response($res);
            }

        }
    }

    public static function edit_sub_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|numeric',
            'sub_category' => 'required|regex:/^[\pL\s\-]+$/u',
            'id' => 'required|numeric'
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}
        $update = SubCategory::where(['id'=> $request->id])->update
        ([
            'cat_id' => $request->category,
            'sub_category' => $request->sub_category,
            'slug' =>   SlugService::createSlug(Category::class, 'slug', $request->sub_category),
        ]);

        if($update == true){
            return response()->json(['status'=>'1']);
        }
    }

    public static function delete_sub_category(Request $request)
    {
        if(!empty($request->id)){
            $delete = SubCategory::where(['id' => $request->id])->delete();

            if($delete == true){
                return response()->json(['status'=>'1']);
            }
        }
    }
}
