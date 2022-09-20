@extends('theme.default')

@section('style')
<style>

</style>
@endsection

@section('content')

<div class="side-app container-fluid">

    <!-- page-header -->
    <!-- <div class="page-header">
        <div class="mr-auto">
            <div class="input-group">
                <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('suppliers/create') }}"> إضافة <i class="fe fe-plus ml-1 mt-1"></i></a>
                <a class="btn btn-success ml-5 mt-4 mt-sm-0" href="{{ url('suppliers/showAll') }}"> طباعة كشف لكل الموردين <i class="fe fe-list ml-1 mt-1"></i></a>
            </div>
        </div>
    </div> -->
    <!-- End page-header -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="mr-auto">
                        <div class="input-group">
                            <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('suppliers/create') }}"> إضافة <i class="fe fe-plus ml-1 mt-1"></i></a>
                            <a class="btn btn-success ml-5 mt-4 mt-sm-0" href="{{ url('suppliers/showAll') }}"> طباعة كشف لكل الموردين <i class="fe fe-list ml-1 mt-1"></i></a>
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

                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered text-nowrap w-100 text-center">
                            <thead>
                                <tr>
                                    <th class="wd-5p">التسلسل</th>
                                    <th class="wd-20p">الاسم</th>
                                    <th class="wd-5p">العنوان</th>
                                    <th class="wd-5p">رقم الهاتف</th>
                                    <th class="wd-10p">التحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php $num=0; ?>
                            @foreach($suppliers as $key=>$supplier)
                                <tr>
                                    <td>{{ ++$num }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>
                                        
                                        <a href='{{url("suppliers/$supplier->id/edit")}}' class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="تعديل"><i class="si si-pencil text-light"></i></a>
                                        <a data-id="{{ $supplier->id }}" class="btn btn-danger delete_at" data-toggle="tooltip" data-placement="top" data-original-title="حذف"><i class="si si-trash text-light"></i></a>
                                        <a href='{{url("suppliers/$supplier->id/show")}}' class="btn btn-gray" data-toggle="tooltip" data-placement="top" data-original-title="طباعة"><i class="si si-printer text-light"></i></a>
                                           
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
    $(".suppliers").addClass("active");
    $(".mainPage").text("الموردين");
    $(".subPage").text("");

    $(document).ready(function() {

        $(document).on("click", ".delete_at", function(event) {
            // alert("hh");
            var productId = $(this).data("id");
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
                        url: "{{ url('suppliers/destroy')}}",
                        method:"get",//web page
                        data:{'id':productId},
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
                            
                            setTimeout('window.open(\'{{url("suppliers/")}}\',\'_self\')', 2000);
                        } //success
                    });
                } //if

            }); //then

        event.preventDefault();

        }); //delete_product

    }); //document

</script>
@endsection