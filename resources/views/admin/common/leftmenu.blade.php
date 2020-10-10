<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list" id="menu_acc">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>


                    <li class="nav-item">
                        <a class="nav-link {{ get_admin_menu_active_class($currentURI,['dashboard']) }}" href="{{ apa('dashboard') }}"><i class="fas fa-th-large"></i>Dashboard</a>
                    </li>

                    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Task','Manage Farm Deactivation Requests','Manage Farm Reactivation Requests']))
					<li class="nav-item ">
                        <a class="nav-link  collapsed" href="#submenu-admin-task" data-toggle="collapse" aria-expanded="false"  aria-controls="submenu-admin-task"><i class="fas fa-magic"></i>Admin Task</a>
                        <div id="submenu-admin-task" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">
							   @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Task']))
								<li class="nav-item">
									<a class="nav-link {{ get_admin_menu_active_class($currentURI,['task']) }}" href="{{ apa('task') }}"><i class="fas fa-tasks"></i>To Do List</a>
								</li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Deactivation Requests']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['deactivation-requests']) }}" href="{{ apa('deactivation-requests') }}"><i class="fas fa-thumbs-down"></i>Farm Deactivation Requests</a>
                                </li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Reactivation Requests']))
                                 <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['reactivation-requests']) }}" href="{{ apa('reactivation-requests') }}"><i class="fas fa-thumbs-up"></i>Farm Re-activation Requests</a>
                                </li>
								@endif
                            </ul>
                        </div>
                    </li>
					@endif

                    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Order','Manage Farm wise orders','Manage Farmer Payment','Manage Farmer Bank Details']))
					<li class="nav-item ">
                        <a class="nav-link  collapsed" href="#submenu-order-payout" data-toggle="collapse" aria-expanded="false"  aria-controls="submenu-order-payout"><i class="fas fa-warehouse"></i>Orders and Payouts </a>
                        <div id="submenu-order-payout" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">
							   @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Order']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['order-list']) }}" href="{{ apa('order-list') }}"><i class="fas fa-truck-loading"></i>Order</a>
                                </li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm wise orders']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farm-orders','farms-order-list']) }}" href="{{ apa('farm-orders') }}"><i class="fas fa-dolly"></i>Farm wise orders</a>
                                </li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farmer Payment']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farmer-orders','farmer-payment']) }}" href="{{ apa('farmer-orders') }}"><i class="fab fa-amazon-pay"></i>Farmer Payment</a>
                                </li>
                                @endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farmer Bank Details']))
								<li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farmer-bank-details','update-bank-details']) }}" href="{{ apa('farmer-bank-details') }}"><i class="fas fa-piggy-bank"></i>Pay out bank details </a>
                                </li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Product Request']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['product-request']) }}" href="{{ apa('product-request') }}"><i class="fas fa-lightbulb"></i>Product Inquiry</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
					@endif

                     @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Coupons', 'Manage Coupon Currency Rates']))
                    <li class="nav-item ">
                        <a class="nav-link  collapsed" href="#submenu-coupons" data-toggle="collapse" aria-expanded="false"  aria-controls="submenu-coupons"><i class="fas fa-warehouse"></i>Coupon Management </a>
                        <div id="submenu-coupons" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">
                               @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Coupons']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['coupons']) }}" href="{{ apa('coupons') }}"><i class="fas fa-truck-loading"></i>Coupons</a>
                                </li>
                                @endif
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Coupon Currency Rates']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['coupon-currency-rates']) }}" href="{{ apa('coupon-currency-rates') }}"><i class="fas fa-dolly"></i>Coupon Currency Rates</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Reviews','Manage Product Reviews','Manage Delivery feedback']))
                    <li class="nav-item ">
                        <a class="nav-link  collapsed" href="#submenu-5" data-toggle="collapse" aria-expanded="false"  aria-controls="submenu-5"><i class="fas fa-indent"></i>Reviews</a>
                        <div id="submenu-5" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">

								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Reviews']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farm-review']) }}" href="{{ apa('farm-review') }}"><i class="fas fa-keyboard"></i>Farm Reviews</a>
                                </li>
                                @endif @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Product Reviews']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['product-review']) }}" href="{{ apa('product-review') }}"><i class="fas fa-keyboard"></i>Product Reviews</a>
                                </li>
                                @endif
                                <?php /* @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Delivery']))
<li class="nav-item">
<a class="nav-link {{ get_admin_menu_active_class($currentURI,['delivery-list']) }}" href="{{ apa('delivery-list') }}"><i class="fas fa-chart-pie"></i>Manage Delivery</a>
</li>
@endif */?>
								 @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Delivery feedback']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['delivery-feedback']) }}" href="{{ apa('delivery-feedback') }}"><i class="fas fa-random"></i>Delivery feedback</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif

					@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm','Manage Product Request','Manage Farm visit Request','Manage Farmsgate Delivery','Manage Contact']))
                    <li class="nav-item ">
                        <a class="nav-link  collapsed" href="#submenu-4" data-toggle="collapse" aria-expanded="false"  aria-controls="submenu-4"><i class="fas fa-chess-board"></i>Farms</a>
                        <div id="submenu-4" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">
							    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farm-manager']) }}" href="{{ apa('farm-manager') }}"><i class="fas fa-seedling"></i>Listed Farms</a>
                                </li>
								@endif

								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm visit Request']))
								<li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farm-visit-request']) }}" href="{{ apa('farm-visit-request') }}"><i class="fas fa-street-view"></i>Farm visit Request</a>
                                </li>
								@endif
							    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farmsgate Delivery']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['fg-delivery-list']) }}" href="{{ apa('fg-delivery-list') }}"><i class="fas fa-truck-moving"></i>Farmsgate Delivery</a>
                                </li>
                                @endif
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Contact']))
								<li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['contact-request']) }}" href="{{ apa('contact-request') }}"><i class="fas fa-comment-dots"></i>Contact Request</a>
                                </li>
								<li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['notify-request']) }}" href="{{ apa('notify-request') }}"><i class="fas fa-calendar-check"></i>Notify Request</a>
                                </li>
                                @endif
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Legal Documents']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farm-documents']) }}" href="{{ apa('farm-documents') }}"><i class="fas fa-file-pdf"></i>Farm Legal Documents</a>
                                </li>
                                @endif

                                <?php /*
@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Product']))
<li class="nav-item">
<a class="nav-link {{ get_admin_menu_active_class($currentURI,['product']) }}" href="{{ apa('product') }}"><i class="fas fa-chart-pie"></i>Product Manager</a>
</li>
@endif
 */?>

                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Produce','Manage Suggested Crops','Manage Types of Goods']))
                    <li class="nav-item ">
                        <a class="nav-link  collapsed" href="#submenu-2" data-toggle="collapse" aria-expanded="false"  aria-controls="submenu-2"><i class="fas fa-table"></i>Farm Produce</a>
                        <div id="submenu-2" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">
							    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Produce']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['agriculture_manager']) }}" href="{{ apa('agriculture_manager') }}"><i class="fas fa-table"></i>Farm Produce</a>
                                </li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Suggested Crops']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farmer-suggested-crops']) }}" href="{{ apa('farmer-suggested-crops') }}"><i class="fas fa-leaf"></i>Farmer Suggested Crops</a>
                                </li>
								@endif
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Types Of Goods']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['types-of-goods']) }}" href="{{ apa('types-of-goods') }}"><i class="fas fa-boxes"></i>Types of Goods</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
					@endif

					@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Type','Manage Farm Category','Manage Product Type','Manage My Farm','Manage Facilities','Manage Quick Facts']))
                    <li class="nav-item ">
                        <a class="nav-link collapsed" href="#submenu-1" data-toggle="collapse" aria-expanded="false"  aria-controls="submenu-1 "><i class="fas fa-sign"></i>Farm Basics</a>
                        <div id="submenu-1" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">
							   @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Type']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['category_manager']) }}" href="{{ apa('category_manager') }}"><i class="fas fa-sun"></i>Farm Type</a>
                                </li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Farm Category']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farming-category']) }}" href="{{ apa('farming-category') }}"><i class="fas fa-code-branch"></i>Category of Farm</a>
                                </li>
								@endif
								<?php /* @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Product Type']))
<li class="nav-item">
<a class="nav-link {{ get_admin_menu_active_class($currentURI,['agriculture_type']) }}" href="{{ apa('agriculture_type') }}"><i class="fas fa-chart-pie"></i>Product Type</a>
</li>
@endif */?>
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage My Farm']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farming-architecture']) }}" href="{{ apa('farming-architecture') }}"><i class="fas fa-warehouse"></i>My Farm</a>
                                </li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Facilities']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['facility_manager']) }}" href="{{ apa('facility_manager') }}"><i class="fas fa-cube"></i>Facilities Manager</a>
                                </li>
								@endif
								@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Quick Facts']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['farming-category-attributes']) }}" href="{{ apa('farming-category-attributes') }}"><i class="fas fa-info-circle"></i>Quick facts</a>
                                </li>
								@endif
                            </ul>
                        </div>
                    </li>
					@endif

                    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Admin Users List','Manage Employee','Manage Users','Manage Farmer Bank Details', 'Manage Roles']))
                    <li class="nav-item ">
                        <a class="nav-link  collapsed" href="#submenu-6" data-toggle="collapse" aria-expanded="false" aria-controls="submenu-6"><i class="fa fa-fw fa-user-circle"></i>Users</a>
                        <div id="submenu-6" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Admin Users List']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['admin_users']) }}" href="{{ apa('admin_users') }}"><i class="fas fa-user-secret"></i>Admin Users</a>
                                </li>
                                @endif
                               <?php /*  @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Employee']))
<li class="nav-item">
<a class="nav-link {{ get_admin_menu_active_class($currentURI,['employee']) }}" href="{{ route('employee') }}"><i class="fas fa-chart-pie"></i>Employees</a>
</li>
@endif */?>
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Users']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['users']) }}" href="{{ apa('users') }}"><i class="fas fa-user"></i>Users</a>
                                </li>
                                @endif

                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Roles']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['roles']) }}" href="{{ apa('roles') }}"><i class="fas fa-street-view"></i>Roles</a>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </li>
                    @endif

                    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Info Section','Manage About Us','Manage Faq','Manage How Its Works','Manage Legal Documents','Manage Banner']))
                    <li class="nav-item ">
                        <a class="nav-link  collapsed" href="#submenu-cms" data-toggle="collapse" aria-expanded="false"  aria-controls="submenu-cms"><i class="fas fa-sitemap"></i>CMS</a>
                        <div id="submenu-cms" class="submenu collapse " data-parent="#menu_acc" style="">
                            <ul class="nav flex-column">
                               @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Info Section']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['infosections']) }}" href="{{ apa('post/infosections') }}"><i class="fas fa-file-alt"></i>Home Info Sections</a>
                                </li>
                                @endif
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage About Us']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['about_us']) }}" href="{{ apa('post/about_us') }}"><i class="fas fa-file-alt"></i>About Us</a>
                                </li>
                                @endif
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage How Its Works']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['how-its-work']) }}" href="{{ apa('post/how-its-work') }}"><i class="fas fa-file-alt"></i>How Its Works</a>
                                </li>
                                @endif
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Faq']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['faq']) }}" href="{{ apa('post/faq') }}"><i class="fas fa-file-alt"></i>FAQ</a>
                                </li>
                                @endif
                                @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Banner']))
                                <li class="nav-item">
                                    <a class="nav-link {{ get_admin_menu_active_class($currentURI,['banners']) }}" href="{{ apa('post/banners') }}"><i class="fas fa-image"></i>{{ lang('banners') }}</a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif

					@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Log']))
                    <li class="nav-item">
                        <a class="nav-link {{ get_admin_menu_active_class($currentURI,['audit_logs']) }}" href="{{ apa('audit_logs') }}"><i class="fas fa-th-list"></i>User Audit Logs</a>
                    </li>
                    @endif

					@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Notifications']))
                    <li class="nav-item">
                        <a class="nav-link {{ get_admin_menu_active_class($currentURI,['user-notification']) }}" href="{{ apa('user-notification') }}"><i class="fas fa-bell"></i>Notifications</a>
                    </li>
					@endif

                    @if(Auth::user() && Auth::user()->hasAnyPermission(['Menu Manager']))
                    <li class="nav-item">
                        <a class="nav-link {{ get_admin_menu_active_class($currentURI,['menu_manager']) }}" href="{{ apa('menu_manager') }}"><i class="fas fa-sitemap"></i>Menu Manager</a>
                    </li>
                    @endif

					@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Country']))
                    <li class="nav-item">
                        <a class="nav-link {{ get_admin_menu_active_class($currentURI,['country']) }}" href="{{ apa('country') }}"><i class="fas fa-globe"></i>Country</a>
                    </li>
					@endif



					@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Settings']))
                    <li class="nav-item">
                        <a class="nav-link {{ get_admin_menu_active_class($currentURI,['setting']) }}" href="{{ apa('setting') }}"><i class="fas fa-cogs"></i>Setting</a>
                    </li>
                    @endif

                    @if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Permissions']))
                    <li class="nav-item">
                        <a class="nav-link {{ get_admin_menu_active_class($currentURI,['permissions']) }}" href="{{ apa('permissions') }}"><i class="fas fa-lock"></i>Permissions</a>
                    </li>
                    @endif

                </ul>
            </div>
        </nav>
    </div>
</div>