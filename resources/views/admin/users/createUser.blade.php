@extends('admin.layout.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>User Management</h4>
                <h6>Create new User</h6>
            </div>
        </div>

        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <form action="{{ url('admin/addUser') }}" method="POST">@csrf
                        <div class="col-lg-12 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="submit" name="supplier_but" value="Submit" class="btn btn-submit me-2">
                            <a href="{{ url('admin/allUsers') }}" class="btn btn-cancel">View User</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection