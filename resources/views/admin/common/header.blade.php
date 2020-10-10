<?php if( Auth::user() ){ ?>
    <div class="dashboard-header">
        <nav class="navbar navbar-expand-lg bg-white fixed-top">
            <a target="_blank" class="navbar-brand adminHeaderSiteName" href="{{ URL::to('/') }}">{{{ @$admin_settings->sitename }}}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-right-top">
                    <li class="nav-item dropdown nav-user">
                        <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('assets/admin/images/no-user.png') }}" alt="" class="user-avatar-md rounded-circle"></a>
                        <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                            <div class="nav-user-info">
                                <h5 class="mb-0 text-white nav-user-name">{{  Auth::user()->username }}</h5>
                                <span class="status"></span><span class="ml-2">Available</span>
                            </div>
                            <a class="dropdown-item" href="{{ URL::to(\Config::get('app.admin_prefix').'/change_password') }}"><i class="fas fa-user mr-2"></i>Change Password</a>
                            @if(Auth::user() && Auth::user()->hasAnyRole(['Super Admin'])) 
                                <!-- <a class="dropdown-item" href="{{ URL::to(\Config::get('app.admin_prefix').'/settings') }}"><i class="fas fa-cog mr-2"></i>Setting</a> -->
                            @endif
                            <a class="dropdown-item" href="{{ URL::to(\Config::get('app.admin_prefix').'/logout') }}"><i class="fas fa-power-off mr-2"></i>Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
<?php } ?>