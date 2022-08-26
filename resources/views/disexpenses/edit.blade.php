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
                    <h3 class="mb-0 card-title">دفتر حساب صرف مبلغ للمورد</h3>
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

                    @foreach($disexpensess as $key=>$disexpens)
                    <form action="{{route('disexpenses.update', ['id' => $disexpens->id, 'old_money' => $disexpens->money] )}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">اسم المصروف</label>
                                    <select id="single" name="expenses_name" class="form-control @error('expenses_name') is-invalid state-invalid @enderror">
                                
                                        @foreach($expenses as $key=>$expens)
                                        
                                            @if(old('expenses_name')=='')
                                                <option <?php if($disexpens->id==$expens->id) echo "selected"; ?> value="{{$expens->id}}">{{$expens->expenses_name}}</option>
                                            @else 
                                                <option <?php if(old('expenses_name')==$expens->id) echo "selected"; ?> value="{{$expens->id}}">{{$expens->expenses_name}}</option>
                                            @endif

                                        @endforeach

                                    </select>
                                </div>
                               
                            </div>

                            <?php
                                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                            ?>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدينار</label>
                                    <input type="text" readonly class="form-control @error('dinar_box') is-invalid state-invalid @enderror" name="dinar_box" id="dinar_box" value="{{ $money_setting }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">المبلغ المصروف (بالدينار)</label>
                                    <input type="text" class="form-control @error('money') is-invalid state-invalid @enderror" name="money" id="money" value="{{ old('money')!=''? old('money') : $disexpens->money }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف (بالدينار)</label>
                                    <input type="text" class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{ old('exchange_rate')!=''? old('exchange_rate') : $disexpens->exchange_rate }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">تاريخ</label>
                                    <input type="text" class="form-control @error('date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="date" id="date" value="{{ old('date')!=''? old('date') : $disexpens->date }}" placeholder="اختر التاريخ">
                                </div>
                            </div>
                            
                        </div>

                        <div class="row text-center">
                            <div class="col-sm-12">
                                
                                <input type="submit" value="تعديل" name="submit" class="mt-5 btn btn-primary">                                     
                                
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
    $(".disexpenses").addClass("active");
    $(".mainPage").text("صرف المصاريف");
    $(".subPage").text("تعديل");

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

