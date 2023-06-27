<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //list
    public function list(){
        $categories = Category::when(request('key'),function($q){
            $q->where('name','like','%'.request('key').'%');
        })->orderBy('id','desc')->paginate(5);
        return view('admin.category.list',compact('categories'));
    }

    //create category page
    public function createPage(){
        return view('admin.category.create');
    }
    //edit category page
    public function editPage($id){
        $data = Category::where('id',$id)->first(); //collection
        return view('admin.category.edit',compact('data'));
    }

    //update category page
    public function update(Request $request){
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        $updateData = Category::where('id',$request->categoryId)->update($data);
        return redirect()->route('category#list')->with(['updateSuccess' => 'Category Updated...']);
    }

    // create category page
    public function create(Request $request){
        $this->categoryValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list')->with(['categorySuccess'=>'Category created...']);
    }

    public function delete($id){
        Category::where('id',$id)->delete();
        return back()->with(['categoryDelete'=>'Category deleted...']);
    }

    // category validation check
    private function categoryValidationCheck($request){
        Validator::make($request->all(),[
            'categoryName' => 'required|unique:categories,name,'.$request->categoryId,
        ])->validate();
    }
    // category create
    private function requestCategoryData($request){
        return [
            'name' => $request->categoryName
        ];
    }
}
