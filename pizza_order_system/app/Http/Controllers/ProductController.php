<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //product list page
    public function productsList(){
        $pizza = Product::select('products.*','categories.name as category_name')
        ->when(request('key'),function($query){$query->where('products.name','like','%'.request('key').'%');})
        ->leftjoin('categories','products.category_id','categories.id')
        ->orderBy('products.created_at','desc')
        ->paginate(3);
        $pizza->appends(request()->all());
        return view('admin.products.list',compact('pizza'));
    }

    //product create page
    public function productsCreatePage(){
        $categoryData = Category::select('id','name')->get();
        return view('admin.products.create_page',compact('categoryData'));
    }

    public function productsCreate(Request $request){
        $this->createValidationCheck($request,'create');
        $datas = $this->createProduct($request);

        $fileName = uniqid() . $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public',$fileName);
        $datas["image"] = $fileName;

        Product::create($datas);
        return redirect()->route('products#list')->with(["productCreated"=>"Product Created Successfully"]);
    }

    //product detail view
        public function productsDetail($id){
            $pizza = Product::select('products.*','categories.name as category_name')
                     ->leftjoin('categories','products.category_id','categories.id')
                     ->where('products.id',$id)->first();
            return view('admin.products.detail',compact('pizza'));
        }

    //product update page
        public function productsUpdatePage($id){
            $pizza = Product::where('id',$id)->first();
            $categories = Category::get();
            return view('admin.products.edit',compact('pizza','categories'));
        }

    //product update
        public function productsUpdate(Request $request){
            $this->createValidationCheck($request,"update");
            $data = $this->createProduct($request);

            if($request->hasFile('image')){
                $oldImageName = Product::where('id',$request->pizza_id)->first();
                $oldImageName = $oldImageName->image;

                if($oldImageName != null){
                    Storage::delete('public/'.$oldImageName);
                }

                $fileName = uniqid().$request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public',$fileName);
                $data['image'] = $fileName;
            }

            Product::where('id',$request->pizza_id)->update($data);
            return redirect()->route("products#list")->with(["productsUpdate"=>'Updated Successfully']);

        }

        //product delete
        public function productsDelete($id){
            Product::where('id',$id)->delete();
            return redirect()->route('products#list')->with(['productsDelete'=>'Deleted Successfully']);
        }

    private function createValidationCheck($request,$action){
        $valid = [
            "name" => "required|min:5|unique:products,name,".$request->pizza_id ,
            "categoryId" => "required",
            "description" => "required|min:10",
            "waitingTime" => "required",
            "price" => "required"
        ];

        $valid["image"] = $action == "create" ? "required|mimes:jpg,jpeg,png,webp|file" : "mimes:jpg,jpeg,png,webp|file";

        Validator::make($request->all(),$valid)->validate();
    }

    private function createProduct($request){
        return [
        "category_id" => $request->categoryId,
        "name" => $request->name,
        "description" => $request->description,
        "waiting_time" => $request->waitingTime,
        "price" => $request->price
    ];
    }
}
