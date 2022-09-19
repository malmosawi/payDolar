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

<div class="side-app container-fluid">

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
        <div class="col-md-8">
        
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="mb-0 card-title">وصل العقد</h3>
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

                    <form action="{{route('contract.store')}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">اسم الزبون</label>
                                    <select id="single" name="name" style="border-color: #ec2d38 !important;" class="custom-select @error('name') is-invalid state-invalid @enderror">
                                
                                        @foreach($customers as $key=>$customer)
                                        
                                            <option <?php if(old('name')==$customer->id) echo "selected"; ?> data-name="{{$customer->name}}" value="{{$customer->id}}">{{$customer->name}}</option>
                                            
                                        @endforeach

                                    </select>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <?php
                                $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                                $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                            ?>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدولار</label>
                                    <input type="text" readonly class="form-control @error('dolar_box') is-invalid state-invalid @enderror" name="dolar_box" id="dolar_box" value="{{ $dolar_box }}" placeholder="">
                                </div>
                            </div>

                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">صندوق الدينار</label>
                                    <input type="text" readonly class="form-control @error('dinar_box') is-invalid state-invalid @enderror" name="dinar_box" id="dinar_box" value="{{ $dinar_box }}" placeholder="">
                                </div>
                            </div> -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ (بالدولار)</label>
                                    <input type="text" class="form-control @error('money_dolar') is-invalid state-invalid @enderror" name="money_dolar" id="money_dolar" value="{{ old('money_dolar') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ (بالدينار)</label>
                                    <input type="text" readonly class="form-control @error('money_dinar') is-invalid state-invalid @enderror" name="money_dinar" id="money_dinar" value="{{ old('money_dinar') }}" placeholder="">
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
                                    <label class="form-label">مبلغ الدفع كل شهر (بالدينار)</label>
                                    <input type="text" class="form-control @error('money_month') is-invalid state-invalid @enderror" name="money_month" id="money_month" value="{{ old('money_month') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف</label>
                                    <input type="text" readonly class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{Session::get('exchange_rate')}}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف مع الفائدة </label>
                                    <input type="text" readonly class="form-control @error('exchange_rate_benfit') is-invalid state-invalid @enderror" name="exchange_rate_benfit" id="exchange_rate_benfit" value="{{Session::get('exchange_rate_benfit')}}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"> الفائدة ($)</label>
                                    <input type="text" readonly class="form-control @error('benfit_dolar') is-invalid state-invalid @enderror" name="benfit_dolar" id="benfit_dolar" value="{{ old('benfit_dolar')!=''? old('benfit_dolar') : Session::get('benfit_dolar') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label"> الفائدة (IQD)</label>
                                    <input type="text" readonly class="form-control @error('benfit_dinar') is-invalid state-invalid @enderror" name="benfit_dinar" id="benfit_dinar" value="{{ old('benfit_dinar')!=''? old('benfit_dinar') : Session::get('benfit_dinar') }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ</label>
                                    <input type="text" class="form-control @error('date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="date" id="date" value="{{ old('date')!=''?  old('date') : Date('Y-m-d') }}" placeholder="اختر التاريخ">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">الملاحضات</label>
                                    <textarea class="form-control" name="note" id="note" rows="3" placeholder="">{{ old('note') }}</textarea>
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

        <div class="col-md-4">
            <div class="card">
                <!-- <div class="card-header">
                    <div class="card-title">جدول معلومات العقود</div>
                </div> -->
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example33" class="table table-bordered text-nowrap w-100 text-center">
                            <thead>
                                <tr class="bg-dark">
                                    <th class="wd-5p">التفاصيل</th>
                                    <th class="wd-20p">الدولار</th>
                                    <th class="wd-5p">الدينار</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>المبلغ</td>
                                    <td class="money_dolar"></td>
                                    <td class="money_dinar"></td>
                                </tr>
                                <tr>
                                    <td>الفائدة على الورقة</td>
                                    <td class="benfit_dolar">{{ preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", Session::get('benfit_dolar'))." $" }}</td>
                                    <td class="benfit_dinar">{{ preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", Session::get('benfit_dinar'))." IQD" }}</td>
                                </tr>
                                <tr>
                                    <td>الفائدة على المبلغ الكلي</td>
                                    <td class="benfitAll_dolar"></td>
                                    <td class="benfitAll_dinar"></td>
                                </tr>
                                <tr>
                                    <td>المبلغ الكلي</td>
                                    <td class="moneyAll_dolar"></td>
                                    <td class="moneyAll_dinar"></td>
                                </tr>
                                <tr>
                                    <td>القسط الشهري</td>
                                    <td class="kist_dolar"></td>
                                    <td class="kist_dinar"></td>
                                </tr>
                                <tr>
                                    <td>القسد الشهري مع الفائدة</td>
                                    <td class="kist_dolar_benfit"></td>
                                    <td class="kist_dinar_benfit"></td>
                                </tr>
                                <tr>
                                    <td>عدد اشهر التسديد</td>
                                    <td colspan="2" class="months_dolar"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>

    </div>
    <!-- row end -->


</div>
<!--End side-app  -->



@endsection

@section('script')
<script>
    $(".contract").addClass("active");
    $(".mainPage").text("القرض");
    $(".subPage").text("إضافة");

    $(document).ready(function() {

        $("#dolar_box").val(numberWithCommas($("#dolar_box").val() ));

        $("#money_dolar").val(numberWithCommas($("#money_dolar").val() ));

        $("#money_dinar").val(numberWithCommas($("#money_dinar").val() ));

        $("#benfit_dolar").val(numberWithCommas($("#benfit_dolar").val() ));

        $("#benfit_dinar").val(numberWithCommas($("#benfit_dinar").val() ));

        $("#money_month").val(numberWithCommas($("#money_month").val() ));

        $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));

        $("#exchange_rate_benfit").val(numberWithCommas($("#exchange_rate_benfit").val() ));
        /* --------------------------------------------------------------------------------------- */
        if($("#money_dolar").val()!='' && $("#money_dinar").val()!='' && $("#money_month").val()!='' && $("#months_number").val()!=''){

            $(".money_dolar").text(numberWithCommas(localStorage.getItem("money_dolar"))+" $");
            $(".money_dinar").text(numberWithCommas(localStorage.getItem("money_dinar"))+" IQD");

            $(".benfitAll_dolar").text(numberWithCommas(localStorage.getItem("benfitAll_dolar"))+" $");
            $(".benfitAll_dinar").text(numberWithCommas(localStorage.getItem("benfitAll_dinar"))+" IQD");
            
            $(".moneyAll_dolar").text(numberWithCommas(parseInt(localStorage.getItem("money_dolar"))+parseInt(localStorage.getItem("benfitAll_dolar")))+" $");
            $(".moneyAll_dinar").text(numberWithCommas(parseInt(localStorage.getItem("money_dinar"))+parseInt(localStorage.getItem("benfitAll_dinar")))+" IQD");

            $(".months_dolar").text(localStorage.getItem("months_number"));

            $(".kist_dolar").text(numberWithCommas(parseInt(localStorage.getItem("money_dolar"))/parseInt(localStorage.getItem("months_number")))+" $");
            $(".kist_dinar").text(numberWithCommas(parseInt(localStorage.getItem("money_dinar"))/parseInt(localStorage.getItem("months_number")))+" IQD");
        
            $(".kist_dolar_benfit").text(numberWithCommas((parseInt(localStorage.getItem("money_dolar"))+parseInt(localStorage.getItem("benfitAll_dolar")))/parseInt(localStorage.getItem("months_number")))+" $");
            $(".kist_dinar_benfit").text(numberWithCommas((parseInt(localStorage.getItem("money_dinar"))+parseInt(localStorage.getItem("benfitAll_dinar")))/parseInt(localStorage.getItem("months_number")))+" IQD");
        
        }//if

        /* --------------------------------------------------------------------------------------- */

        $('#months_number,#money_dolar,#exchange_rate_benfit,#exchange_rate').on("change" , function(){
            
            $("#money_dolar").val(numberWithCommas($("#money_dolar").val() ));
            $("#exchange_rate").val(numberWithCommas($("#exchange_rate").val() ));
            $("#exchange_rate_benfit").val(numberWithCommas($("#exchange_rate_benfit").val() ));
            $("#months_number").val(numberWithCommas($("#months_number").val() ));
            
            var exchange_rate = parseInt($('#exchange_rate').val().replaceAll(",", ""));
            localStorage.setItem("exchange_rate", exchange_rate );
            var money_dolar = parseInt($('#money_dolar').val().replaceAll(",", ""));
            localStorage.setItem("money_dolar", money_dolar );
            
            var money_dinar = (money_dolar/100)*exchange_rate;
            localStorage.setItem("money_dinar", money_dinar );
            
            var benfit_dolar = {{Session::get('benfit_dolar')}};
            localStorage.setItem("benfit_dolar", benfit_dolar );
            
            var benfit_dinar = {{Session::get('benfit_dinar')}};
            localStorage.setItem("benfit_dinar", benfit_dinar );
            
            
            $(".money_dolar").text(numberWithCommas(money_dolar)+" $");
            $(".money_dinar").text(numberWithCommas(money_dinar)+" IQD");

            var benfitAll_dolar = (money_dolar/100)*benfit_dolar;
            localStorage.setItem("benfitAll_dolar", benfitAll_dolar );
            
            var benfitAll_dinar = (money_dolar/100)*benfit_dinar;
            localStorage.setItem("benfitAll_dinar", benfitAll_dinar );
            
            $(".benfitAll_dolar").text(numberWithCommas(benfitAll_dolar)+" $");
            $(".benfitAll_dinar").text(numberWithCommas(benfitAll_dinar)+" IQD");
            $("#benfit_dolar").val(numberWithCommas(benfitAll_dolar));
            $("#benfit_dinar").val(numberWithCommas(benfitAll_dinar));

            $(".moneyAll_dolar").text(numberWithCommas(money_dolar+benfitAll_dolar)+" $");
            $(".moneyAll_dinar").text(numberWithCommas(money_dinar+benfitAll_dinar)+" IQD");
            $("#money_dinar").val(numberWithCommas(money_dinar+benfitAll_dinar));

            var months_number = parseInt($('#months_number').val().replaceAll(",", ""));
            localStorage.setItem("months_number", months_number );
            
            $("#money_month").val(numberWithCommas((money_dinar+benfitAll_dinar)/months_number));
            $(".months_dolar").text(months_number);
            /* $(".months_dinar").text(months_number); */

            $(".kist_dolar").text(numberWithCommas(money_dolar/months_number)+" $");
            $(".kist_dinar").text(numberWithCommas(money_dinar/months_number)+" IQD");

            $(".kist_dolar_benfit").text(numberWithCommas((money_dolar+benfitAll_dolar)/months_number)+" $");
            $(".kist_dinar_benfit").text(numberWithCommas((money_dinar+benfitAll_dinar)/months_number)+" IQD");

            
        });

        /* $('#money_month').on("change" , function(){

            // if($('#money').val()!='' && $('#months_number').val()==''){
                $("#money").val(numberWithCommas($("#money").val() ));
                $("#money_month").val(numberWithCommas($("#money_month").val() ));
                var money = $('#money').val().replaceAll(",", "");
                var money_month = $('#money_month').val().replaceAll(",", "");
                $("#months_number").val(numberWithCommas( (money/money_month) ));
            // }
            
        }); */

    });

</script>
@endsection