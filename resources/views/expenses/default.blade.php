@extends('theme.default')

@section('style')
<style>

</style>
@endsection

@section('content')

<div class="side-app container-fluid">

    <!-- page-header -->
    
    <!-- End page-header -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="mr-auto">
                        <div class="input-group">
                            <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('expenses/create') }}"> تبويب صرف جديد <i class="fe fe-plus ml-1 mt-1"></i></a>
                                                    
                            <a data-toggle='modal' data-target="#modal_expenses_all" href="javascript:void(0);" class="btn btn-success ml-5 mt-4 mt-sm-0"> طباعة كشف لكل المصاريف <i class="fe fe-list ml-1 mt-1"></i></a>
                            
                            <div class="modal fade" data-backdrop="static" id="modal_expenses_all" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header btn-primary">
                                            <h4 class="modal-title">وصل كشف اجمالي</h4>
                                            <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                                            <div class="add-contact-box">
                                                <div class="add-contact-content">

                                                    <form action="{{ route('expenses.showAll') }}" id="addContactModalTitle" autocomplete="on" class="appForm clearfix" method="post" enctype="multipart/form-data">
                                                    @csrf  
                                                        <div class="row text-right">
                                                            
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">تاريخ من</label>
                                                                    <input type="date" required class="form-control @error('date_from2') is-invalid state-invalid @enderror" name="date_from2" id="date_from2" value="{{ old('date_from2')!=''?  old('date_from2') : Date('Y-m-d') }}" placeholder="اختر التاريخ">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="form-label">تاريخ الى</label>
                                                                    <input type="date" required class="form-control @error('date_to2') is-invalid state-invalid @enderror" name="date_to2" id="date_to2" value="{{ old('date_to2')!=''?  old('date_to2') : Date('Y-m-d') }}" placeholder="اختر التاريخ">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row" style="margin-bottom:5%;">
                                                            <div class="col-lg-2 col-2 mx-auto">
                                                                
                                                                <input type="submit" value="طباعة" name="submit" class="mt-4 btn btn-primary">                                     
                                                                
                                                            </div>   

                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
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
                        <table id="example" class="table table-bordered text-nowrap w-100 text-center">
                            <thead>
                                <tr>
                                    <th class="wd-5p">التسلسل</th>
                                    <th class="wd-20p">اسم المصروف</th>
                                    <th class="wd-10p">التحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php $num=0; ?>
                            @foreach($expenses as $key=>$expens)
                                <tr>
                                    <td>{{ ++$num }}</td>
                                    <td>{{ $expens->expenses_name }}</td>
                                    <td>
                                        
                                        <a href='{{url("expenses/$expens->id/edit")}}' class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="تعديل"><i class="si si-pencil text-light"></i></a>
                                        <a data-id="{{ $expens->id }}" class="btn btn-danger delete_at" data-toggle="tooltip" data-placement="top" data-original-title="حذف"><i class="si si-trash text-light"></i></a>
                                        <!-- <a href='{{url("expenses/$expens->id/show")}}' class="btn btn-gray" data-toggle="tooltip" data-placement="top" data-original-title="طباعة"><i class="si si-printer text-light"></i></a> -->
                                        <a data-toggle='modal' data-target="#modal_{{$expens->id}}" href="javascript:void(0);" class="btn btn-gray" data-toggle="tooltip" data-placement="top" data-original-title="طباعة"><i class="si si-printer text-light"></i></a>
                                        
                                        <div class="modal fade" data-backdrop="static" id="modal_{{$expens->id}}" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header btn-primary">
                                                        <h4 class="modal-title">وصل كشف [{{ $expens->expenses_name }}]</h4>
                                                        <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <i class="flaticon-cancel-12 close" data-dismiss="modal"></i>
                                                        <div class="add-contact-box">
                                                            <div class="add-contact-content">

                                                                <form action="{{route('expenses.show', ['id' => $expens->id ] )}}" id="addContactModalTitle" autocomplete="on" class="appForm clearfix" method="post" enctype="multipart/form-data">
                                                                @csrf  
                                                                    <div class="row text-right">
                                                                        
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label">تاريخ من</label>
                                                                                <input type="date" required class="form-control @error('date_from') is-invalid state-invalid @enderror" name="date_from" id="date_from" value="{{ old('date_from')!=''?  old('date_from') : Date('Y-m-d') }}" placeholder="اختر التاريخ">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label class="form-label">تاريخ الى</label>
                                                                                <input type="date" required class="form-control @error('date_to') is-invalid state-invalid @enderror" name="date_to" id="date_to" value="{{ old('date_to')!=''?  old('date_to') : Date('Y-m-d') }}" placeholder="اختر التاريخ">
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row" style="margin-bottom:5%;">
                                                                        <div class="col-lg-2 col-2 mx-auto">
                                                                            
                                                                            <input type="submit" value="طباعة" name="submit" class="mt-4 btn btn-primary">                                     
                                                                            
                                                                        </div>   

                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
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
    $(".expenses").addClass("active");
    $(".mainPage").text("المصاريف");
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
                        url: "{{ url('expenses/destroy')}}",
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
                            
                            setTimeout('window.open(\'{{url("expenses/")}}\',\'_self\')', 2000);
                        } //success
                    });
                } //if

            }); //then

        event.preventDefault();

        }); //delete_product

    }); //document

</script>
@endsection