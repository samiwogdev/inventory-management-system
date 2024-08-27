<div class="sidebar shadow" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="{{url('admin/dashboard')}}"><img src="{{ url('assets/img/icons/dashboard.svg')}}" alt="img"><span> Dashboard</span> </a>
                </li>
                @if(Auth::guard('admin')->user()->status == 2)
                <li class="submenu">
                    <a><img src="{{ url('assets/img/icons/product.svg')}}" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('admin/productList')}}">Product List</a></li>
                        <li><a href="{{url('admin/categoryList')}}">Category List</a></li>
                    </ul>
                </li>
                @endif
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ url('assets//img/icons/sales1.svg')}}" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('admin/sales')}}">Sales List</a></li>

                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ url('assets//img/icons/purchase1.svg')}}" alt="img"><span> Order</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('admin/orders')}}">Order List</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ url('assets//img/icons/users1.svg')}}" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
                    <ul>
                        @if(Auth::guard('admin')->user()->status == 2)
                        <li><a href="{{url('admin/viewCustomer')}}">Customers List</a></li>
                        <li><a href="{{url('admin/supplierList')}}">Suppliers List</a></li>
                        @endif
                        @if(Auth::guard('admin')->user()->status == 1)
                        <li><a href="{{url('admin/allUsers')}}">Users List</a></li>
                        @endif
                    </ul>
            </ul>
        </div>
    </div>
</div>