@extends('admin.layouts.master')

@section('title','Admin Edit')

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
                            <div class="card-title">
                                <h3 class="text-center title-2">Account Info</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    @if(Auth::user()->image == null)
                                        @if(Auth::user()->gender == 'female')
                                            <img src="{{ asset('image/default_female_profile.png') }}" alt="">
                                        @else
                                            <img src="{{ asset('/image/default.jpg') }}"/>
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="John Doe" />
                                    @endif
                                </div>
                                <div class="col-5 offset-1">
                                    <h4 class="my-3"><i class="fa-solid fa-user-pen me-2"></i>{{ Auth::user()->name }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-envelope me-2"></i>{{ Auth::user()->email }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-phone-volume me-2"></i>{{ Auth::user()->phone }}</h4>
                                    <h4 class="my3"><i class="fa-solid fa-venus-mars me-2"></i>{{ Auth::user()->gender }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-address-card me-2"></i>{{ Auth::user()->address }}</h4>
                                    <h4 class="my-3"><i class="fa-solid fa-user-clock me-2"></i>{{ Auth::user()->created_at->format('j F y') }}</h4>
                                </div>
                                <div class="row">
                                    <div class="col-4 offset-3 mt-3">
                                        <a href="{{ route('admin#edit') }}">
                                            <button class="btn btn-dark">Edit Profile
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        </a>
                                    </div>
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
