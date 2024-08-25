@extends('admin.layout.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>User Profile</h4>
                <h6>Edit Login Password</h6>
            </div>
        </div>

        @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error_message') }}
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
                <form action="{{ url('admin/updateUsers') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="username">Name</label>
                                <input type="text" name="username" class="form-control"
                                    value="{{ old('name', $users->name) }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="userEmail">Email</label>
                                <input type="text" id="SupplierPhone" name="email" class="form-control"
                                    value="{{ old('email', $users->email) }}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="password">Current Password</label>
                                <input type="password" name="currentPassword" id="currentPassword" class="form-control">
                                <p id="currentPassordMsg"></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="newPassword" id="newPassword" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="password">Confirm Password</label>
                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
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
@endsection