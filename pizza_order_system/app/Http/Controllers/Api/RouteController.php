<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    public function pizzaOrderSystemDatas(){
        $category = Category::get();
        $product = Product::get();
        $order = Order::get();
        $order_list = OrderList::get();
        $user = User::get();

        $data = [
            "category" => $category,
            "product" => $product,
            "order" => $order,
            "order_list" => $order_list,
            "user" => $user
        ];

        return response()->json($data, 200);
    }
    //create category
    public function createCategory(Request $request){
        $data = [
            "name" => $request->name,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];
        $response = Category::create($data);
        return response()->json($response,200);
    }

    //create contact
    public function createContact(Request $request){
        $data = $this->getContactData($request);
        Contact::create($data);
        $contact = Contact::orderBy("created_at","desc")->get();
        return response()->json($contact, 200);
    }

    public function deleteCategory($id){
        $data = Category::where('id',$id)->first();
        if(isset($data)){
            $data = Category::where('id',$id)->delete();
            return response()->json(['status' => true, 'message' =>'delete success'],200);
        }
        return response()->json(['status'=> false, 'message'=>'There is no category...'],200);
    }

    public function categoryDetails($id){
        $data = Category::where('id',$id)->first();

        if(isset($data)){
            return response()->json(['status' => true , 'category' => $data],200);
        }
        return response()->json(['status'=> false, 'message'=>'There is no category...'],500);
    }

    public function updateCategory(Request $request){
        $categoryId = $request->category_id;
        $dbSource = Category::where('id',$categoryId)->first();
        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            $response = Category::where("id",$categoryId)->update($data);
            return response()->json(['status'=>true,'message'=>'category update success','category' => $response]);
        }

        return response()->json(["status" => false, "message"=>"There is no category to update . . ."],500);
    }

    private function getContactData($request){
        return [
            "name" => $request->name,
            "email" => $request->email,
            "message" => $request->message,
            "created_at"=> Carbon::now(),
            "updated_at"=> Carbon::now()
        ];
    }

    private function getCategoryData($request){
        return [
            "name" => $request->category_name,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
        ];
    }
}
