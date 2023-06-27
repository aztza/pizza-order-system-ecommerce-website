@extends('admin.layouts.master')

@section('title','Product Edit')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Product Edit</h3>
                            </div>
                            <hr>
                            <form action="{{ route('products#update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="pizza_id" value="{{ $pizza->id }}">
                                    <div class="col-5 offset-1">
                                            <img src="{{ asset('storage/'.$pizza->image) }}" alt="John Doe" />
                                        <div class="mt-3">
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                            @error('image')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button class="btn btn-dark text-white col-12" type="submit"><i class="fa-solid fa-circle-chevron-right me-2"></i>Update</button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text" value="{{ old('name',$pizza->name) }}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Description</label>
                                            <textarea name="description" class="form-control" cols="30" rows="10" class="">{{ old('description',$pizza->description) }}</textarea>
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="category" class="control-label mb-1 @error('gender') is-invalid @enderror">Category</label>
                                                <select name="categoryId" id="category" class="form-control">
                                                    <option value="">Choose category</option>
                                                    @foreach ($categories as $c)
                                                        <option value="{{ $c->id }}" @if($c->id == $pizza->category_id) selected @endif>{{ $c->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('categoryId')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="price" type="text" value="{{ old('name',$pizza->price) }}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('price')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                            <input id="cc-pament" name="waitingTime" type="text" value="{{ old('name',$pizza->waiting_time) }}" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false">
                                            @error('waitingTime')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">View Count</label>
                                            <input id="cc-pament" name="view_count" type="text" value="{{ old('role',$pizza->view_count) }}" class="form-control" aria-required="true" aria-invalid="false" disabled>
                                            @error('view_count')
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
