@extends('theme.default')

@section('style')
<style>

</style>
@endsection

@section('content')

<div class="side-app container">

    <!-- page-header -->
    
    <!-- End page-header -->


    <!-- row -->
    <div class="row">
        <div class="col-md-12">
        
            <div class="card">
                <div class="card-header">
                    <div class="mr-auto">
                        <div class="input-group">
                            <a class="btn btn-primary ml-5 mt-4 mt-sm-0" href="{{ url('expenses/') }}"> عرض سند الصرف <i class="fe fe-plus ml-1 mt-1"></i></a>
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
                    @foreach($expenses as $key=>$expens)

                    <form action="{{route('expenses.update', $expens->id)}}" autocomplete="on" method="post" enctype="multipart/form-data" >                                
                    @csrf

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">الاسم</label>
                                    <input type="text" class="form-control @error('expenses_name') is-invalid state-invalid @enderror" name="expenses_name" id="expenses_name" value="{{ old('expenses_name')!=''? old('expenses_name') : $expens->expenses_name }}" placeholder="">
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
    $(".expenses").addClass("active");
    $(".mainPage").text("المصاريف");
    $(".subPage").text("تعديل");
</script>
@endsection