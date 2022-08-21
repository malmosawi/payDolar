@extends('theme.default')

@section('style')
<style>

</style>
@endsection

@section('content')

<div class="side-app container">

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
        <div class="col-md-12">
        
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 card-title">دفتر حساب صرف مبلغ للمورد</h3>
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
                    <form action="{{route('suppliersExpenses.update', $supplierExpensess->id)}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">اسم المورد</label>
                                    <select id="single" name="name" class="form-control @error('name') is-invalid state-invalid @enderror">
                                
                                        @foreach($suppliers as $key=>$supplier)
                                        
                                            @if(old('name')=='')
                                                <option <?php if($supplierExpensess->id==$supplier->id) echo "selected"; ?> data-name="{{$supplier->name}}" value="{{$supplier->id}}">{{$supplier->name}}</option>
                                            @else 
                                                <option <?php if(old('name')==$supplier->id) echo "selected"; ?> data-name="{{$supplier->name}}" value="{{$supplier->id}}">{{$supplier->name}}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">المبلغ</label>
                                    <input type="text" class="form-control @error('money') is-invalid state-invalid @enderror" name="money" id="money" value="{{ old('money')!=''? old('money') : $supplierExpensess->money }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">سعر الصرف</label>
                                    <input type="text" class="form-control @error('exchange_rate') is-invalid state-invalid @enderror" name="exchange_rate" id="exchange_rate" value="{{ old('exchange_rate')!=''? old('exchange_rate') : $supplierExpensess->exchange_rate }}" placeholder="">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">تاريخ</label>
                                    <input type="text" class="form-control @error('date') is-invalid state-invalid @enderror flatpickr flatpickr-input active" name="date" id="date" value="{{ old('date')!=''? old('date') : $supplierExpensess->date }}" placeholder="اختر التاريخ">
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
</script>
@endsection

