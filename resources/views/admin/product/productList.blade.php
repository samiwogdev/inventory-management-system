@extends('admin.layout.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product List</h4>
                <h6>View/Search Product List</h6>
            </div>
            <div class="page-btn">
                <a href="{{url('admin/addProduct')}}" class="btn btn-added">
                    <img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Product
                </a>
            </div>
        </div>
        @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
            <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">
                        </div>
                        <div class="search-input">
                            <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img"></a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                        src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                        src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                        src="{{ asset('assets/img/icons/printer.svg') }}" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>
                @if(!$productList->isEmpty())
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Supplier</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>unit Price</th>
                                <th>Quantity</th>
                                <th>Reorder Level</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productList as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->supplier->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->unitPrice }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->reorderLevel }}</td>
                                <td>{{ $product->description }}</td>
                                <td>
                                    <a class="me-3" href="{{ url('admin/editProduct/' . $product->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    <a class="me-3" href="javascript:void(0);" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $product->id }}">
                                        <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete">
                                    </a>
                                </td>
                                                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
                        aria-labelledby="delete_modal" aria-hidden="true">
                        <form action="{{ route('admin.deleteProduct', $product->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="delete_modal">Are you Sure ?</h5>
                                        <button type="button" class="btn-close"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="font-size: 17px;">You won't be able to revert this!</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit"
                                            class="btn btn-danger">Yes, delete it!</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection