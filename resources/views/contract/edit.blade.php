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

                    @foreach($contracts as $key=>$contract)
                    <form action="{{route('contract.update', ['id' => $contract->id , 'old_money_dolar' => $contract->money] )}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">اسم الزبون</label>
                                    <select id="single" name="name" class="form-control @error('name') is-invalid state-invalid @enderror">
                                
                                        @foreach($customers as $key=>$customer)
                                            @if(old('name')=='')
                                                <option <?php if($contract->id_customers==$customer->id) echo "selected"; ?> value="{{$customer->id}}">{{$customer->name}}</option>
                                            @else 
                                                <option <?php if(old('name')==$customer->id) echo "selected"; ?> value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endif
                                            
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <?php
                                $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                                $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                            ?>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدولار</label>
                                    <input type="text" readonly class="form-control @error('dolar_box') is-invalid state-invalid @enderror" name="dolar_box" id="dolar_box" value="{{ $dolar_box }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدينار</label>
                                    <input type="text" readonly class="form-control @error('dinar_box') is-invalid state-invalid @enderror" name="dinar_box" id="dinar_box" value="{{ $dinar_box }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ (بالدولار)</label>
                                    <input type="text" class="form-control @error('money') is-invalid state-invalid @enderror" name="money" id="money" value="{{ old('money')!=''? old('money') : $contract->money }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">عدد اشهر التسديد</label>
                                    <input type="text" class="form-control @error('months_number') is-invalid state-invalid @enderror" name="months_number" id="months_number" value="{{ old('months_number')!=''? old('months_number') : $contract->months_number }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">مبلغ الدفع كل شهر (بدولار)</label>
                                    <input type="text" class="form-control @error('money_month') is-invalid state-invalid @enderror" name="money_month" id="money_month" value="{{ old('money_month')!=''? old('money_month') : $contract->money_month }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف لكل 100 دولار</label>
                                    <input type="text" class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{ old('exchange_rate')!=''? old('exchange_rate') : $contract->exchange_rate }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">النسبة المضافة (%)</label>
                                    <input type="text" class="form-control @error('add_rate') is-invalid state-invalid @enderror" name="add_rate" id="add_rate" value="{{ old('add_rate')!=''? old('add_rate') : $contract->add_rate }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ</label>
                                    <input type="text" class="form-control @error('date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="date" id="date" value="{{ old('date')!=''? old('date') : $contract->date }}" placeholder="اختر التاريخ">
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
    $(".suppliersExpenses").addClass("active");
    $(".mainPage").text("العقد");
    $(".subPage").text("تعديل");

    $(document).ready(function() {

        $("#dolar_box").val(numberWithCommas($("#dolar_box").val() ));

        $("#dinar_box").val(numberWithCommas($("#dinar_box").val() ));

        $("#money").val(numberWithCommas($("#money").val() ));

        $("#money_month").val(numberWithCommas($("#money_month").val() ));

        $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));

        $('#months_number,#money').on("change" , function(){
            $("#money").val(numberWithCommas($("#money").val() ));
            var money = $('#money').val().replaceAll(",", "");
            var months_number = $('#months_number').val().replaceAll(",", "");
            $("#money_month").val(numberWithCommas( (money/months_number) ));
            
        });

        $('#money_month').on("change" , function(){

            // if($('#money').val()!='' && $('#months_number').val()==''){
                $("#money").val(numberWithCommas($("#money").val() ));
                $("#money_month").val(numberWithCommas($("#money_month").val() ));
                var money = $('#money').val().replaceAll(",", "");
                var money_month = $('#money_month').val().replaceAll(",", "");
                $("#months_number").val(numberWithCommas( (money/money_month) ));
            // }
            
        });

    });
</script>
@endsection

