@extends('user.layouts.master')

@section('content')
    <div class="col-8 offset-2">
        <form class="row g-3" action="{{ route('user#message') }}" method="get">
            @csrf
            <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Name</label>
              <input type="text" name="name" class="form-control" id="inputEmail4">
              @error('name')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="inputPassword4">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            @if(session('email'))
                <small class="text-danger">{{ session('email') }}</small>
            @endif
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">Message</label>
                <textarea class="form-control" name="message" rows="12" id="inputAddress"></textarea>
            @error('message')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
    </div>
@endsection
