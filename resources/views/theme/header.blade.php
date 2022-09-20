<!--app-header-->
<div class="app-header header hor-topheader d-flex">
	<div class="container">
		<div class="d-flex">
			<a class="header-brand" href="{{url('contract/create')}}">
				<img src="{{asset('assets/images/brand/refootourism.png')}}" class="header-brand-img main-logo" alt="Hogo logo">
				<img src="{{asset('assets/images/brand/refootourism.png')}}" class="header-brand-img icon-logo" alt="Hogo logo">
			</a><!-- logo-->
			<!-- <a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a> -->
			<!-- <a href="#" data-toggle="search" class="nav-link nav-link  navsearch"><i class="fa fa-search"></i></a>search icon -->
			<!-- <div class="header-form">
				<form class="form-inline">
					<div class="search-element ml-3">
						<input class="form-control" type="search" placeholder="Search" aria-label="Search">
						<span class="Search-icon"><i class="fa fa-search"></i></span>
					</div>
				</form>
			</div> -->
			
			<ul class="nav header-nav">

				<li class="nav-item dropdown header-option m-2">
					<a class="nav-link h4" href="{{ url('setting') }}">
						<i class="fe fe-settings ml-2"></i>الاعدادات
					</a>
				</li>
			</ul>

			<div class="d-flex order-lg-2 mr-auto header-rightmenu">
				<div class="dropdown">
					<a  class="nav-link icon full-screen-link" id="fullscreen-button">
						<i class="fe fe-maximize-2"></i>
					</a>
				</div><!-- full-screen -->
				<!-- <div class="dropdown header-notify">
					<a class="nav-link icon" data-toggle="dropdown" aria-expanded="false">
						<i class="fe fe-bell "></i>
						<span class="pulse bg-success"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
						<a href="#" class="dropdown-item text-center">4 New Notifications</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item d-flex pb-3">
							<div class="notifyimg bg-green">
								<i class="fe fe-mail"></i>
							</div>
							<div>
								<strong>Message Sent.</strong>
								<div class="small text-muted">12 mins ago</div>
							</div>
						</a>
						<a href="#" class="dropdown-item d-flex pb-3">
							<div class="notifyimg bg-pink">
								<i class="fe fe-shopping-cart"></i>
							</div>
							<div>
								<strong>Order Placed</strong>
								<div class="small text-muted">2  hour ago</div>
							</div>
						</a>
						<a href="#" class="dropdown-item d-flex pb-3">
							<div class="notifyimg bg-blue">
								<i class="fe fe-calendar"></i>
							</div>
							<div>
								<strong> Event Started</strong>
								<div class="small text-muted">1  hour ago</div>
							</div>
						</a>
						<a href="#" class="dropdown-item d-flex pb-3">
							<div class="notifyimg bg-orange">
								<i class="fe fe-monitor"></i>
							</div>
							<div>
								<strong>Your Admin Lanuch</strong>
								<div class="small text-muted">2  days ago</div>
							</div>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item text-center">View all Notifications</a>
					</div>
				</div> -->
				<!-- notifications -->
				<div class="dropdown header-user">
					<a class="nav-link leading-none siderbar-link"  data-toggle="sidebar-left" data-target=".sidebar-left">
						<span class="ml-3 d-none d-lg-block ">
							<span class="text-gray-white"><span class="mr-2">{{ Auth::user()->username }}</span></span>
						</span>
						<span class="avatar avatar-md brround"><img src="{{asset('assets/images/users/user.png')}}" alt="Profile-img" class="avatar avatar-md brround"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
						<div class="header-user text-center mt-4 pb-4">
							<span class="avatar avatar-xxl brround"><img src="{{asset('assets/images/users/female/33.png')}}" alt="Profile-img" class="avatar avatar-xxl brround"></span>
							<a href="#" class="dropdown-item text-center font-weight-semibold user h3 mb-0">Alison</a>
							<small>Web Designer</small>
						</div>

						<a class="dropdown-item" href="#">
							<i class="dropdown-icon mdi mdi-account-outline "></i> Spruko technologies
						</a>
						<a class="dropdown-item" href="#">
							<i class="dropdown-icon  mdi mdi-account-plus"></i> Add another Account
						</a>
						<div class="card-body border-top">
							<div class="row">
								<div class="col-6 text-center">
									<a class="" href=""><i class="dropdown-icon mdi  mdi-message-outline fs-30 m-0 leading-tight"></i></a>
									<div>Inbox</div>
								</div>
								<div class="col-6 text-center">
									<a class="" href=""><i class="dropdown-icon mdi mdi-logout-variant fs-30 m-0 leading-tight"></i></a>
									<div>Sign out</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- profile -->
				<div class="dropdown">
					<a  class="nav-link icon siderbar-link" data-toggle="sidebar-left" data-target=".sidebar-left">
						<i class="fe fe-more-horizontal"></i>
					</a>
				</div><!-- Right-siebar-->
			</div>
		</div>
	</div>
</div>
<!--app-header end-->
