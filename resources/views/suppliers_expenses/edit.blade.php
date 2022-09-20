@extends('theme.default')

@section('style')
<style>
    @error('name')
    .select-label{
        border: 1px solid #ec2d38 !important;
    }
    @enderror
</style>
@endsection

@section('content')

<div class="side-app container">

    <!-- page-header -->
    <!--<div class="page-header">
        <div class="mr-auto">
            <div class="input-group">
                <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('suppliersExpenses') }}"> عرض وصولات الصرف <i class="fe fe-list ml-1 mt-1"></i></a>
            </div>
        </div>
    </div>-->
    <!-- End page-header -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12">
        
            <div class="card">
                <div class="card-header">
                    <div class="mr-auto">
                        <div class="input-group">
                            <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('suppliersExpenses') }}"> عرض وصولات الصرف <i class="fe fe-list ml-1 mt-1"></i></a>
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

                    @foreach($suppliersExpensess as $key=>$supplierExpensess)
                    <form action="{{route('suppliersExpenses.update', ['id' => $supplierExpensess->id, 'old_money' => $supplierExpensess->money] )}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">اسم المورد</label>
                                    <select id="single" name="name" class="form-control @error('name') is-invalid state-invalid @enderror">
                                
                                    @foreach($suppliers as $key=>$supplier)
                                        
                                        @if(old('name')=='')
                                            <option <?php if($supplierExpensess->id_suppliers==$supplier->id) echo "selected"; ?> value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @else 
                                            <option <?php if(old('name')==$supplier->id) echo "selected"; ?> value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @endif
                                    @endforeach

                                    </select>
                                </div>
                            </div>

                            <?php
                                $money_from = DB::table('suppliers_catch')->where([['id_suppliers', '=', $supplierExpensess->id_suppliers ] , ['deleted_at' , '=' , null ]])->sum('money');
                                $money_to = DB::table('suppliers_expenses')->where([['id_suppliers', '=', $supplierExpensess->id_suppliers ] , ['deleted_at' , '=' , null ]])->sum('money');
                                $money_rest = (int)$money_from-(int)$money_to;
                            ?>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ المتبقي للمورد(بالدولار)</label>
                                    <input type="text" readonly class="form-control @error('money_rest') is-invalid state-invalid @enderror" name="money_rest" id="money_rest" value="{{ $money_rest }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف لكل 100 دولار</label>
                                    <input type="text" class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{ old('exchange_rate')!=''? old('exchange_rate') : $supplierExpensess->exchange_rate }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ المستلم من المورد(بالدولار)</label>
                                    <input type="text" readonly class="form-control @error('money_from') is-invalid state-invalid @enderror" name="money_from" id="money_from" value="{{ $money_from }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">ايداء مبلغ للمورد(بالدولار)</label>
                                    <input type="text" class="form-control @error('money') is-invalid state-invalid @enderror" name="money" id="money" value="{{ old('money')!=''? old('money') : $supplierExpensess->money }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ المسلم الى المورد(بالدولار)</label>
                                    <input type="text" readonly class="form-control @error('money_to') is-invalid state-invalid @enderror" name="money_to" id="money_to" value="{{ $money_to }}" placeholder="">
                                </div>
                            </div>

                            

                            <?php
                                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                            ?>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ</label>
                                    <input type="text" class="form-control @error('date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="date" id="date" value="{{ old('date')!=''? old('date') : $supplierExpensess->date }}" placeholder="اختر التاريخ">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدولار</label>
                                    <input type="text" readonly class="form-control @error('dolar_box') is-invalid state-invalid @enderror" name="dolar_box" id="dolar_box" value="{{ $money_setting }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">الملاحضات</label>
                                    <textarea class="form-control" name="note" id="note" rows="3" placeholder="">{{ old('note')!=''? old('note') : $supplierExpensess->note }}</textarea>
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
    $(".mainPage").text("الصرف للموردين");
    $(".subPage").text("تعديل");

    $(document).ready(function() {
    
        $("#dolar_box").val(numberWithCommas($("#dolar_box").val() ));

        $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));
        $("#money_from").val(numberWithCommas($("#money_from").val() ));
        $("#money_to").val(numberWithCommas($("#money_to").val() ));
        $("#money_rest").val(numberWithCommas($("#money_rest").val() ));
        $("#money").val(numberWithCommas($("#money").val() ));
        
        $('#money').on("change" , function(){
            $("#money").val(numberWithCommas($("#money").val() ));
        });

    });
</script>
@endsection

