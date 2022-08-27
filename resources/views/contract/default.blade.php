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
            <div class="input-group">
                <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('contract/create') }}"> إضافة <i class="fe fe-plus ml-1 mt-1"></i></a>
            </div>
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

                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered text-nowrap w-100 text-center">
                            <thead>
                                <tr>
                                    <th class="wd-5p">التسلسل</th>
                                    <th class="wd-20p">اسم الزبون</th>
                                    <th class="wd-5p">المبلغ (بالدولار)</th>
                                    <th class="wd-5p">عدد اشهر التسديد</th>
                                    <th class="wd-5p">مبلغ الدفع كل شهر (بالدولار)</th>
                                    <th class="wd-5p">سعر الصرف لكل 100 دولار</th>
                                    <th class="wd-5p">النسبة المضافة (%)</th>
                                    <th class="wd-5p">التاريخ</th>
                                    <!-- <th class="wd-5p">هل اكتمل التسديد</th>
                                    <th class="wd-5p">المبلغ المسدد</th>
                                    <th class="wd-5p">عدد الاشهر المسددة</th> -->
                                    <th class="wd-10p">التحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php $num=0; ?>
                            @foreach($contracts as $key=>$contract)
                            <?php
                                $customers = DB::table('customers')->where('id', '=', $contract->id_customers)->orderBy('id', 'DESC')->get();
                                $money = DB::table('installment_pay')->where('id_contract', '=', $contract->id)->sum('money');
                                $months_number = DB::table('installment_pay')->where('id_contract', '=', $contract->id)->sum('months_number');
                                
                            ?>
                                <tr>
                                    <td>{{ ++$num }}</td>
                                    <td>{{ $customers[0]->name }}</td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract->money); ?></td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract->months_number); ?></td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract->money_month); ?></td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract->exchange_rate); ?></td>
                                    <td><?php echo preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract->add_rate); ?></td>
                                    <td>{{ $contract->date }}</td>

                                    <!-- @if($contract->money == $money && $contract->months_number == $months_number)
                                        <td>نعم</td>
                                    @else
                                        <td>لا</td>
                                    @endif

                                    <td>{{ $money." دولار"  }}</td>
                                    <td>{{ $months_number  }}</td> -->
                                    <td>
                                        
                                        <a href='{{url("contract/$contract->id/edit")}}' class="btn btn-success" data-toggle="tooltip" data-placement="top" data-original-title="تعديل"><i class="si si-pencil text-dark"></i></a>
                                        <a data-id="{{ $contract->id }}" class="btn btn-danger delete_at" data-toggle="tooltip" data-placement="top" data-original-title="حذف"><i class="si si-trash text-light"></i></a>
                                        <a href='{{url("contract/$contract->id/print_catch")}}' class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="طباعة"><i class="si si-printer text-dark"></i></a>
                                           
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
    $(".contract").addClass("active");
    $(".mainPage").text("العقد");
    $(".subPage").text("");

    $(document).ready(function() {

        $(document).on("click", ".delete_at", function(event) {
            
            var id = $(this).data("id");
            Swal({
                title: 'هل انت متأكد؟',
                text: "في حالة تأكيد الحذف لن تتمكن من استرجاع الملف المحذوف",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'الغاء',
                width: '400px',
                confirmButtonText: 'نعم ,اريد الحذف !'
            }).then((result) => {
                if (result.value) {
                    
                    $.ajax({
                        type: "POST",
                        url: "{{ url('contract/destroy')}}",
                        method:"get",//web page
                        dataType:"json",
                        data:{
                            'id': id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if(response.data=="success"){
                                Swal.fire({
                                    html: '<b>تم الحذف.</b>',
                                    showConfirmButton: false,
                                    type: 'success',
                                    width: '400px'
                                });  
                            }else{
                                Swal.fire({
                                    html: '<b>لم يتم الحذف.</b>',
                                    showConfirmButton: false,
                                    type: 'error',
                                    width: '400px'
                                });
                            }//else
                            
                            setTimeout('window.open(\'{{url("contract/")}}\',\'_self\')', 2000);
                        } //success
                    });
                } //if

            }); //then

        event.preventDefault();

        }); //delete_product

    }); //document
</script>
@endsection