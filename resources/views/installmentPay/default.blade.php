@extends('theme.default')

@section('style')
<style>

</style>
@endsection

@section('content')

<div class="side-app container-fluid">

    <!-- page-header -->
    <div class="page-header">
        <div class="mr-auto">
            <!-- <div class="input-group">
                <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('contract/create') }}"> إضافة <i class="fe fe-plus ml-1 mt-1"></i></a>
            </div> -->
        </div>
    </div>
    <!-- End page-header -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <!-- <div class="card-header">
                    <div class="card-title">جدول معلومات العقود</div>
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

                    <div class="table-responsive" style="overflow-x: scroll !important;">
                        <table id="example" class="table table-striped table-bordered text-center">
                            <thead class="bg-primary font-weight-bold">
                                <tr>
                                    <th class="wd-20p">اسم الزبون</th>
                                    <th class="wd-20p">المبلغ مع النسبة المضافة (دينار)</th>
                                    <!-- <th class="wd-20p">سعر الصرف (بالدينار)</th> -->
                                    <!-- <th class="wd-20p">القسط الشهري (دولار)</th> -->
                                    <th class="wd-20p">القسط الشهري مع النسبة المضافة (دينار)</th>
                                    <th class="wd-20p">المبلغ المسدد (دينار)</th>
                                    <th class="wd-20p">تاريخ العقد</th>
                                    <th class="wd-20p">التسديد اقساط</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($contracts as $key=>$contract)
                            
                                <?php 
                                    $customers = DB::table('customers')->where([['id', '=', $contract->id_customers ] , ['deleted_at' , '=' , null ]])->orderBy('id', 'DESC')->get();
                                    $money_dinar = (((int)$contract->money/100)*(int)$contract->exchange_rate);
                                    $kist_dinar = ((int)$money_dinar/(int)$contract->months_number);
                                    $money_customers= DB::table('installment_pay')->where([['id_contract', '=', $contract->id ] , ['date_contract' , '=' , $contract->date ]])->sum('money');
                                ?>

                                <tr>
                                    <td>{{ $customers[0]->name }}</td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $money_dinar ); ?></td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $kist_dinar ); ?></td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $money_customers ); ?></td>
                                    <td>{{ $contract->date }}</td>
                                    <td><?php
                                        $arr = explode('-', $contract->date);
                                        for ($i=1; $i <= $contract->months_number ; $i++) { 

                                            if(($i+(int)$arr[1])>12)
                                                $month=($i+(int)$arr[1])%12;
                                            else
                                                $month=($i+(int)$arr[1]);

                                            $months_number= DB::table('installment_pay')->where([['id_contract', '=', $contract->id ] , ['date_contract' , '=' , $contract->date ] , ['months_number' , '=' , $month ]])->sum('months_number');
                                            
                                            if((int)$months_number ==0){ ?>
                                                <a href='{{url("installmentPay/$contract->id/$kist_dinar/$month/store")}}' class="btn btn-danger">شهر {{ $month }}</a>
                                            <?php }else{ ?>
                                                <a href='{{url("installmentPay/$contract->id/$contract->date/$month/print_catch")}}' class="btn btn-success">شهر {{ $month }}</a>
                                                <!-- <a href="javascript:void;" class="btn btn-success">شهر {{ $month }}</a> -->
                                            <?php }
                                        }
                                    ?>
                                    </td>
                                </tr>
                               
                                @endforeach
                                
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
    $(".installmentPay").addClass("active");
    $(".mainPage").text("التسديد اقساط");
    $(".subPage").text("");

    // $(document).ready(function() {

    //     $('#single').change(function(){
            
    //         var id_customers = $('#single').val();
    //         var date = $('#single option').data("description");
    //         var id_contract = $('#single option').data("id");
    //         // alert(date);

    //         $.ajax({
    //             type: "POST",
    //             url: "{{ url('installmentPay/get_table')}}",
    //             method:"get",//web page
    //             dataType:"json",
    //             data:{
    //                 "id_customers": id_customers,
    //                 "id_contract": id_contract,
    //                 "date": date,
    //                 "_token": "{{ csrf_token() }}",
    //             },
    //             success: function(reponse) {

                    
    //                 //alert(reponse.data);
    //                 $(".tbl").html(reponse.data);
                    
    //                 // $('#month_store').click(function(){
    //                 //     $("#money").val($(".kist_dinar").text());
    //                 // });
    //             } //success
    //         });
                
    //     });
        
    // });
</script>
@endsection