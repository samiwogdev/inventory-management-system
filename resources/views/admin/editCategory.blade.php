@extends('admin.layout.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Edit Category</h4>
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
                @if($category)
                <form action="{{ url('admin/updateCategory/' . $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="categoryName">Category Name</label>
                                <input
                                    type="text"
                                    id="categoryName"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', $category->name) }}">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="categoryDescription">Description</label>
                                <textarea
                                    id="categoryDescription"
                                    name="description"
                                    class="form-control">{{ old('description', $category->description) }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ url('admin/categoryList') }}" class="btn btn-cancel">Cancel</a>
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