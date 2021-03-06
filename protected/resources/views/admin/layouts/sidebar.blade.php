<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ URL::asset('img/logo.png') }}"
             alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">GotongRoyong.in</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ URL::asset(Auth::user()->image_profile) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ Auth::user()->fullname }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                {{--Dashboard Admin--}}
                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}"
                       class="nav-link {{
                                Request::is('admin/dashboard/*') ? 'active' : '' ||
                                Request::is('admin/dashboard') ? 'active' : ''
                                }}">
                        <i class="nav-icon fa fa-area-chart"></i>
                        <p>
                            Dashboard
                            {{--<span class="right badge badge-danger">New</span>--}}
                        </p>
                    </a>
                </li>
                {{--End Dashboard Admin--}}

                {{--Start User NGO--}}
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-check-circle-o"></i>
                        <p>
                            Users NGO/Verified
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a href="{{ url('admin/verified-user/create/') }}"
                               class="nav-link {{
                                Request::is('admin/verified-user/create/*') ? 'active' : '' ||
                                Request::is('admin/verified-user/create') ? 'active' : ''
                                }}">
                                <i class="fa fa-user-plus nav-icon"></i>
                                <p>Create a User NGO/Verified </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/verified-user/list/') }}"
                               class="nav-link {{
                                Request::is('admin/verified-user/list/*') ? 'active' : '' ||
                                Request::is('admin/verified-user/list') ? 'active' : ''
                                }}">
                                <i class="fa fa-th-list nav-icon"></i>
                                <p>List all User NGO/Verified </p>
                            </a>
                        </li>

                    </ul>
                </li>
                {{--End of User NGO--}}

                {{--Start of Campaign--}}
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-sticky-note"></i>
                        <p>
                            Campaigns
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a href="{{ url('admin/campaigns/create/') }}"
                               class="nav-link {{
                                Request::is('admin/campaigns/create/*') ? 'active' : '' ||
                                Request::is('admin/campaigns/create') ? 'active' : ''
                                }}">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>Create a campaign</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/campaigns/list-campaign/') }}"
                               class="nav-link {{
                                Request::is('admin/campaigns/list-campaign/*') ? 'active' : '' ||
                                Request::is('admin/campaigns/edit-campaign/*') ? 'active' : '' ||
                                Request::is('admin/campaigns/list-campaign') ? 'active' : ''
                                }}">
                                <i class="fa fa-th-list nav-icon"></i>
                                <p>List all campaign</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--End of Campaign--}}

                {{--Start Advertising--}}
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-dollar"></i>
                        <p>
                            Advertising
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="display: block;">
                        <li class="nav-item">
                            <a href="{{ url('admin/ads/create-advertiser/') }}"
                               class="nav-link {{
                                Request::is('admin/ads/create-advertiser/*') ? 'active' : '' ||
                                Request::is('admin/ads/create-advertiser') ? 'active' : ''
                                }}">
                                <i class="fa fa-user-plus nav-icon"></i>
                                <p>Create an Advertiser</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/ads/create-content/') }}"
                               class="nav-link {{
                                Request::is('admin/ads/create-content/*') ? 'active' : '' ||
                                Request::is('admin/ads/create-content') ? 'active' : ''
                                }}">
                                <i class="fa fa-plus-circle nav-icon"></i>
                                <p>Create an Ads content</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/ads/list-ads/') }}"
                               class="nav-link {{
                                Request::is('admin/ads/list-ads/*') ? 'active' : '' ||
                                Request::is('admin/ads/list-ads/*/*') ? 'active' : '' ||
                                Request::is('admin/ads/list-ads') ? 'active' : ''
                                }}">
                                <i class="fa fa-th-list nav-icon"></i>
                                <p>List all Ads</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--End of Advertising--}}



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>