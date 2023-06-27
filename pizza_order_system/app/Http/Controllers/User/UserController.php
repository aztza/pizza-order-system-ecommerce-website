<?php

namespace App\Http\Controllers\User;

use Storage;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function home(){
        $pizza = Product::get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view("user.main.home",compact('pizza','category','cart','history'));
    }

    public function passwordChangePage(){
        return view('user.password.change');
    }

    public function filter($id){
        $pizza = Product::where('category_id',$id)->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        return view("user.main.home",compact('pizza','category','cart'));
    }

    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbPassword = $user->password;
        if(Hash::check($request->oldPassword, $dbPassword)){
            User::where('id',Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            Auth::logout();
            return redirect()->route('auth#loginPage');
        }
        return back()->with(['notMatch' => 'OldPassword Not Match.Try Again']);
    }

    //admin user
    public function userList(){
        $users = User::when(request('key'),function($query){
                    $query->orWhere('name','like','%'.request('key').'%')->where('role','user')
                    ->orWhere('email','like','%'.request('key').'%')->where('role','user')
                    ->orWhere('gender','like','%'.request('key').'%')->where('role','user')
                    ->orWhere('phone','like','%'.request('key').'%')->where('role','user')
                    ->orWhere('address','like','%'.request('key').'%')->where('role','user');
        })->where('role','user')->paginate(4);
        $users->appends(request()->all());
        return view("admin.user.list",compact('users'));
    }

    //change Role
    public function userChangeRole(Request $request){
        logger($request);
        $updateSource = [
            'role' => $request->role
        ];
        User::where('id',$request->userId)->update($updateSource);
    }

    public function detail(){
        return view('user.profile.detail');
    }

    public function product_details($id){
        $pizza = Product::where('id',$id)->first();
        $pizzaList = Product::get();
        return view('user.main.detail',compact('pizza','pizzaList'));
    }

    public function update($id,Request $request){
        $this->validationDatas($request);
        $datas = $this->getUserDatas($request);
            if($request->hasFile('image')){
                $dbImage = User::where('id',$id)->first();
                $dbImage = $dbImage->image;

                if($dbImage != null){
                    Storage::delete('public/'.$dbImage);
                }

                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public',$fileName);
                $datas['image'] = $fileName;
            }
        User::where('id',$id)->update($datas);
        return back()->with(['updateSuccess'=>'User Profile Updated']);
    }
    //contact
    public function contact(){
        return view("user.main.contact");
    }

    public function userMessage(Request $request){
        $this->contactValidationCheck($request);
        if($request->email == Auth::user()->email){
            $userMessage = [
                'name' => $request->name,
                'email' => $request->email,
                'message' =>$request->message
            ];
            Contact::create($userMessage);
        }else{
            return back()->with(['email'=>'Your email is incorrect']);
        };
        return redirect()->route("user#home");
    }

    //cart
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_image')
                       ->leftjoin('products','products.id','carts.product_id')
                       ->where('carts.user_id',Auth::user()->id)
                       ->get();
        $total = 0;
        foreach($cartList as $c){
            $total += $c->pizza_price*$c->qty;
        }

        return view('user.main.cart',compact('cartList','total'));
    }

    //history page
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(6);
        return view('user.main.history',compact('order'));
    }

    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword'=>'required|min:6',
            'newPassword'=>'required|min:6',
            'confirmPassword'=>'required|min:6|same:newPassword'
        ])->validate();
    }

     //validation update data
     private function validationDatas($request){
        Validator::make($request->all(),[
            "name" => 'required',
            "email" => 'required',
            "phone" => 'required',
            "image" => 'mimes:png,jpg,jpeg|file',
            "gender" => 'required',
            "address" => 'required'
        ])->validate();
    }

    // update user datas
    private function getUserDatas($request){
        return [
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "gender" => $request->gender,
            "address" => $request->address,
            "updated_at" => Carbon::now()
        ];
    }

    private function contactValidationCheck($request){
        Validator::make($request->all(),[
            "name" => 'required',
            "email" => 'required',
            "message" => 'required',
        ])->validate();
    }

}
