@extends('admin.layouts.master')

@section('title','Order List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>
                            </div>
                        </div>
                    </div>

                    @if(session('categorySuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session('categorySuccess') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    @if(session('productsUpdate'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session('productsUpdate') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    @if(session('productsDelete'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ session('productsDelete') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    <div class="row my-2">
                        <div class="col-3">
                            <h3>Total - {{ count($order) }} </h3>
                        </div>
                    </div>
                    <div class="d-flex">
                        <form action="{{ route("order#change") }}" method="get">
                            @csrf
                            <label for="status" class="mt-1">Order Status</label>
                            <div class="d-flex">
                                <select name="status" class="form-control col-10" id="orderStatus">
                                    <option value="">All</option>
                                    <option value="0" @if(request('status') == '0') selected @endif>Pending</option>
                                    <option value="1" @if(request('status') == '1') selected @endif>Accpect</option>
                                    <option value="2" @if(request('status') == '2') selected @endif>Reject</option>
                                </select>
                                <button type="submit" class="btn btn-dark form-control">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-3 offset-9">
                        <form action="" method="get">
                                <div class="d-flex">
                                    <input type="text" placeholder="search" name="key" class="form-control" value="{{ request('key') }}">
                                    <button class="btn bg-dark text-white">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                        </form>
                    </div>
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                    <tbody id="dataList">
                                        @foreach ($order as $o)
                                        <tr class="tr-shadow">
                                            <input type="hidden" class="orderId" value="{{ $o->id }}">
                                            <td>{{ $o->user_id }}</td>
                                            <td>{{ $o->user_name }}</td>
                                            <td>{{  $o->created_at->format('F-j-Y') }}</td>
                                            <td>
                                                <a href="{{ route("admin#listInfo",$o->order_code) }}" class="text-primary">{{ $o->order_code }}</a>
                                            </td>
                                            <td>{{ $o->total_price }}</td>
                                            <td>
                                                <select name="status" class="form-control statusChange">
                                                    <option value="0" @if($o->status == 0) selected @endif >Pending</option>
                                                    <option value="1" @if($o->status == 1) selected @endif >Accpect</option>
                                                    <option value="2" @if($o->status == 2) selected @endif >Reject</option>
                                                </select>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            <div class="mt-3">
                                {{-- {{ $order->links() }} --}}
                            </div>
                        </div>
                            <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section("scriptSource")
<script>
    $(document).ready(function(){
        // $('#orderStatus').change(function(){
        //     $status = $('#orderStatus').val()
        //     $.ajax({
        //         type : 'get' ,
        //         url : 'http://localhost:8000/orders/ajax/order',
        //         data : {
        //             'status' : $status
        //         },
        //         dataType : 'json',
        //         success : function(response){
        //             $list = '';
        //             for(i=0;i<response.length;i++){
        //                 $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        //                 $dbDate = new Date(response[i].created_at)
        //                 $finalDate = $months[$dbDate.getMonth()]+"-"+$dbDate.getDate()+"-"+$dbDate.getFullYear()
        //                 if(response[i].status == 0){
        //                     $statusMessage = `<select name="status" class="form-control">
        //                                         <option value="0" selected>Pending</option>
        //                                         <option value="1" >Accpect</option>
        //                                         <option value="2" >Reject</option>
        //                                     </select>`
        //                 }else if(response[i].status == 1){
        //                     $statusMessage = `<select name="status" class="form-control">
        //                                         <option value="0" >Pending</option>
        //                                         <option value="1" selected>Accpect</option>
        //                                         <option value="2" >Reject</option>
        //                                     </select>`
        //                 }else if(response[i].status == 2){
        //                     $statusMessage = `<select name="status" class="form-control">
        //                                         <option value="0" >Pending</option>
        //                                         <option value="1" >Accpect</option>
        //                                         <option value="2" selected>Reject</option>
        //                                     </select>`
        //                 }
        //                 $list += `<tr class="tr-shadow">
        //                                     <td>${ response[i].user_id }</td>
        //                                     <td>${ response[i].user_name }</td>
        //                                     <td>${ $finalDate }</td>
        //                                     <td>${ response[i].order_code }</td>
        //                                     <td>${ response[i].total_price }</td>
        //                                     <td>
        //                                         ${ $statusMessage }
        //                                     </td>
        //                                 </tr>`
        //             }
        //             $('#dataList').html($list);

        //         }
        //     })
        // })
        $(".statusChange").change(function(){
            $currentStatus = $(this).val()
            $parentNode = $(this).parents("tr")
            $orderId = $parentNode.find(".orderId").val()

            $data = {
                'status' : $currentStatus ,
                'orderId' : $orderId
            }

            $.ajax({
                type : 'get' ,
                url : 'http://localhost:8000/orders/ajax/order/status/change',
                data : $data ,
                dataType : 'json',
            })
        })
    })
</script>
@endsection


