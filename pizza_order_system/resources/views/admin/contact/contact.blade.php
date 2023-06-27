@extends('admin.layouts.master')

@section('title','Category List Page')

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
                                <h2 class="title-1">Customers Messages</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-3 offset-9">
                        <form action="{{ route('admin#contactPage') }}" method="get">
                                <div class="d-flex">
                                    <input type="text" placeholder="search" name="key" class="form-control" value="{{ request('key') }}">
                                    <button class="btn bg-dark text-white">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                        </form>
                    </div>

                    <div class="row my-2">
                        <div class="col-3">
                            <h3>Total - {{ count($contactList) }}</h3>
                        </div>
                    </div>
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contactList as $c)
                                    <tr>
                                        <td>{{ $c->name }}</td>
                                        <td>{{ $c->email }}</td>
                                        <td>{{ (strlen($c->message)) > 5 ? substr($c->message,0,50). ". . ." : $c->message }} </td>
                                        <td>{{ $c->created_at->format("j-M-Y") }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('contact#detail',$c->id) }}">
                                                    <button class="item me-2" data-toggle="tooltip" data-placement="top" title="Detail">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </a>
                                                <a href="{{ route('contact#delete',$c->id) }}">
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
                                {{ $contactList->appends(request()->query())->links() }}
                            </div>
                        </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

