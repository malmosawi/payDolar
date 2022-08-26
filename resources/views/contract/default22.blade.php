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

                    <div class="row mb-5">

                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">اسم الزبون</label>
                                <select id="single" name="name" class="form-control @error('name') is-invalid state-invalid @enderror">

                                    <?php
                                        $customers = DB::table('customers')->where([['id', '<>', null ] , ['deleted_at', '=', null ]])->orderBy('id', 'DESC')->get();  
                                    ?>
                            
                                    @foreach($customers as $key=>$customer)
                                        <?php 
                                            $customers = DB::table('customers')->where('id', '=', $contract->id_customers)->orderBy('id', 'DESC')->get();
                                        ?>
                                    
                                        <option data-description="{{$customer->id}}" value="{{$customer->id}}">{{$customer->name}}</option>
                                        
                                    @endforeach

                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered w-100 text-center">
                            <thead class="bg-primary font-weight-bold">
                                <tr>
                                    <th class="wd-5p b">التفاصيل</th>
                                    <th class="wd-20p">دولار</th>
                                    <th class="wd-5p">دينار</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                <tr>
                                    <td>سعر الصرف</td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>النسبة المضافة</td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>المبلغ</td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>المبلغ مع النسبة المضافة</td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>مبلغ الدفع الشهري</td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>عدد اشهر التسديد</td>
                                    <td colspan="2"></td>
                                </tr>

                                <tr>
                                    <td>عدد الاشهر المسددة</td>
                                    <td colspan="2"></td>
                                </tr>

                                <tr>
                                    <td>هل اكتمل التسديد</td>
                                    <td colspan="2"></td>
                                </tr>

                                <tr>
                                    <td>تاريخ العقد</td>
                                    <td colspan="2"></td>
                                </tr>

                                <tr>
                                    <td>التحكم</td>
                                    <td colspan="2">
                                        
                                        <a href='' class="btn btn-success" data-toggle="tooltip" data-placement="top" data-original-title="تعديل"><i class="si si-pencil text-dark"></i></a>
                                        <a href='' class="btn btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="حذف"><i class="si si-trash text-light"></i></a>
                                            
                                    </td>
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
    $(".mainPage").text("العقد");
    $(".subPage").text("");

    tail.select("#single", {
        deselect: true,
        placeholder: 'اختر...',
        multiShowCount: false,
        search: true,
        descriptions: true
    });
</script>
@endsection