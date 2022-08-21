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
                <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('customers/create') }}"> إضافة زبون جديد <i class="fe fe-plus ml-1 mt-1"></i></a>
            </div>
        </div>
    </div>
    <!-- End page-header -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">جدول معلومات الزبائن</div>
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

                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered text-nowrap w-100 text-center">
                            <thead>
                                <tr>
                                    <th class="wd-5p">التسلسل</th>
                                    <th class="wd-20p">الاسم</th>
                                    <th class="wd-5p">العنوان</th>
                                    <th class="wd-5p">رقم الهاتف</th>
                                    <th class="wd-10p">اسم الام</th>
                                    <th class="wd-30p">الصورة الشخصية</th>
                                    <th class="wd-10p">التحكم</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php $num=0; ?>
                            @foreach($customers as $key=>$customer)
                                <tr>
                                    <td>{{ ++$num }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->mother_name }}</td>
                                    <td><img src='{{asset("assets/person_image/$customer->person_image")}}' class="rounded mx-auto d-block" width="100" height="100"></td>
                                    <td>
                                        
                                        <a href='{{url("customers/$customer->id/edit")}}' class="btn btn-success" data-toggle="tooltip" data-placement="top" data-original-title="تعديل"><i class="si si-pencil text-dark"></i></a>
                                        <a href='{{url("customers/$customer->id/edit")}}' class="btn btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="حذف"><i class="si si-trash text-light"></i></a>
                                            
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
    $(".customers").addClass("active");
    $(".mainPage").text("الزبائن");
    $(".subPage").text("");
</script>
@endsection