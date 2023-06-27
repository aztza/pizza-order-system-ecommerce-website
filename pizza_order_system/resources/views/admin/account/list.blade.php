@extends('admin.layouts.master')

@section('title','Admin List Page')

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
                                <h2 class="title-1">Admin List</h2>
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
                            <h3>Total - {{ count($admins) }} </h3>
                        </div>
                    </div>

                    <div class="col-3 offset-9">
                        <form action="" method="get">
                            @csrf
                                <div class="d-flex">
                                    <input type="text" placeholder="search" name="key" class="form-control" value="{{ request('key') }}">
                                    <button class="btn bg-dark text-white">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                        </form>
                    </div>
                        @if(count($admins) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                        <tbody>
                                            @foreach ($admins as $a)
                                            <tr class="tr-shadow">
                                                <td class="col-2">
                                                    @if($a->image == null)
                                                        @if($a->gender == 'male')
                                                            <img src="{{ asset('image/default.jpg') }}" alt="">
                                                        @else
                                                            <img src="{{ asset('image/default_female_profile.png') }}" alt="">
                                                        @endif
                                                    @else
                                                        <img src="{{ asset('storage/'.$a->image) }}" class="img-thumbnail shadow-sm">
                                                    @endif
                                                </td>
                                                <input type="hidden" id="userId" value="{{ $a->id }}">
                                                <td>{{ $a->name }}</td>
                                                <td>{{ $a->email }}</td>
                                                <td>{{ $a->phone }}</td>
                                                <td>{{ $a->gender }}</td>
                                                <td>{{ $a->address }}</td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        @if($a->id == Auth::user()->id)
                                                        @else
                                                        <select class="form-control statusChange me-3">
                                                            <option value="user" @if($a->role == 'user') selected @endif>User</option>
                                                            <option value="admin" @if($a->role == 'admin') selected @endif>Admin</option>
                                                        </select>
                                                        <a href="{{ route('admin#delete',$a->id) }}" class="me-1 mt-1">
                                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                                <i class="zmdi zmdi-delete"></i>
                                                            </button>
                                                        </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            <!-- END DATA TABLE -->
                            <div class="mt-3">
                                {{ $admins->links() }}
                            </div>
                        @else
                            <h3 class="text-secondary text-center mt-5"> There is no data </h3>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
@section("scriptSource")
<script>
    $(document).ready(function(){
        $(".statusChange").change(function(){
            $currentStatus = $(this).val()
            $parentNode = $(this).parents("tr")
            $userId = $parentNode.find("#userId").val()

            $data = {
                'userId' : $userId,
                'role' : $currentStatus
            }

            $.ajax({
                type : 'get' ,
                url : 'http://localhost:8000/user/change/role',
                data : $data ,
                dataType : 'json',
            })

            location.reload()
        })
    })
</script>
@endsection


