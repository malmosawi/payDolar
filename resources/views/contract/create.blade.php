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
                <div class="card-header">
                    <h3 class="mb-0 card-title">وصل العقد</h3>
                </div>
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

                        @if (count($errors) > 0)
                            
                            @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-0 mb-3"><strong>{{ $error }}</strong></div>
                            @endforeach
                        
                        @endif
                    </center>

                    <form action="{{route('contract.store')}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">اسم الزبون</label>
                                    <select id="single" name="name" class="form-control @error('name') is-invalid state-invalid @enderror">
                                
                                        @foreach($customers as $key=>$customer)
                                        
                                            <option <?php if(old('name')==$customer->id) echo "selected"; ?> data-name="{{$customer->name}}" value="{{$customer->id}}">{{$customer->name}}</option>
                                            
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ</label>
                                    <input type="text" class="form-control @error('money') is-invalid state-invalid @enderror" name="money" id="money" value="{{ old('money') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف لكل 100 دولار</label>
                                    <input type="text" readonly class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{Session::get('exchange_rate')}}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">النسبة المضافة (%)</label>
                                    <input type="text" class="form-control @error('add_rate') is-invalid state-invalid @enderror" name="add_rate" id="add_rate" value="{{Session::get('add_rate')}}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">الدفع كل شهر بدولار</label>
                                    <input type="text" class="form-control @error('money_month') is-invalid state-invalid @enderror" name="money_month" id="money_month" value="{{ old('money_month') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">عدد اشهر التسديد</label>
                                    <input type="text" class="form-control @error('months_number') is-invalid state-invalid @enderror" name="months_number" id="months_number" value="{{ old('months_number') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ</label>
                                    <input type="text" class="form-control @error('date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="date" id="date" value="{{ old('date') }}" placeholder="اختر التاريخ">
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
    $(".contract").addClass("active");
    $(".mainPage").text("العقد");
    $(".subPage").text("إضافة");

    $(document).ready(function() {
        $('#money_month,#money').on("input" , function(){

            if($("#money").val()!="" && $("#money_month").val()!=""){
                $("#months_number").val(parseInt($("#money").val()) / parseInt($("#money_month").val()));
            }
            
        });

    });

</script>
@endsection