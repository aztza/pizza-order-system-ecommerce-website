@extends('admin.layouts.master')

@section('title','Admin Role Change')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Role Change</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#changeRole',$account->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-5 offset-1">
                                        @if($account->image == null)
                                            <img src="{{ asset('/image/default.jpg') }}"/>
                                        @else
                                            <img src="{{ asset('storage/'.$account->image) }}" alt="John Doe" />
                                        @endif

                                        <div class="mt-3">
                                            <input type="file" disabled class="form-control @error('image') is-invalid @enderror" name="image">
                                            @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-dark text-white col-12" type="submit"><i class="fa-solid fa-circle-chevron-right me-2"></i>Change</button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" disabled type="text" value="{{ old('name',$account->name) }}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <select name="role" id="gender" class="form-control">
                                                <option value="admin" @if($account->role == 'admin') selected @endif>admin</option>
                                                <option value="user"  @if($account->role == 'user') selected @endif>user</option>
                                            </select>
                                            @error('role')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" disabled type="text" value="{{ old('email',$account->email) }}" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" disabled value="{{ old('phone',$account->phone) }}" type="text" class="form-control @error('phone') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="gender" class="control-label mb-1 @error('gender') is-invalid @enderror">Gender</label>
                                                <select name="gender" disabled id="gender" class="form-control">
                                                    <option value="">Choose your gender</option>
                                                    <option value="male" @if($account->gender == 'male') selected @endif>Male</option>
                                                    <option value="female"  @if($account->gender == 'female') selected @endif>Female</option>
                                                </select>
                                                @error('gender')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea name="address" disabled class="form-control" cols="30" rows="10" class="">{{ old('address',$account->address) }}</textarea>
                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
