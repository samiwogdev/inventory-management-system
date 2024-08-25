@extends('admin.layout.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Order Management</h4>
                <h6>Create New Order</h6>
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
                <form action="{{ url('admin/addOrder') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="customerId">Customer</label>
                                <select name="customerId" class="form-control" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customerId') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="productId">Product</label>
                                <select name="productId" class="form-control" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('productId') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="orderDate">Order Date</label>
                                <input type="date" name="orderDate" class="form-control" value="{{ old('orderDate', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Create</button>
                            <a href="{{ url('admin/orders') }}" class="btn btn-cancel">View Orders</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection