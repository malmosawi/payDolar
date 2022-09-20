@extends('theme.default')

@section('style')
<style>

</style>
@endsection

@section('content')

<div class="side-app container">

    <!-- page-header -->
    
    <!-- End page-header -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12">
        
            <div class="card">
                <div class="card-header">
                    <div class="mr-auto">
                        <div class="input-group">
                            <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('disexpenses/') }}"> صرف المصاريف <i class="fe fe-list ml-1 mt-1"></i></a>
                        </div>
                    </div>
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

                        <!-- @if (count($errors) > 0)
                            
                            @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-0 mb-3"><strong>{{ $error }}</strong></div>
                            @endforeach
                        
                        @endif -->
                    </center>

                    <form action="{{route('disexpenses.store')}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">اسم المصروف</label>
                                    <select id="single" name="expenses_name" class="form-control @error('expenses_name') is-invalid state-invalid @enderror">
                                
                                        @foreach($expenses as $key=>$expens)
                                        
                                            <option <?php if(old('expenses_name')==$expens->id) echo "selected"; ?> value="{{$expens->id}}">{{$expens->expenses_name}}</option>
                                            
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">المبلغ (بالدينار)</label>
                                    <select id="money" name="money" class="custom-select @error('money') is-invalid state-invalid @enderror">
                                        <option selected disabled value="">اختر...</option>
                                    </select>
                                </div>
                            </div> -->
                            <?php
                                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                            ?>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف لكل 100 دولار</label>
                                    <input type="text" class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{Session::get('exchange_rate')}}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدينار</label>
                                    <input type="text" readonly class="form-control @error('dinar_box') is-invalid state-invalid @enderror" name="dinar_box" id="dinar_box" value="{{ $money_setting }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ المصروف (بالدينار)</label>
                                    <input type="text" class="form-control @error('money') is-invalid state-invalid @enderror" name="money" id="money" value="{{ old('money') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ</label>
                                    <input type="text" class="form-control @error('date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="date" id="date" value="{{ old('date')!=''?  old('date') : Date('Y-m-d') }}" placeholder="اختر التاريخ">
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
    $(".disexpenses").addClass("active");
    $(".mainPage").text("صرف المصاريف");
    $(".subPage").text("إضافة");

    $(document).ready(function() {

        $("#dinar_box").val(numberWithCommas($("#dinar_box").val() ));

        $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));

        $('#money').on("change" , function(){
            $("#money").val(numberWithCommas($("#money").val() ));
        });

        $('#single').change(function(){
            
                var id = $('#single').val();
                
                $.ajax({
                    type: "POST",
                    url: "{{ url('disexpenses/get_money')}}",
                    method:"get",//web page
                    data:{'id':id},
                    success: function(data) {

                        $("#money").html(data);
                        
                    } //success
                });
                    
            // var id = $("#searchid").data("id");
            
        });

    });

</script>
@endsection