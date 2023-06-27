@extends('admin.layouts.master')

@section('title','Product List Page')

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
                                <h2 class="title-1">Product List</h2>
                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('products#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add product
                                </button>
                            </a>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
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
                            <h3>Total - {{ $pizza->total()}} </h3>
                        </div>
                    </div>

                    <div class="col-3 offset-9">
                        <form action="" method="get">
                                <div class="d-flex">
                                    <input type="text" placeholder="search" name="key" class="form-control" value="{{ request('key') }}">
                                    <button class="btn bg-dark text-white">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                        </form>
                    </div>
                    @if(count($pizza) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>View Count</th>
                                    </tr>
                                </thead>
                                        <tbody>
                                            @foreach ($pizza as $p)
                                            <tr class="tr-shadow">
                                                <td class="col-2"><img src="{{ asset('storage/'.$p->image) }}" class="img-thumbnail shadow-sm"></td>
                                                <td>{{ $p->name }}</td>
                                                <td>{{ $p->price }}</td>
                                                <td>{{ $p->category_name }}</td>
                                                <td><i class="fa-solid fa-eye me-1"></i>{{ $p->view_count }}</td>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <a href="{{ route('products#details',$p->id) }}" class="me-1">
                                                            <button class="item" data-toggle="tooltip" data-placement="top" title="view">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </a>
                                                        <a href="{{ route('products#updatePage',$p->id) }}" class="me-1">
                                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                <i class="zmdi zmdi-edit"></i>
                                                            </button>
                                                        </a>
                                                        <a href="{{ route('products#delete',$p->id) }}" class="me-1">
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
                                </div>
                            <!-- END DATA TABLE -->
                            <div class="mt-3">
                                {{ $pizza->links() }}
                            </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no Pizza</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


