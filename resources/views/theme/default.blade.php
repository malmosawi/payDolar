<!DOCTYPE html>

<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="Hogo– Creative Admin Multipurpose Responsive Bootstrap4 Dashboard HTML Template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="html admin template, bootstrap admin template premium, premium responsive admin template, admin dashboard template bootstrap, bootstrap simple admin template premium, web admin template, bootstrap admin template, premium admin template html5, best bootstrap admin template, premium admin panel template, admin template"/>

		<!-- Favicon -->
		<link rel="icon" href="{{asset('assets/images/brand/favicon.ico')}}" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/brand/favicon.ico')}}" />

		<!-- Title -->
		<title>Pay Dolar</title>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">


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

		<!-- Data table css -->
		<link href="{{asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />

		
		<link href="{{asset('assets/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    	<link href="{{asset('assets/plugins/flatpickr/custom-flatpickr.css')}}" rel="stylesheet" type="text/css">

		<!-- File Uploads css-->
        <link href="{{asset('assets/plugins/fileuploads/css/dropify.css')}}" rel="stylesheet" type="text/css" />

		<link href="{{asset('assets/tail.select-default.css')}}" rel="stylesheet" type="text/css">

		<!---Sweetalert Css-->
		<!-- <link href="{{asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.css')}}" rel="stylesheet" />
		<link href="{{asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" /> -->

		<style>
			.tail-select .select-dropdown ul li.dropdown-option {
            text-align:right;
			}

			.tail-select {
				width: 100%;
				height:100%;
			}
			
			.tail-select .select-label .label-inner {
				text-align:right;
				
			}
		</style>
		<!-- Dashboard css -->
		<link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
		<!-- <link href="{{asset('assets/css/boxed.css')}}" rel="stylesheet" /> -->

		@yield('style') 
		
	</head>

	<body class="app sidebar-mini rtl">

		<!--Global-Loader-->
		<div id="global-loader">
			<img src="assets/images/icons/loader.svg" alt="loader">
		</div>

		<div class="page">
			<div class="page-main">

           @include('theme.header')
           @include('theme.Horizontal-menu')
           @include('theme.Header-submenu')

       <div id="container content-area">

          @yield('content') 

		  @include('theme.sidebar-user')

        </div>

		@include('theme.footer')

       <!-- /#page-wrapper -->

      </div>
    </div>

<div class="modal fade" data-backdrop="static" id="modal_profile" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header btn-primary">
              <h4 class="modal-title">تحديث الملف الشخصي</h4>
              <button type="button" class="close" data-dismiss="modal" >&times;</button>
          </div>

          <div class="modal-body">
              <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
              <div class="add-contact-box">
                  <div class="add-contact-content">
					<center>
						@if(session()->has('success'))

							<div class="alert alert-success text-center mt-2">{{session()->get('success')}}</div>

						@endif

						@if ($message = Session::get('error'))
						<div class="alert alert-danger alert-block mt-3 mb-0">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>{{ $message }}</strong>
						</div>
						@endif

						@if (count($errors) > 0)
							
							@foreach($errors->all() as $error)
							<div class="alert alert-danger mt-0 mb-3"><strong>{{ $error }}</strong></div>
							@endforeach
						
						@endif
					</center>

                      <form action="{{ route('profile', Auth::user()->id) }}" id="addContactModalTitle" autocomplete="off" class="appForm clearfix" method="post" enctype="multipart/form-data">
                      @csrf  
                          <div class="row">
                            
						  	<div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">الاسم</label>
                                    <input type="text" class="form-control @error('name') is-invalid state-invalid @enderror" name="name" id="name" value="{{ old('name')!=''? old('name') : Auth::user()->name }}" placeholder="">
                                </div>
                            </div>

							<div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">اسم المستخدم</label>
                                    <input type="text" class="form-control @error('username') is-invalid state-invalid @enderror" name="username" id="username" value="{{ old('username')!=''? old('username') : Auth::user()->username }}" placeholder="">
                                </div>
                            </div>

							<div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">كلمة السر الجديدة</label>
                                    <input type="password" class="form-control @error('password') is-invalid state-invalid @enderror" name="password" id="password" value="{{ old('password') }}" placeholder="">
                                </div>
                            </div>
                            
                          </div>

                          <div class="row" style="margin-bottom:5%;">
                              <div class="col-lg-2 col-2 mx-auto">
                                  
                                  <input type="submit" value="تعديل" name="submit" class="mt-4 btn btn-primary">                                     
                                  
                              </div>   

                          </div>

                      </form>
                  </div>
              </div>
          </div>
          
      </div>
  </div>
</div>

		<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

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

		<!-- File uploads js -->
		<script src="{{asset('assets/plugins/fileuploads/js/dropify.js')}}"></script>
		<script src="{{asset('assets/plugins/fileuploads/js/dropify-demo.js')}}"></script>


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

		<!-- Data tables js-->
		<script src="{{asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/datatable.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/datatable-2.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>

		
		<script src="{{asset('assets/plugins/flatpickr/flatpickr.js')}}"></script>
		<script src="{{asset('assets/plugins/flatpickr/custom-flatpickr.js')}}"></script>

		<script src="{{asset('assets/tail.select.min.js')}}"></script>

		<!-- Sweet alert js-->
		<!-- <script src="{{asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.js')}}"></script>
		<script src="{{asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
		<script src="{{asset('assets/js/sweet-alert.js')}}"></script> -->
		<script src="{{asset('assets/sweetalerts/sweetalert2.min.js')}}"></script>
		<script src="{{asset('assets/sweetalerts/custom-sweetalert.js')}}"></script>

		<!-- Custom js-->
		<script src="{{asset('assets/js/custom.js')}}"></script>
		<script>
			
			tail.select("#single", {
				deselect: true,
				placeholder: 'اختر...',
				multiShowCount: false,
				search: true
			});

			@if (count($errors) > 0 && session()->get('show')=='show_profile')
        		$('#modal_profile').modal('show');
			@endif
			$("button[data-dismiss=modal]").click(function(){
				$("#modal_profile").modal('hide');
			});
		</script>
		@yield('script') 

</body>



</html>


