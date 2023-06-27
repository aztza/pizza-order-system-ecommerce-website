<?php

namespace App\Http\Controllers;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //change password
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

    public function accountDetailPage(){
        return view('admin.account.details');
    }

    public function edit(){
        return view('admin.account.edit');
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
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Admin Profile Updated']);
    }

    //admin list
    public function adminList(){
        $admins = User::when(request('key'),function($query){
            $query->orWhere('name','like','%'.request('key').'%')->where('role','admin')
                  ->orWhere('email','like','%'.request('key').'%')->where('role','admin')
                  ->orWhere('gender','like','%'.request('key').'%')->where('role','admin')
                  ->orWhere('phone','like','%'.request('key').'%')->where('role','admin')
                  ->orWhere('address','like','%'.request('key').'%')->where('role','admin');
        })->where('role','admin')->paginate(3);
        $admins->appends(request()->all());
        return view('admin.account.list',compact('admins'));
    }

    //admin delete
    public function delete($id){
        User::where('id',$id)->delete();
        return redirect()->route("admin#list");
    }

    //admin change page
    public function change($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole',compact('account'));
    }

    //admin role change
    public function changeRole($id,Request $request){
        $role = [ "role" => $request->role ];
        User::where('id',$id)->update($role);
        return redirect()->route("admin#list");
    }

    //contact
    public function contactPage(){
        $contactList = Contact::when(request('key'),function($query){
            $query->orWhere('name','like','%'.request('key').'%')
                  ->orWhere('email','like','%'.request('key').'%')
                  ->orWhere('message','like','%'.request('key').'%');
                })->orderBy('created_at','desc')->paginate(4);
        return view('admin.contact.contact',compact('contactList'));
    }

    public function contactDelete($id){
        Contact::where("id",$id)->delete();
        return back();
    }

    public function contactDetail($id){
        $detail = Contact::select("contacts.*","image as user_img","gender as user_gender")
                            ->leftjoin("users","users.email","contacts.email")
                            ->where('contacts.id',$id)->first();
        return view("admin.contact.detail",compact('detail'));
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

    //user list delete
    public function deleteUserAccount($id){
        User::where('id',$id)->delete();
        return redirect()->route("admin#userList");
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

    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword'=>'required|min:6',
            'newPassword'=>'required|min:6',
            'confirmPassword'=>'required|min:6|same:newPassword'
        ])->validate();
    }
}
