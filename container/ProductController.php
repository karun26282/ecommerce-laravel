<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\product;
use App\Models\SubCategory;
use App\Models\Type;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public static function index()
    {
        return view('admin.product',[
            'data' => Product::all(),
            'category' => Category::all(),
            'sub_category' => SubCategory::all(),
            'type' => Type::all(),
            'main_category' => MainCategory::all(),
            'brand' => Brand::all()
        ]);
    }

    public static function getSubCat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $data = SubCategory::where(['cat_id' => $request->id])->get();

        return response($data);
    }

    public static function getType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $data = Type::where(['sub_cat_id' => $request->id])->get();

        return response($data);
    }

    public static function getMainCat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $data = MainCategory::where(['type_id' => $request->id])->get();

        return response($data);
    }

    public static function getBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        }

        $data = Brand::where(['main_category_id' => $request->id])->get();

        return response($data);
    }

    public static function addProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required|numeric',
            'sub_cat_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'main_cat_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'title' => 'required',
            'sku' => 'required|alpha_num',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'image2' => 'image',
            'image3' => 'image',
            'color' => 'required|regex:/^[\pL\s\-]+$/u',
            'features' => 'required',
            'qty' => 'required|numeric|max:1',
            'desc' => 'required'
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}

        $img = $request->file('image')->store('public/product');
        $exp = explode('/', $img);
        $image = $exp[1].'/'.$exp[2];

        $img1 = $request->file('image2')->store('public/product');
        $exp1 = explode('/', $img1);
        $image1 = $exp1[1].'/'.$exp1[2];

        $img2 = $request->file('image3')->store('public/product');
        $exp2 = explode('/', $img2);
        $image2 = $exp2[1].'/'.$exp2[2];



        $create = Product::create
        ([
                'cat_id' => $request->cat_id,
                'sub_cat_id' => $request->sub_cat_id,
                'type_id' => $request->type_id,
                'main_cat_id' => $request->main_cat_id,
                'brand_id' => $request->brand_id,
                'title' => $request->title,
                'sku' => $request->sku,
                'price' => $request->price,
                'image' => $image,
                'image2' => $image1,
                'image3' => $image2,
                'color' => $request->color,
                'features' => $request->features,
                'quantity' => $request->qty,
                'description' => $request->desc,
                'slug' =>   SlugService::createSlug(Product::class, 'slug', $request->title),
        ]);

        if($create == true){
            return response()->json(['status'=>'1']);
        }
    }

    public static function viewProduct(Request $request){
        if(!empty($request->id)){
            $data = Product::where(['id' => $request->id])->get();
            foreach($data as $res){
                return response($res);
            }
        }
    }

    public static function editProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'cat_id' => 'required|numeric',
            'sub_cat_id' => 'required|numeric',
            'type_id' => 'required|numeric',
            'main_cat_id' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'title' => 'required',
            'sku' => 'required|alpha_num',
            'price' => 'required|numeric',
            'color' => 'required|regex:/^[\pL\s\-]+$/u',
            'features' => 'required',
            'qty' => 'required|numeric|max:1',
            'desc' => 'required'
        ]);

        if ($validator->fails())
		{
			return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
		}
        $update = Product::where(['id' => $request->id]);

        $data = $update->update
        ([
            'cat_id' => $request->cat_id,
            'sub_cat_id' => $request->sub_cat_id,
            'type_id' => $request->type_id,
            'main_cat_id' => $request->main_cat_id,
            'brand_id' => $request->brand_id,
            'title' => $request->title,
            'sku' => $request->sku,
            'price' => $request->price,
            'color' => $request->color,
            'features' => $request->features,
            'quantity' => $request->qty,
            'description' => $request->desc,
            'slug' =>   SlugService::createSlug(Product::class, 'slug', $request->title),
        ]);

        if($request->image)
        {
            $img = $request->file('image')->store('public/product');
            $exp = explode('/', $img);
            $image = $exp[1].'/'.$exp[2];
            $data .= $update->update(['image' => $image]);
        }

        if($request->image2)
        {
            $img1 = $request->file('image2')->store('public/product');
            $exp1 = explode('/', $img1);
            $image1 = $exp1[1].'/'.$exp1[2];
            $data .= $update->update(['image2' => $image1]);
        }

        if($request->image3)
        {
            $img2 = $request->file('image3')->store('public/product');
            $exp2 = explode('/', $img2);
            $image2 = $exp2[1].'/'.$exp2[2];
            $data .= $update->update(['image3' => $image2]);
        }

        if($data == true){
            return response()->json(['status'=>'1']);
        }
    }

    public static function getProduct(Request $request,$cat_slug, $sub_cat_slug, $type_slug, $main_cat_slug, $slug)
    {
        $color = DB::table('products')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->where(['brands.slug' => $slug])->select('products.color')->get();
        $filter = DB::table('products')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->select('products.*', 'brands.brand')->where(['brands.slug' => $slug]);
        if($request->sort_by || $request->color)
        {
            if($request->sort_by == 'low-to-high')
            {
                $filter->orderBy(DB::raw('ABS(price)'),'asc');
            }
            if($request->sort_by == 'high-to-low')
            {
                $filter->orderBy(DB::raw('ABS(price)'),'desc');
            }
            if(!empty($request->color))
            {
                $filter->whereIn('color', $request->color);
            }
        }
        return view('product', [
            'product' => $filter->get(),
            'colors' => $color
        ]);
        // }else{
        //     if(!empty($slug))
        //     {
        //         $data = DB::table('products')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->where(['brands.slug' => $slug])->get();
        //         return view('product', [
        //             'product' => $data
        //         ]);
        //     }
        // }
    }
}
