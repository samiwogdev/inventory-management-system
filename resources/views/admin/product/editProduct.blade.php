@extends('admin.layout.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Manage Category</h4>
                <h6>Edit a product Category</h6>
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
                @if($product)
                <form action="{{ url('admin/updateProduct/' . $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Supplier</label>
                                <select class="select" name="supplier_id">
                                    <option value="-1">Choose Supplier</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="select" name="category_id">
                                    <option value="-1">Choose Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" name="sku" value="{{ old('name', $product->sku) }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Unit Price(£)</label>
                                <input type="text" name="unitPrice" value="{{ old('name', $product->unitPrice) }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" name="quantity" value="{{ old('name', $product->quantity) }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Reorder Level</label>
                                <input type="text" name="reorderLevel" value="{{ old('name', $product->reorderLevel) }}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description">{{ old('name', $product->description) }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <input type="submit" name="product_but" value="Submit" class="btn btn-submit me-2">
                            <a href="{{ url('admin/productList') }}" class="btn btn-cancel">View Product</a>
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