<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orderList(){
        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->when(request('key'),function($query){
                    $query->orWhere('orders.order_code','like','%'.request('key').'%')
                          ->orWhere('orders.total_price','like','%'.request('key').'%')
                    ;})
                ->orderBy('created_at','desc')
                ->paginate(5);
                $order->appends(request()->all());
        return view("admin.order.list",compact('order'));
    }

    public function orderChange(Request $request){
        $order = Order::select('orders.*','users.name as user_name')
                ->leftJoin('users','users.id','orders.user_id')
                ->orderBy('created_at','desc');

        if($request->status == null){
            $order = $order->get();
        }else{
            $order = $order->where('orders.status', $request->status)->get();
        }
        return view("admin.order.list",compact('order'));
    }

    public function statusChange(Request $request){
        Order::where('id',$request->orderId)->update([
            'status'=>$request->status
        ]);
    }

    //order code
    public function listInfo($orderCode){
        $order = Order::where('order_code',$orderCode)->first();

        $orderList = OrderList::select('order_lists.*','users.name as user_name','products.image as product_image','products.name as product_name')
                                ->leftJoin('users','users.id','order_lists.user_id')
                                ->leftJoin('products','products.id','order_lists.product_id')
                                ->where('order_code',$orderCode)
                                ->get();
        return view('admin.order.productList',compact('orderList','order'));
    }
}
