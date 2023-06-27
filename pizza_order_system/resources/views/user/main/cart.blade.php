@extends('user.layouts.master')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0"  id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                            <tr>
                                <td class="align-middle"><img class="img-thumbnail shadow-sm"  style="width:60px" src="{{ asset("storage/".$c->product_image) }}"></td>
                                <input type="hidden" id="orderId" value="{{ $c->id }}">
                                <input type="hidden" id="userId" value="{{ $c->user_id }}">
                                <input type="hidden" id="productId" value="{{ $c->product_id }}">
                                <td class="align-middle">{{ $c->pizza_name }}</td>
                                <td class="align-middle"  id="price">{{ $c->pizza_price }} kyat</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-dark btn-minus" >
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm border-0 text-center"  id="qty" value="{{ $c->qty }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-dark btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle" id="total">{{ $c->pizza_price*$c->qty }} kyat</td>
                                <td class="align-middle">
                                    <button class="btn btn-sm btn-danger btn-delete">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">{{ $total }} kyat</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">3000 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="totalPrice">{{ $total+3000 }}Kyat</h5>
                        </div>
                        <button id="addToCart" class="btn btn-block btn-dark font-weight-bold my-3 py-3">Proceed To Checkout</button>
                        <button id="clearBtn" class="btn btn-block btn-danger font-weight-bold my-3 py-3">Clear Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section("scriptSource")
<script>
    $(document).ready(function(){
        $(".btn-plus").click(function(){
            $parent = $(this).parents("tr");
            $qty = $parent.find("#qty").val();
            $price = Number($parent.find("#price").text().replace("kyat",""));

            $total = $price*$qty;
            $parent.find("#total").html(`${$total} kyat`);

            summary();
        })
        $(".btn-minus").click(function(){
            $parent = $(this).parents("tr");
            $qty = $parent.find("#qty").val();
            $price = Number($parent.find("#price").text().replace("kyat",""));

            $total = $price*$qty;
            $parent.find("#total").html($total+" kyat");

            summary();
        })

        $(".btn-delete").click(function(){
            $parent = $(this).parents("tr");
            $productId = $parent.find("#productId").val();
            $orderId = $parent.find("#orderId").val();

            $.ajax({
                type : 'get' ,
                url : 'http://localhost:8000/user/ajax/delete/current/cart',
                data : { 'productId' : $productId, 'orderId' : $orderId },
                dataType : 'json',
            })

            $parent.remove();

            summary();
        })

        function summary(){
            $totalPrice = 0;
            $("#dataTable tr").each(function(index,row){
                $totalPrice += Number($(row).find("#total").text().replace("kyat",""));
            })
            $("#subTotalPrice").html(`${$totalPrice} kyat`);
            $("#totalPrice").html(`${$totalPrice + 3000} kyat`)

        }

        $("#addToCart").click(function(){
            $orderList = []

            $random = Math.floor(Math.random() * 10000000001)

            $("#dataTable tbody tr").each(function(index,row){
                $orderList.push({
                    'userId' : $(row).find("#userId").val() ,
                    'productId' : $(row).find("#productId").val() ,
                    'qty' : $(row).find("#qty").val() ,
                    'total' : Number($(row).find("#total").text().replace("kyat", "")) ,
                    'order_code' : 'POS'+$random
                })
            })

            $.ajax({
                type : 'get' ,
                url : 'http://localhost:8000/user/ajax/order/list',
                data : Object.assign({}, $orderList),
                dataType : 'json',
                success : function(response){
                    if(response.status == "true"){
                        window.location.href="http://localhost:8000/user/home"
                    }
                }
            })
        })
        $('#clearBtn').click(function(){
            $('#dataTable tbody tr').remove();
            $('#subTotalPrice').html("0 kyat");
            $('#totalPrice').html("3000 kyat");

            $.ajax({
                type : 'get' ,
                url : 'http://localhost:8000/user/ajax/clear/cart',
                dataType : 'json',
            })
        })
    })
</script>
@endsection
