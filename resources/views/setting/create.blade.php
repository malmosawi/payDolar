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
                    <h3 class="mb-0 card-title">اعدادات سعر صرف الدولار</h3>
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

                    @foreach($settings as $key=>$setting)

                    <form action="{{route('setting.store')}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف (بالدينار)</label>
                                    <input type="text" class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{ old('exchange_rate')!=''? old('exchange_rate') : $setting->exchange_rate }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">نسبة الاضافة (%)</label>
                                    <input type="text" class="form-control @error('add_rate') is-invalid state-invalid @enderror" name="add_rate" id="add_rate" value="{{ old('add_rate')!=''? old('add_rate') : $setting->add_rate }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدولار</label>
                                    <input type="text" readonly class="form-control @error('dolar_box') is-invalid state-invalid @enderror" name="dolar_box" id="dolar_box" value="{{ old('dolar_box')!=''? old('dolar_box') : $setting->dolar_box }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدينار</label>
                                    <input type="text" readonly class="form-control @error('dinar_box') is-invalid state-invalid @enderror" name="dinar_box" id="dinar_box" value="{{ old('dinar_box')!=''? old('dinar_box') : $setting->dinar_box }}" placeholder="">
                                </div>
                            </div>
                            
                        </div>

                        <div class="row text-center">
                            <div class="col-sm-12">
                                
                                <input type="submit" value="تحديث" name="submit" class="mt-5 btn btn-primary">                                     
                                
                            </div>   
                        </div>

                    </form>
                    @endforeach
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
    // $(".customers").addClass("active");
    $(".mainPage").text("الاعدادات");
    $(".subPage").text("");

    $(document).ready(function() {
    
        $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));
        $("#dolar_box").val(numberWithCommas($("#dolar_box").val() ));
        $("#dinar_box").val(numberWithCommas($("#dinar_box").val() ));
        
        $('#exchange_rate').on("change" , function(){
            $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));
        });

    });
</script>
@endsection