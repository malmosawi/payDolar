<!DOCTYPE html>

<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- <meta content="Hogo– Creative Admin Multipurpose Responsive Bootstrap4 Dashboard HTML Template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="html admin template, bootstrap admin template premium, premium responsive admin template, admin dashboard template bootstrap, bootstrap simple admin template premium, web admin template, bootstrap admin template, premium admin template html5, best bootstrap admin template, premium admin panel template, admin template"/> -->
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="no-cache">
		<meta http-equiv="Expires" content="-1">
		<meta http-equiv="Cache-Control" content="no-cache">
		
		<!-- Favicon -->
		<link rel="icon" href="{{asset('assets/images/brand/favicon.ico')}}" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/brand/favicon.ico')}}" />

		<!-- Title -->
		<title>بيع الدولار</title>

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

		<!-- <script src="{{asset('assets/sweetalerts/sweetalert2.min.js')}}"></script>
		<script src="{{asset('assets/sweetalerts/custom-sweetalert.js')}}"></script> -->
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

			.table tbody .mstofy{
				background-color: #f4f3f9 !important; 
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
		@include('sweetalert::alert')

		<!-- Custom js-->
		<script src="{{asset('assets/js/custom.js')}}"></script>
		<script>

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

const TableScales =["","ألف","مليون","مليار","ترليون","كوادرليون","كوينتليون","سكستليون"], // Add here only
      TableScalesP=["","آلاف","ملايين","مليارات"], // Do not change this table
      TableMale   =["","واحد","اثنان","ثلاثة","أربعة","خمسة","ستة","سبعة","ثمانية","تسعة","عشرة"],
      TableFemale =["","واحدة","اثنتان","ثلاث","أربع","خمس","ست","سبع","ثمان","تسع","عشر"];

function nArabicWords(NumIn=0,{Feminine,Comma,SplitHund,Miah,Billions,TextToFollow,AG,Subject,Legal}={}) {
if (NumIn == 0) return "صفر";                          // if 0 or "0" then "zero"
let Triplet, Scale, ScalePos, ScalePlural, TableUnits, Table11_19,NumberInWords= "",IsLastEffTriplet= false,Num_99;
const ON= "on",                         // Flag to test if Option is ON
 IsAG   = (AG===ON),                    // Option Accusative or Genitive case Grammar?
 SpWa   = " و",                         // AND word
 TanweenLetter = "ًا",                   // Tanween Fatih for Scale Names above 10
 Ahad  = "أحد", Ehda= "إحدى",           // Masculine/Feminine 11
 // ---- Setup constants for the AG Option (Accusative/Genitive or Nominative case Grammar)
 Taa   = IsAG ?"تي" :"تا",       Taan   = IsAG ? "تين":"تان",        // Hundred 2's مئتا/مائتا مئتان/مائتان
 Aa    = IsAG ?"ي" :"ا",         Aan    = IsAG ? "ين":"ان",          // Scale 2's الفا/مليونا الفان/مليونان
 Ethna = IsAG ?"اثني":"اثنا",    Ethnata = IsAG ? "اثنتي" : "اثنتا", // Masculine/Feminine 12 starting word
 Ethnan= IsAG ?"اثنين" : "اثنان",Ethnatan= IsAG ? "اثنتين" :"اثنتان",// Masculine/Feminine 2
 Woon  = IsAG ?"ين" :"ون",              // Second part of 20's to 90's
 IsSubject = Array.isArray(Subject) && Subject.length===4;        // Check for Subject Array Names

TextToFollow = TextToFollow === ON;     // TextToFollow Option Flag
if(IsSubject) TextToFollow = false;     // Disable TextToFollow Option if Subject Option is ON
NumIn+="";                              // Make numeric string
NumIn =""+NumIn.replace(/[٠-٩]/g, d => "٠١٢٣٤٥٦٧٨٩".indexOf(d)); // Convert Arabic-Indic Numbers to Arabic if any
Miah= (Miah===ON) ? "مئة" : "مائة";     // Select chosen Miah (Hundred) Option

TableUnits   = [...TableMale]; Table11_19= [...TableMale]; // Create copies of Masculine Table for manipulation
Table11_19[0]= TableFemale[10];         // Borrow word "عشرة" from Feminine's Table for use in 11-19
Table11_19[1]= Ahad;                    // Masculine starting words for 11
Table11_19[2]= Ethna;                   // Masculine starting words for 12
TableUnits[2]= Ethnan;                  // Masculine word for 2

NumIn = "0".repeat(NumIn.length * 2 % 3) + NumIn;        // Convert Number to a Triplets String

let NumLen = NumIn.length;
for (let digits= NumLen; digits>0; digits-=3) {          // Loop and convert each Triplet
  Triplet = +NumIn.substr(NumLen-digits,3);              // Get a Triplet Number
  IsLastEffTriplet= !+NumIn.substr(NumLen-digits+3);     // Determine if Last Effective Triplet
  if (Triplet) {                                         // If not Empty: Convert Triplet Number to Words
    ScalePos    = digits/3-1;                            // Position of Scale Name in Scale Table
    Scale       = TableScales[ScalePos];                 // Get Scale Name
    ScalePlural = (ScalePos<4 ? TableScalesP[ScalePos] : TableScales[ScalePos] + "ات"); // Make Scale Plural
    if (Billions && ScalePos===3) Scale="بليون", ScalePlural="بلايين";    // If Billions Option
    NumberInWords += oneTripletToWords();                                 // Convert 1 Triplet to Words
    if (!IsLastEffTriplet) NumberInWords+= (Comma===ON ? "،" :"") + SpWa; // Add "و " and Option Comma
  }
} // All done with conversion, Process Subject Name if any
let SubjectName="";
if (IsSubject) {                                          // Process Subject Name
  let space   = !IsLastEffTriplet ? "" : " ";             // Position correct spacing
  Triplet     = +(Triplet+"").slice(-2);                  // Get last 2 digits of last Triplet
  SubjectName = space + Subject[0];                       // Default Subject Name is at Pos 0
  if (Triplet>10)      SubjectName = space + Subject[3];  // Subject name with Tanween for 11-99
  else if (Triplet>2)  SubjectName = space + Subject[2];  // Subject name Plural for 3-10
  else if (Triplet>0)  SubjectName = Subject[Triplet-1]+" "+TableUnits[Num_99];  // Reverse names for 1 or 2
}
 return NumberInWords + SubjectName;                      // All done
//------------------------------------------------------------------
//    Core Function Converts 1 Triplet (1 to 999) to Arabic Words
//------------------------------------------------------------------
function oneTripletToWords() {
    Num_99   = Triplet % 100;               // 00 to 99
let Num_100  = ~~(Triplet/100),             // Hundreds (1 digit)
    Num_Unit = Num_99 % 10,                 // 0 to 9 (1 digit)
    Num_Tens = ~~(Num_99/10),               // Tens   (1 digit)
    Word_100 = "", Word_99= "";             // Holds words for Hundreds & 0-99

if (Feminine === ON && IsLastEffTriplet)  { // If Feminine, use the Feminine table if Last Effective Triplet
  TableUnits   = [...TableFemale]; Table11_19= [...TableFemale];// Create copies of Feminine Table for manipulation
  Table11_19[0]= TableMale[10];             // Borrow word "عشر" from Masculine's Table for use in 11-19
  Table11_19[1]= Ehda;                      // Feminine starting words for 11
  Table11_19[2]= Ethnata;                   // Feminine starting words for 12
  TableUnits[2]= Ethnatan;                  // Feminine word for 2
  if (Num_99 > 19) TableUnits[1] = Ehda;    // Feminine word for 1 used in 20's to 90's
}

if (Num_100) {                              // ---- Do Hundreds (100 to 900)
 if (Num_100 >2) Word_100 = TableFemale[Num_100] + (SplitHund===ON ?" ":"") + Miah;// 300-900
 else if (Num_100 === 1) Word_100 = Miah;                                          // 100
 else Word_100 = Miah.slice(0,-1) +(Scale && !Num_99 || TextToFollow ?Taa:Taan);   // 200 Use either مئتا or مئتان
}

if (Num_99 >19)  Word_99 = TableUnits[Num_Unit] + (Num_Unit ? SpWa : "") +  // 20-99 Units و and
                 (Num_Tens === 2 ? "عشر" : TableFemale[Num_Tens]) + Woon;   // Add Woon for 20's or 30's to 90's
 else if (Num_99 > 10) Word_99 = Table11_19[Num_99-10] + " " + Table11_19[0]; // 11-19
 else if (Num_99>2 || !Num_99 || !IsSubject) Word_99 = TableUnits[Num_99];  // 0 or 3-10 (else keep void for 1 &2)

let Words999 = Word_100 + (Num_100 && Num_99 ? SpWa:"") + Word_99;          // Join Hund, Tens, and Units

if (Scale) {                                                                // Add Scale Name if applicable
  let legalTxt   = (Legal===ON && Num_99< 3)? " " + Scale : "";             // if Legal Option add Extra Word
  let Word_100Wa = (Num_100 ? Word_100 + legalTxt + SpWa :"") + Scale;      // Default Scale Name
  if (Num_99 > 2) {
    Words999 += " " +                                                       // Scale for for 3 to 99
    (Num_99 >10 ? Scale + (IsLastEffTriplet && TextToFollow ? "":TanweenLetter)// Scale for 11 to 99 (Tanween)
    : ScalePlural);                                                         // Scale for 3 to 10 (Plural)
  } else {
    if (!Num_99)           Words999 += " " +Scale;                          // Scale for 0
    else if (Num_99 === 1) Words999  = Word_100Wa;                          // Scale for 1
    else Words999 = Word_100Wa + (IsLastEffTriplet && TextToFollow ? Aa : Aan);// Scale for 2 ألفا or ألفان
    }
}
return Words999; //Return the Triple in Words
}

}


			
			tail.select("#single", {
				deselect: true,
				placeholder: 'اختر...',
				multiShowCount: false,
				search: true,
				descriptions: true
			});

			@if (count($errors) > 0 && session()->get('show')=='show_profile')
        		$('#modal_profile').modal('show');
			@endif
			$("button[data-dismiss=modal]").click(function(){
				$("#modal_profile").modal('hide');
			});

			$("button[data-dismiss=modal]").click(function(){
				$("#modal_month_store").modal('hide');
			});

			$("button[data-dismiss=modal]").click(function(){
				$("#modal_month_update").modal('hide');
			});
		</script>
		@yield('script') 

</body>



</html>


