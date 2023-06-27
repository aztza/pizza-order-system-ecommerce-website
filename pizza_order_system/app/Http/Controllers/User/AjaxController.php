<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function pizzaList(Request $request){
            if($request->status == "desc"){
                $data = Product::orderBy('created_at','desc')->get();
            }else{
                $data = Product::orderBy('created_at','asc')->get();
            }
            return response()->json($data, 200);
        }

    public function pizzaAddCart(Request $request){
        $data = $this->getAddData($request);
        Cart::create($data);
        return response()->json([
            'message' => 'add to cart complete',
            'status' => 'success'
        ], 200);
    }

    //order
    public function orderList(Request $request){
        $total = 0;
        foreach($request->all() as $item){
            $data = OrderList::create([
                    'user_id' => $item['userId'],
                    'product_id' => $item['productId'],
                    'qty' => $item['qty'],
                    'total' => $item['total'],
                    'order_code' => $item['order_code']
                ]);
            $total += $data->total ;
        }

        Cart::where('user_id',Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id ,
            'order_code' => $data->order_code ,
            'total_price' => $total+3000
        ]);

        return response()->json([
            "status" => "true" ,
            "message" => "order completed"
        ],200);
    }

    //clear cart
    public function clearCart(){
        Cart::where('user_id',Auth::user()->id)->delete();
    }

    //delete current cart
    public function deleteCurrentCart(Request $request){
        Cart::where('product_id',$request->productId)
              ->where('id',$request->orderId)
              ->delete();
    }

    //increase view count
    public function increaseViewCount(Request $request){
        $pizza = Product::where('id',$request->productId)->first();

        $viewCount = [
            'view_count' => $pizza->view_count + 1
        ];

        Product::where('id',$request->productId)->update($viewCount);
    }

    private function getAddData($request){
        return $data = [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->qty
        ];
    }

}
