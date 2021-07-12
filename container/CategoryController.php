<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryController extends Controller
{
    public static function index()
    {
        return view('admin.category', [
            'data' => Category::latest()->get()
        ]);
    }

    public static function add_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|max:20|regex:/^[\pL\s\-]+$/u',
            'image' => 'required|image'
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}

        $image = $request->file('image')->store('public/category');
        $eq = explode('/', $image);
        $img = $eq[1].'/'.$eq['2'];

       $create = Category::create
       ([
           'category' => $request->category,
           'image' =>  $img
       ]);

        if($create == true){
            return response()->json(['status'=>'1']);
        }

    }

    public static function veiw_category(Request $request)
    {
        if(!empty($request->id)){
            $data = Category::where(['id' => $request->id])->get();
            foreach($data as $res){
                return response($res);
            }

        }
    }

    public static function edit_category(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|max:20|regex:/^[\pL\s\-]+$/u',
            'id' => 'required|numeric'
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}
        if(!empty($request->image)){
            $image = $request->file('image')->store('public/category');
            $eq = explode('/', $image);
            $img = $eq[1].'/'.$eq['2'];

            $update = Category::where(['id'=> $request->id])->update
            ([
                'category' => $request->category,
                'slug' => SlugService::createSlug(Category::class, 'slug', $request->category),
                'image' =>  $img
            ]);

            if($update == true){
                return response()->json(['status'=>'1']);
            }
        }else{
            $update = Category::where(['id'=> $request->id])->update
            ([
                'category' => $request->category,
                'slug' =>   SlugService::createSlug(Category::class, 'slug', $request->category),
            ]);

            if($update == true){
                return response()->json(['status'=>'1']);
            }
        }
    }

    public static function deleteCategory(Request $request)
    {
        if(!empty($request->id)){
            $delete = Category::where(['id' => $request->id])->delete();

            if($delete == true){
                return response()->json(['status'=>'1']);
            }
        }
    }

}
