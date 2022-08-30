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
                                    $kist_dinar2 = preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $kist_dinar );
                                    $money_customers= DB::table('installment_pay')->where([['id_contract', '=', $contract->id ] , ['date_contract' , '=' , $contract->date ]])->sum('money');
                                ?>

                                <tr>
                                    <td>{{ $customers[0]->name }}</td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $money_dinar ); ?></td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $kist_dinar ); ?></td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $money_customers ); ?></td>
                                    <td>{{ $contract->date }}</td>
                                    <td>
                                        <?php
                                        $arr = explode('-', $contract->date);
                                        for ($i=1; $i <= $contract->months_number ; $i++) { 

                                            if(($i+(int)$arr[1])>12)
                                                $month=($i+(int)$arr[1])%12;
                                            else
                                                $month=($i+(int)$arr[1]);

                                            $months_number= DB::table('installment_pay')->where([['id_contract', '=', $contract->id ] , ['date_contract' , '=' , $contract->date ] , ['months_number' , '=' , $month ]])->sum('months_number');
                                            $modal_id=$contract->id."".$month;

                                            if((int)$months_number ==0){ ?>
                                                {{--url("installmentPay/$contract->id/$kist_dinar/$month/store")--}}
                                                <a data-toggle='modal' data-target="#modal_{{$modal_id}}" href="javascript:void(0);" class="btn btn-danger">شهر {{ $month }}</a>
                                            <?php }else{ ?>
                                                <a href='{{url("installmentPay/$contract->id/$contract->date/$month/print_catch")}}' class="btn btn-success">شهر {{ $month }}</a>
                                                <!-- <a href="javascript:void;" class="btn btn-success">شهر {{ $month }}</a> -->
                                            <?php }//else ?>

                                        <div class="modal fade" data-backdrop="static" id="modal_{{$modal_id}}" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header btn-primary">
                                                        <h4 class="modal-title">التسديد اقساط (شهر {{ $month }})</h4>
                                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                                                        <div class="add-contact-box">
                                                            <div class="add-contact-content">
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
                                                                
                                                                </center>

                                                                <form action="{{route('installmentPay.store', ['id_contract' => $contract->id , 'modal_id' => $modal_id , 'month' =>$month] )}}" id="addContactModalTitle" autocomplete="on" class="appForm clearfix" method="post" enctype="multipart/form-data">
                                                                @csrf  
                                                                    <div class="row text-right">
                                                                        
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label">اسم الزبون</label>
                                                                                <input type="text" readonly class="form-control @error('name_customer') is-invalid state-invalid @enderror" name="name_customer" id="name_customer" value="{{ old('name_customer')!=''? old('name_customer') : $customers[0]->name }}" placeholder="">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label">القسط الشهري (دينار)</label>
                                                                                <input type="text" class="form-control @error('money') is-invalid state-invalid @enderror" name="money" id="money" value="{{ old('money')!=''? old('money') : $kist_dinar2 }}" placeholder="">
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row" style="margin-bottom:5%;">
                                                                        <div class="col-lg-2 col-2 mx-auto">
                                                                            
                                                                            <input type="submit" value="حفظ" name="submit" class="mt-4 btn btn-primary">                                     
                                                                            
                                                                        </div>   

                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <?php } ?>
                                        
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

    
    @if (count($errors) > 0 && session()->get('show')!=null)
        $("#modal_{{ session()->get('show') }}").modal('show');
    @endif

</script>
@endsection