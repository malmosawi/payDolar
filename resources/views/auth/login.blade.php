<!DOCTYPE html>

<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
		<!-- Favicon -->
		<link rel="icon" href="{{asset('assets/images/brand/favicon.ico')}}" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/brand/favicon.ico')}}" />

		<!-- Title -->
		<title>بيع الدولار</title>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">

		<!-- Dashboard css -->
		<link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/css/boxed.css')}}" rel="stylesheet" />

		<!-- Custom scroll bar css-->
		<link href="{{asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />

		<!-- Horizontal-menu css -->
		<link href="{{asset('assets/plugins/horizontal-menu/dropdown-effects/fade-down.css')}}" rel="stylesheet">
		<link href="{{asset('assets/plugins/horizontal-menu/horizontalmenu.css')}}" rel="stylesheet">

		<!--Daterangepicker css-->
		<link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />

		<!-- Rightsidebar css -->
		<link href="{{asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

		<!-- Sidebar Accordions css -->
		<link href="{{asset('assets/plugins/accordion1/css/easy-responsive-tabs.css')}}" rel="stylesheet">

		<!-- Owl Theme css-->
		<link href="{{asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">

		<!-- Morris  Charts css-->
		<link href="{{asset('assets/plugins/morris/morris.css')}}" rel="stylesheet" />

		<!---Font icons css-->
		<link href="{{asset('assets/plugins/iconfonts/plugin.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/iconfonts/icons.css')}}" rel="stylesheet" />
		<link  href="{{asset('assets/fonts/fonts/font-awesome.min.css')}}" rel="stylesheet">

	</head>

	<body class="app sidebar-mini rtl">

		<!--Global-Loader-->
		<div id="global-loader">
			<img src="assets/images/icons/loader.svg" alt="loader">
		</div>

		<div class="page" style="margin-top: 5%;">
			<div class="page-main">

                <div id="container content-area">

                    <div class="container">
                        <div class="row align-items-center flex-row-reverse">
                            <div class="col-lg-12">

                                <div class="row justify-content-center" style="margin-top: 60px; margin-bottom: 30px;">
                                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <center>

													<div class="text-center mb-6">
														<img src="{{asset('assets/images/brand/refootourism.png')}}" class="" alt="">
													</div>
													<!-- <h3>Login</h3> -->
													<!-- <p class="text-muted">Sign In to your account</p> -->

                                                    @if ($message = Session::get('error'))

                                                    <div class="alert alert-danger alert-block mt-0 mb-3">
                                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                                        <strong>{{ $message }}</strong>
                                                    </div>
                                                    @endif

                                                    @if (count($errors) > 0)
                                                        
                                                        @foreach($errors->all() as $error)
                                                        <div class="alert alert-danger mt-0 mb-3"><strong>{{ $error }}</strong></div>
                                                        @endforeach
                                                    
                                                    @endif

                                                    <form method="POST" action="{{ route('checklogin') }}" enctype="application/x-www-form-urlencoded">
                                                    @csrf
                                                    
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-addon bg-white"><i class="fa fa-user"></i></span>
                                                            <input  id="username" type="text" class="form-control" placeholder="أسم المستخدم" name="username" :value="old('username')" required autofocus >
                                                        </div>
                                                        <div class="input-group mb-4">
                                                            <span class="input-group-addon bg-white"><i class="fa fa-unlock-alt"></i></span>
                                                            <input id="password" class="form-control" placeholder="الباسورد" type="password" name="password" required autocomplete="current-password">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-primary btn-block">{{ __('تسجيل الدخول') }}</button>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="mt-6 btn-list">
                                                            <button type="button" class="btn btn-icon btn-facebook"><i class="fa fa-facebook"></i></button>
                                                            <button type="button" class="btn btn-icon btn-instagram"><i class="fa fa-instagram"></i></button>
                                                        </div> -->

                                                    </form>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <!--footer-->
                    <footer class="footer">
						<div class="container">
							<div class="row align-items-center flex-row-reverse">
								<div class="col-lg-12 col-sm-12   text-center">
									Copyright © {{ now()->year }}. Designed by <a href="https://www.ubc.com/">UBC</a> All rights reserved.
								</div>
							</div>
						</div>
					</footer>
                    <!-- End Footer-->

                </div>

            <!-- /#page-wrapper -->

            </div>
        </div>

		<!-- Jquery js-->
		<script src="{{asset('assets/js/vendors/jquery-3.2.1.min.js')}}"></script>

		<!--Bootstrap.min js-->
		<script src="{{asset('assets/plugins/bootstrap/popper.min.js')}}"></script>
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

		<!--Jquery Sparkline js-->
		<script src="{{asset('assets/js/vendors/jquery.sparkline.min.js')}}"></script>

		<!-- Chart Circle js-->
		<script src="{{asset('assets/js/vendors/circle-progress.min.js')}}"></script>

		<!-- Star Rating js-->
		<script src="{{asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>

		<!--Moment js-->
		<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>

		<!-- Daterangepicker js-->
		<script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

		<!-- Horizontal-menu js -->
		<script src="{{asset('assets/plugins/horizontal-menu/horizontalmenu.js')}}"></script>

		<!-- Sidebar Accordions js -->
		<script src="{{asset('assets/plugins/accordion1/js/easyResponsiveTabs.js')}}"></script>

		<!-- Custom scroll bar js-->
		<script src="{{asset('assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js')}}"></script>

		<!--Owl Carousel js -->
		<script src="{{asset('assets/plugins/owl-carousel/owl.carousel.js')}}"></script>
		<script src="{{asset('assets/plugins/owl-carousel/owl-main.js')}}"></script>

		<!-- Rightsidebar js -->
		<script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>

		<!-- Charts js-->
		<script src="{{asset('assets/plugins/chart/chart.bundle.js')}}"></script>
		<script src="{{asset('assets/plugins/chart/utils.js')}}"></script>

		<!--Time Counter js-->
		<script src="{{asset('assets/plugins/counters/jquery.missofis-countdown.js')}}"></script>
		<script src="{{asset('assets/plugins/counters/counter.js')}}"></script>

		<!--Morris  Charts js-->
		<script src="{{asset('assets/plugins/morris/raphael-min.js')}}"></script>
		<script src="{{asset('assets/plugins/morris/morris.js')}}"></script>

		<!-- Custom-charts js-->
		<script src="{{asset('assets/js/index1.js')}}"></script>

		<!-- Custom js-->
		<script src="{{asset('assets/js/custom.js')}}"></script>

</body>



</html>
