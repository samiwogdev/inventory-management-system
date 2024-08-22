@extends('admin.layout.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>User Management</h4>
                <h6>Edit User Details</h6>
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
                @if($users)
                    <form action="{{ url('admin/updateUsers/' . $users->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="username">username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ old('username', $users->username) }}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="userEmail">Email</label>
                                    <input type="text" id="SupplierPhone" name="email" class="form-control"
                                        value="{{ old('email', $users->email) }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" name="userRole" class="form-control"
                                        value="{{ old('userRole', $users->userRole) }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control"
                                        value="{{ old('password', $users->password) }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{ url('admin/allUsers') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="row">
                        <div class="col-lg-12 text-danger">
                            No result found
                        </div>
                    </div>
                @endif
            </div>
        </div>


    </div>
</div>