@extends('admin.layout.layout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Order Management</h4>
                <h6>View/Search Orders</h6>
            </div>
            @if(Auth::guard('admin')->user()->status == 2)
            <div class="page-btn">
                <a href="{{ url('admin/addOrder') }}" class="btn btn-added">
                    <img src="{{ asset('assets/img/icons/plus.svg') }}" class="me-1" alt="img">Add Order
                </a>
            </div>
            @endif
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
                @if(!$orders->isEmpty())
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>{{ $order->description }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                    <span class="badge bg-warning">{{ $order->status }}</span>
                                    @elseif($order->status == 'approved')
                                    <span class="badge bg-primary">{{ $order->status }}</span>
                                    @else
                                    <span class="badge bg-success">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->orderDate }}</td>
                                <td>
                                    @if(Auth::guard('admin')->user()->status == 2 && $order->status == 'pending')
                                    <a class="me-3" href="{{ route('admin.editOrder', $order->id) }}">
                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Edit">
                                    </a>
                                    @endif
                                    @if($order->status == 'approved')
                                    <form id="form-{{ $order->id }}" action="{{ route('admin.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <a href="javascript:void(0);"  onclick="document.getElementById('form-{{ $order->id }}').submit();" style="color: green;">
                                            <img src="{{ asset('assets/img/icons/checked.png') }}" style="width: 30px;" class="icon-success" alt="approved">
                                        </a>
                                    </form>
                                    @endif

                                    @if(Auth::guard('admin')->user()->status == 1 && $order->status == 'pending')
                                    <form id="form-{{ $order->id }}" action="{{ route('admin.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <a href="javascript:void(0);"  onclick="document.getElementById('form-{{ $order->id }}').submit();" style="color: green;">
                                            <img src="{{ asset('assets/img/icons/checked.png') }}" style="width: 30px;" class="icon-success" alt="approve">
                                        </a>
                                    </form>
                                    @endif
                                </td>
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