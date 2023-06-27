@extends('admin.layouts.master')

@section('title','Product Detail')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="row">
                @if(session('updateSuccess'))
                    <div class="col-3 offset-7">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('updateSuccess') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5">
                                <a href="{{ route('products#list') }}">
                                    <i class="fa-solid fa-arrow-left text-dark"></i>
                                </a>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Product Details</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                        <img src="{{ asset('storage/'.$pizza->image) }}"/>
                                </div>
                                <div class="col-7">
                                    <h3 class=""><i class="fa-solid fa-signature me-2 fs-5"></i>{{ $pizza->name }}</h3>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-money-bill-wave me-2 fs-5"></i>{{ $pizza->price }} kyats</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-clock me-2 fs-5"></i>{{ $pizza->waiting_time }} mins</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-list me-2 fs-5"></i>{{ $pizza->category_name }}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-user-clock me-2 fs-5"></i>{{ $pizza->created_at->format('j F y') }}</span>
                                    <div class="my3"><i class="fa-solid fa-indent me-2 fs-4"></i>Details</div>
                                    <div>{{ $pizza->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

