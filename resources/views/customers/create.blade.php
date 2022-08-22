@extends('theme.default')

@section('style')
<style>

</style>
@endsection

@section('content')

<div class="side-app container">

    <!-- page-header -->
    <div class="page-header">
        <!-- <div class="mr-auto">
            <div class="input-group">
                <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('customers/create') }}"> إضافة زبون جديد <i class="fe fe-plus ml-1 mt-1"></i></a>
            </div>
        </div> -->
    </div>
    <!-- End page-header -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12">
        
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="mb-0 card-title">إضافة معلومات زبون جديد</h3>
                </div> -->
                <div class="card-body">

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

                        <!-- @if (count($errors) > 0)
                            
                            @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-0 mb-3"><strong>{{ $error }}</strong></div>
                            @endforeach
                        
                        @endif -->
                    </center>

                    <form action="{{route('customers.store')}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group pt-5">
                                    <label class="form-label">الاسم</label>
                                    <input type="text" class="form-control @error('name') is-invalid state-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">العنوان</label>
                                    <input type="text" class="form-control @error('address') is-invalid state-invalid @enderror" name="address" id="address" value="{{ old('address') }}" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="text" class="form-control @error('phone') is-invalid state-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}" placeholder="">
                                </div>

                            </div>

                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">العنوان</label>
                                    <input type="text" class="form-control @error('address') is-invalid state-invalid @enderror" name="address" id="address" value="{{ old('address') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="text" class="form-control @error('phone') is-invalid state-invalid @enderror" name="phone" id="phone" value="{{ old('phone') }}" placeholder="">
                                </div>
                            </div> -->

                            <div class="col-xl-6 col-lg-12 col-md-12">
								<div class="card shadow">
									<div class="card-header">
										<h3 class="mb-0 card-title">الصورة الشخصية</h3>
									</div>
									<div class="card-body">
										<input type="file" class="dropify @error('person_image') is-invalid state-invalid @enderror" name="person_image" id="person_image" />
									</div>
								</div>
							</div>

                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-label">الصورة الشخصية</div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('person_image') is-invalid state-invalid @enderror" name="person_image" id="person_image">
                                        <label class="custom-file-label">أختر الصورة</label>
                                    </div>
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">اسم الام</label>
                                    <input type="text" class="form-control @error('mother_name') is-invalid state-invalid @enderror" name="mother_name" id="mother_name" value="{{ old('mother_name') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">رقم الهوية</label>
                                    <input type="text" class="form-control @error('identification_number') is-invalid state-invalid @enderror" name="identification_number" id="identification_number" value="{{ old('identification_number') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">جهة اصدار الهوية</label>
                                    <input type="text" class="form-control @error('identification_version') is-invalid state-invalid @enderror" name="identification_version" id="identification_version" value="{{ old('identification_version') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ اصدار الهوية</label>
                                    <input type="text" class="form-control @error('identification_date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="identification_date" id="identification_date" value="{{ old('identification_date') }}" placeholder="اختر التاريخ">
                                </div>
                            </div>

                            <!-- <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">السنة</label>
                                    <input type="text" class="form-control @error('year') is-invalid state-invalid @enderror" name="year" id="year" value="{{ old('year') }}" placeholder="">
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">الوظيفة</label>
                                    <input type="text" class="form-control @error('job') is-invalid state-invalid @enderror" name="job" id="job" value="{{ old('job') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">دائرة الموظف</label>
                                    <input type="text" class="form-control @error('job_place') is-invalid state-invalid @enderror" name="job_place" id="job_place" value="{{ old('job_place') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المصرف</label>
                                    <input type="text" class="form-control @error('bank_name') is-invalid state-invalid @enderror" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" placeholder="">
                                </div>
                            </div>
                            

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">رمز البطاقة الذكية</label>
                                    <input type="text" class="form-control @error('card_password') is-invalid state-invalid @enderror" name="card_password" id="card_password" value="{{ old('card_password') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">رقم هاتف المجلس البلدي</label>
                                    <input type="text" class="form-control @error('phone_council') is-invalid state-invalid @enderror" name="phone_council" id="phone_council" value="{{ old('phone_council') }}" placeholder="">
                                </div>
                            </div>

                            
                            
                        </div>

                        <div class="row text-center">
                            <div class="col-sm-12">
                                
                                <input type="submit" value="حفظ" name="submit" class="mt-5 btn btn-primary">                                     
                                
                            </div>   
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
    <!-- row end -->


</div>
<!--End side-app  -->



@endsection

@section('script')
<script>
    $(".customers").addClass("active");
    $(".mainPage").text("الزبائن");
    $(".subPage").text("إضافة");
</script>
@endsection