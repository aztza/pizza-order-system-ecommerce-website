@extends('admin.layouts.master')

@section('title','Admin Edit')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Feedback Detail</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    @if($detail->user_img == null)
                                        @if($detail->user_gender == 'female')
                                            <img src="{{ asset('image/default_female_profile.png') }}">
                                        @else
                                            <img src="{{ asset('/image/default.jpg') }}"/>
                                        @endif
                                    @else
                                        <img src="{{ asset('storage/'.$detail->user_img) }}" />
                                    @endif
                                </div>
                                <div class="col-5 offset-1">
                                    <h5 class="my-3"><i class="fa-solid fa-user-pen me-2"></i>Name - {{ $detail->name }}</h5>
                                    <h5 class="my-3"><i class="fa-solid fa-envelope me-2"></i>Email - {{ $detail->email }}</h5>
                                    <h5 class="my-3"><i class="fa-solid fa-message me-2"></i>Message - {{ $detail->message }}</h5>
                                </div>
                                <div class="row">
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
