<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{

    public static function index()
    {
        return view('admin.brand', [
            'data' =>DB::table('brands')
                        ->leftjoin('main_categories', 'brands.main_category_id', '=', 'main_categories.id')
                        ->leftjoin('types', 'main_categories.type_id', '=', 'types.id')
                        ->leftjoin('sub_categories', 'types.sub_cat_id', '=', 'sub_categories.id')
                        ->leftjoin('categories', 'sub_categories.cat_id', '=', 'categories.id')
                        ->get(),
            'main_category' => MainCategory::with('type')->get()
        ]);
    }

    public static function add_brand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_category_id' => 'required|numeric',
            'brand' => 'required|regex:/^[\pL\s\-]+$/u',
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}

       $create = Brand::create
       ([
            'main_category_id' => $request->main_category_id,
            'brand' => $request->brand,
            'slug' =>   SlugService::createSlug(Brand::class, 'slug', $request->brand),
       ]);

        if($create == true){
            return response()->json(['status'=>'1']);
        }

    }

    public static function veiw_brand(Request $request)
    {
        if(!empty($request->id)){
            $data = Brand::where(['id' => $request->id])->get();
            foreach($data as $res){
                return response($res);
            }

        }
    }

    public static function edit_brand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'main_category_id' => 'required|numeric',
            'brand' => 'required|regex:/^[\pL\s\-]+$/u',
            'id' => 'required|numeric'
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}
        $update = Brand::where(['id'=> $request->id])->update
        ([
            'main_category_id' => $request->main_category_id,
            'brand' => $request->brand,
            'slug' =>   SlugService::createSlug(Brand::class, 'slug', $request->brand),
        ]);

        if($update == true){
            return response()->json(['status'=>'1']);
        }
    }

    public static function delete_brand(Request $request)
    {
        if(!empty($request->id)){
            $delete = Brand::where(['id' => $request->id])->delete();

            if($delete == true){
                return response()->json(['status'=>'1']);
            }
        }
    }

}
