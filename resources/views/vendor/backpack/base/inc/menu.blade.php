<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- =================================================== -->
        <!-- ========== Top menu items (ordered left) ========== -->
        <!-- =================================================== -->

        <!--<li><a href="{{ url('/') }}"><i class="fa fa-home"></i> <span>Home</span></a></li> -->

        <!-- ========== End of top menu left items ========== -->
    </ul>
</div>


<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- ========================================================= -->
      <!-- ========== Top menu right items (ordered left) ========== -->
      <!-- ========================================================= -->

      <!--<li><a href="{{ url('/') }}"><i class="far fa-alert"></i> <span>Home</span></a></li>-->
	<!--<li>
	<!--<div class="nav-item">
        	<!--<a class="nav-link" href="#" target="_blank" rel="noopener" aria-label="GitHub">
            	<i class="fa fa-lg fa-bell"></i>
            	<span class="notification-badge badge badge-danger" style="background-color: red;
    font-size: 12px;
    color: white;
    text-align: center;
    width:20px;
    height:20px;
    border-radius: 35%;
    position: absolute; /* changed */
    top: 2px; /* changed */
    left: 28px; /* changed */">1</span>
        	</a>-->
    	<!--	</div>-->
	<!--</li>-->



	@if (config('backpack.base.setup_auth_routes'))
	<!-- @if (auth('associations')->check())

                                <li><a href="{{ route('backpack.auth.logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
        @else
                            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.login') }}</a></li>

        @endif-->

        @if (backpack_auth()->guest())
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.login') }}</a></li>
            @if (config('backpack.base.registration_open'))
            <li><a href="{{ route('backpack.auth.register') }}">{{ trans('backpack::base.register') }}</a></li>
            @endif
        @else
            <li><a href="{{ route('backpack.auth.logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
        @endif
	@endif


	<!--@if (auth('associations')->check())
		    
				<li><a href="{{ route('backpack.auth.logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('backpack::base.logout') }}</a></li>
	@else             
			    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/login') }}">{{ trans('backpack::base.login') }}</a></li>
	
	@endif-->
       <!-- ========== End of top menu right items ========== -->
    </ul>
</div>


