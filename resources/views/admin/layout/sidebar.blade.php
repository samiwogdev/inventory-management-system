<div class="sidebar shadow" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="active">
                    <a href="{{url('admin/dashboard')}}"><img src="{{ url('assets/img/icons/dashboard.svg')}}" alt="img"><span> Dashboard</span> </a>
                </li>
                <li class="submenu">
                    <a><img src="{{ url('assets/img/icons/product.svg')}}" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{url('admin/productList')}}">Product</a></li>

                        <li><a href="{{url('admin/categoryList')}}">Category</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ url('assets//img/icons/sales1.svg')}}" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="saleslist.html">Sales List</a></li>

                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ url('assets//img/icons/purchase1.svg')}}" alt="img"><span> Order</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="purchaselist.html">Order List</a></li>
                        <li><a href="addpurchase.html">Add Order</a></li>

                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ url('assets//img/icons/users1.svg')}}" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="customerlist.html">Customer</a></li>
                        <li><a href="{{url('admin/supplierList')}}">Supplier</a></li>
                        <li><a href="">User</a></li>
                    </ul>
            </ul>
        </div>
    </div>
</div>