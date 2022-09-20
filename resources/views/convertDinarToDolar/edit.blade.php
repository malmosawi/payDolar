@extends('theme.default')

@section('style')
<style>

</style>
@endsection

@section('content')

<div class="side-app container">


    <!-- row -->
    <div class="row">
        <div class="col-md-12">
        
            <div class="card">
                <div class="card-header">
                    <div class="mr-auto">
                        <div class="input-group">
                            <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('convertDinarToDolar/') }}"> عرض التحويلات <i class="fe fe-list ml-1 mt-1"></i></a>
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

                        @if (count($errors) > 0)
                            
                            @foreach($errors->all() as $error)
                            <div class="alert alert-danger mt-0 mb-3"><strong>{{ $error }}</strong></div>
                            @endforeach
                        
                        @endif
                    </center>

                    @foreach($convertDinarToDolar as $key=>$convertDinar_Dolar)
                    <form action="{{route('convertDinarToDolar.update', ['id' => $convertDinar_Dolar->id , 'old_money_dolar' => $convertDinar_Dolar->money_dolar , 'old_money_dinar' => $convertDinar_Dolar->money_dinar] )}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                        <?php
                                $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                                $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                            ?>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدينار</label>
                                    <input type="text" readonly class="form-control @error('dinar_box') is-invalid state-invalid @enderror" name="dinar_box" id="dinar_box" value="{{ $dinar_box }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدولار</label>
                                    <input type="text" readonly class="form-control @error('dolar_box') is-invalid state-invalid @enderror" name="dolar_box" id="dolar_box" value="{{ $dolar_box }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ (بالدينار)</label>
                                    <input type="text" class="form-control @error('money_dinar') is-invalid state-invalid @enderror" name="money_dinar" id="money_dinar" value="{{ old('money_dinar')!=''? old('money_dinar') : $convertDinar_Dolar->money_dinar }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ (بالدولار)</label>
                                    <input type="text" class="form-control @error('money_dolar') is-invalid state-invalid @enderror" name="money_dolar" id="money_dolar" value="{{ old('money_dolar')!=''? old('money_dolar') : $convertDinar_Dolar->money_dolar }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="form-label">سعر الصرف لكل 100 دولار</label>
                                    <input type="text" class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{ old('exchange_rate')!=''? old('exchange_rate') : $convertDinar_Dolar->exchange_rate }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ</label>
                                    <input type="text" class="form-control @error('date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="date" id="date" value="{{ old('date')!=''? old('date') : $convertDinar_Dolar->date }}" placeholder="اختر التاريخ">
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
    $(".convertDinarToDolar").addClass("active");
    $(".mainPage").text("تحويل الدينار الى دولار");
    $(".subPage").text("تعديل");

    $(document).ready(function() {
    
        $("#dolar_box").val(numberWithCommas($("#dolar_box").val() ));

        $("#dinar_box").val(numberWithCommas($("#dinar_box").val() ));

        $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));

        $("#money_dolar").val(numberWithCommas($("#money_dolar").val() ));

        $("#money_dinar").val(numberWithCommas($("#money_dinar").val() ));
        
        $('#money_dinar,#exchange_rate').on("change" , function(){
            $("#money_dinar").val(numberWithCommas($("#money_dinar").val() ));
            $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));
            var money_dinar = $('#money_dinar').val().replaceAll(",", "");
            var exchange_rate = $('#exchange_rate').val().replaceAll(",", "");
            $("#money_dolar").val(numberWithCommas( (money_dinar/exchange_rate)*100 ));
        });

        $('#money_dolar').on("change" , function(){
            $("#money_dolar").val(numberWithCommas($("#money_dolar").val() ));
        });

    });
</script>
@endsection


