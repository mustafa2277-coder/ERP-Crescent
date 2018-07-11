<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!--Start of Zendesk Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
$.src="https://v2.zopim.com/?5lQIuBuP5WbOu6ZYtv87DG8QeMcTkR6A";z.t=+new Date;$.
type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
</script>
<!--End of Zendesk Chat Script-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ERP</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">



   @yield('css')
   
</head>
<body class="theme-red">
    {{--  <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>  --}}
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="/"><img src="{{asset('public/images/tbcerp.png')}}" height='30px'/></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    {{--  <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>  --}}
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count">1</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">person_add</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>12 new members joined</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-cyan">
                                                <i class="material-icons">add_shopping_cart</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>4 sales made</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 22 mins ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-red">
                                                <i class="material-icons">delete_forever</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy Doe</b> deleted account</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-orange">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>Nancy</b> changed name</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 2 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-blue-grey">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> commented your post</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 4 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-light-green">
                                                <i class="material-icons">cached</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4><b>John</b> updated status</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <div class="icon-circle bg-purple">
                                                <i class="material-icons">settings</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>Settings updated</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> Yesterday
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <span class="label-count">1</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                <ul class="menu tasks">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Footer display issue
                                                <small>32%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Make new buttons
                                                <small>45%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Create new dashboard
                                                <small>54%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Solve transition issue
                                                <small>65%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Answer GitHub questions
                                                <small>92%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Tasks -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{asset('public/images/user.png')}}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}}</div>
                    <div class="email">{{Auth::user()->email}}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li>{{--  <a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a>  --}}
                                 <a  href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="material-icons">input</i>Sign Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                        </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="active">
                        <a href="{{url('/home')}}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    @role(['acc-manage','admin'])
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_balance_wallet</i>
                            <span>Accounting</span>

                        </a>

                        <ul class="ml-menu">
                            
                            <li>
                                <a href="{{url('/getAccountHeads')}}">Account Heads</a>
                            <li>
                                <a href="{{url('/getJournals')}}">Journals</a>
                            </li>
                            <li>
                                <a href="{{url('/getJournalItems')}}">Journal Items</a>
                            </li>
                            <li>
                                <a href="{{url('/getJournalEntriesListView')}}" accesskey="j">Journal Entries</a>
                            </li>

                             <li>
                                
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">insert_chart</i>
                                    <span>Reports</span>

                                </a>

                                <ul class="ml-menu">

                                    <li>
                                        <a href="{{url('/getGeneralLedgerView')}}">General Ledger</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/getBalanceSheet')}}">Balance Sheet</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/getProfitLoss')}}">Profit and Loss</a>
                                    </li>
                                   
                                    
                                </ul>


                            </li>
                            <li>
                                <a href="{{url('/projectList')}}" accesskey="p">
                                    <i class="material-icons">view_quilt</i>
                                    <span>Projects</span>
        
                                </a>
                            </li>
                            
                            
                        </ul>


                    </li>
                    @endrole






                        @role(['proc-manage','admin'])    
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">unarchive</i>
                                <span>Procurement</span>
    
                            </a>
    
                            <ul class="ml-menu">
                                    
                                <li>
                                            <a href="{{url('/getPurchaseOrders')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Purchase Order</span>
                    
                                            </a>
                                </li>
                                
                                <li>
                                    <a href="{{url('/getRequestPurchase')}}">
                                        <i class="material-icons">text_fields</i>
                                        <span>Purchase Requests</span>
            
                                    </a>
                                </li>
                                
                                
                            </ul>
    
    
                        </li>
                        @endrole

                    @role(['inv-manage','admin','ware1-manage','ware2-manage','ware3-manage','ware4-manage','ware5-manage'])
                    <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">store</i>
                                <span>Inventory Management</span>
    
                            </a>
    
                            <ul class="ml-menu">
                                @role(['inv-manage','admin'])
                                <li>
                                    <a href="javascript:void(0);" class="menu-toggle">
                                        <i class="material-icons">unarchive</i>
                                        <span>Product Management</span>
            
                                    </a>
            
                                    <ul class="ml-menu">
                                            
                                        <li>
                                                    <a href="{{url('/productList')}}">
                                                        <i class="material-icons">text_fields</i>
                                                        <span>Products</span>
                            
                                                    </a>
                                        </li>
                                        <li>
                                                <a href="{{url('/categoryList')}}">
                                                    <i class="material-icons">border_left</i>
                                                    <span>Product Categories</span>
                        
                                                </a>
                                        </li>
                                        
                                        
                                    </ul>
            
            
                                </li>
                                <li>
                                    <a href="{{url('/customerList')}}" accesskey="c">
                                        <i class="material-icons">account_box</i>
                                        <span>Customers</span>
            
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('/vendorList')}}" accesskey="v">
                                        <i class="material-icons">text_fields</i>
                                        <span>Vendors</span>
            
                                    </a>
                                </li>    
                                <li>
                                            <a href="{{url('/warehouse')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Warehouse</span>
                    
                                            </a>
                                </li>
                                @endrole
                                <li>
                                        <a href="{{url('/grn')}}">
                                            <i class="material-icons">border_left</i>
                                            <span>GRN</span>
                
                                        </a>
                                </li>
                                <li>
                                        <a href="{{url('/challan')}}">
                                            <i class="material-icons">border_left</i>
                                            <span>Delivery Challan</span>
                
                                        </a>
                                </li>
                                <li>
                                        <a href="{{url('/stock')}}">
                                            <i class="material-icons">border_left</i>
                                            <span>Stock Taking</span>
                
                                        </a>
                                </li>
                            @role(['inv-manage','admin'])
                            <li>
                                
                                <a href="javascript:void(0);" class="menu-toggle">
                                    <i class="material-icons">insert_chart</i>
                                    <span>Reports</span>

                                </a>

                                <ul class="ml-menu">

                                    <li>
                                        <a href="{{url('/warehouseReport')}}">Warehouse</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/ProductsatReorderLevel')}}">Products at Reorder Level</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/vendorsReport')}}">Products by Vendor</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/productSummary')}}">Products summary</a>
                                    </li>
                                    <li>
                                        <a href="{{url('/productDeatil')}}">Products details</a>
                                    </li>
                                   
                                    
                                </ul>


                            </li>
                            @endrole
                                
                                
                            </ul>
    
    
                    </li>
                    @endrole
                    @role(['payroll-manage','admin'])
                    <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">account_box</i>
                                <span>Employee Management</span>
    
                            </a>
    
                            <ul class="ml-menu">
                                    
                                <li>
                                            <a href="{{url('/employeeList')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Employees</span>
                    
                                            </a>
                                </li>
                                <li>
                                            <a href="{{url('/employeeAdvanceList')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Advances</span>
                    
                                            </a>
                                </li>
                                <li>
                                            <a href="{{url('/employeeAllowanceList')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Allowances</span>
                    
                                            </a>
                                </li>
                                <li>
                                            <a href="{{url('/employeeDeductionList')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Deductions</span>
                    
                                            </a>
                                </li>
                                <li>
                                            <a href="{{url('/employeeSalaryList')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Salary</span>
                    
                                            </a>
                                </li>
                                <li>
                                            <a href="{{url('/employeePayrollList')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Payroll</span>
                    
                                            </a>
                                </li>
                                {{-- <li>
                                        <a href="{{url('/categoryList')}}">
                                            <i class="material-icons">border_left</i>
                                            <span>Product Categories</span>
                
                                        </a>
                                </li> --}}
                                
                                
                            </ul>
    
    
                    </li>
                    @endrole
                    @role('admin')
                    <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">account_box</i>
                                <span>User Management</span>
    
                            </a>
    
                            <ul class="ml-menu">
                                    
                                <li>
                                            <a href="{{url('/userList')}}">
                                                <i class="material-icons">text_fields</i>
                                                <span>Users</span>
                    
                                            </a>
                                </li>
                                
                            </ul>
    
    
                    </li>
                    @endrole

                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2017 - 2018 <a href="javascript:void(0);">Tech Bridge Consultancy</a>.
                </div>
                <!-- <div class="version">
                    <b>Version: </b> 1.0.5
                </div> -->
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
               
                <li role="presentation" class="active"><a href="#settings" data-toggle="tab">OPTIONS</a></li>
            </ul>
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active" id="settings">
                    <div class="demo-settings">
                        <p><a href="">Configurations</a></p>
                        <div class="divider"></div>
                        
                        
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>
    @yield('content')
    <!-- Scripts -->
    @yield('js')

</body>
</html>
