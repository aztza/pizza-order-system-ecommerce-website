@extends('admin.layouts.master')

@section('title','User List Page')

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
                                <h2 class="title-1">User List</h2>
                            </div>
                            <h3 class="mt-2">Total - {{ count($users) }} </h3>
                        </div>
                        <form action="{{ route("admin#userList") }}" method="get">
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
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                    <tbody id="dataList">
                                        @foreach($users as $user)
                                        <tr>
                                            <td class="col-2">
                                                @if($user->image == null)
                                                    @if($user->gender == 'female')
                                                        <img src="{{ asset('image/default_female_profile.png') }}" alt="">
                                                    @else
                                                        <img src="{{ asset('/image/default.jpg') }}"/>
                                                    @endif
                                                @else
                                                    <img src="{{ asset('storage/'.$user->image) }}" alt="John Doe" />
                                                @endif
                                            </td>
                                            <input type="hidden" id="userId" value="{{ $user->id }}">
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->gender }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>
                                                <select class="form-control statusChange">
                                                    <option value="user" @if($user->role == 'user') selected @endif>User</option>
                                                    <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route("admin#deleteUserAccount",$user->id) }}" class="me-1">
                                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            <div class="mt-3">
                                {{ $users->links() }}
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


