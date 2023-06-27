@extends('user.layouts.master')

@section('content')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="text-uppercase mb-3"><span>Filter by Categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1">
                            <label class="mt-2" for="price-all">Category</label>
                            <span class="badge border font-weight-normal">{{ count($category) }}</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3 pt-1">
                            <a href="{{ route("user#home") }}" class="text-dark"><label class="" for="">All</label></a>
                        </div>
                        @foreach ($category as $c)
                        <div class="d-flex align-items-center justify-content-between mb-3 pt-1">
                            <a href="{{ route("user#filter",$c->id) }}" class="text-dark"><label class="" for="">{{ $c->name }}</label></a>
                        </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->
            </div>
            <!-- Shop Sidebar End -->
            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route("user#cartList") }}">
                                    <button type="button" class="btn btn-dark position-relative text-white">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                          {{ count($cart) }}
                                          <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </button>
                                </a>

                                <a href="{{ route("user#history") }}" class="ms-3">
                                    <button type="button" class="btn btn-dark position-relative text-white">
                                        <i class="fa-solid fa-clock-rotate-left"></i> History
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                          {{ count($history) }}
                                          <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </button>
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="sorting" id="sortingOption" class="form-control">
                                        <option value="">Choose Option</option>
                                        <option value="asc">Asending</option>
                                        <option value="desc">Desending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dataList" class="row">
                        @if(count($pizza) != 0)
                            @foreach ($pizza as $p)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" src="{{ asset('storage/'.$p->image) }}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href="{{ route("user#productsDetail",$p->id) }}"><i class="fa-solid fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $p->price }} kyats</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3 class="text-secondary text-center mt-5">There is no Pizza</h3>
                        @endif
                    </div>
                        {{-- {{ $pizza->link() }} --}}
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('scriptSource')
<script>
    $(document).ready(function(){
        $('#sortingOption').change(function(){
            $eventOption = $('#sortingOption').val();
            if($eventOption == "desc"){
                $.ajax({
                type : 'get',
                url : 'http://localhost:8000/user/ajax/pizza/list',
                data : { 'status' : 'desc' },
                dataType : 'json',
                success : function(response){
                    $list = '';
                    for(i=0;i<response.length;i++){
                    $list += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="{{ asset('storage/${ response[i].image }') }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">${ response[i].name }</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${ response[i].price } kyats</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    `;
                }
                $('#dataList').html($list);
                }
            })
            }else if($eventOption == "asc"){
                $.ajax({
                type : 'get',
                url : 'http://localhost:8000/user/ajax/pizza/list',
                data : { 'status' : 'asc' },
                dataType : 'json',
                success : function(response){
                    $list = '';
                    for(i=0;i<response.length;i++){
                    $list += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="{{ asset('storage/${ response[i].image }') }}" alt="">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">${ response[i].name }</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${ response[i].price } kyats</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    `;
                }
                $('#dataList').html($list);
            }
            })
            }
        })
    });
</script>
@endsection
