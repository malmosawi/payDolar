<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Suppliers;
use App\Models\SuppliersCatch;
use App\Models\User;
use DB;
use App;
use Auth;

class SuppliersCatchController extends Controller
{
    public function default()
    {   
        $suppliers_catch = SuppliersCatch::orderBy('id', 'DESC')->get();
        //$suppliers_catch = DB::table('suppliers_catch')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_catch.default' , ['suppliers_catch'=>$suppliers_catch]);
    }

    public function create()
    {   
        $suppliers = Suppliers::orderBy('id', 'DESC')->get();
        // $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_catch.create' , ['suppliers'=>$suppliers]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
        ];

        $customMessages = [
            'name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
            'money.required' => 'المبلغ يجب ان لا يترك فارغاً.',
            'money.regex' => 'المبلغ يجب ان يحتوي على ارقام فقط.',       
            'exchange_rate.required' => 'سعر الصرف يجب ان لا يترك فارغاً.',
            'exchange_rate.regex' => 'سعر الصرف يجب ان يحتوي على ارقام فقط.', 
            'date.required' => 'التاريخ يجب ان لا يترك فارغاً.',
            'date.date' => 'التاريخ غير صحيح.',  

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $m1 = str_replace("," , '', $request->input('dolar_box'));
            $m2 = str_replace("," , '', $request->input('money'));
            $m3 = str_replace("," , '', $request->input('exchange_rate'));
            $m4 = str_replace("," , '', $request->input('money_from'));
            $m5 = str_replace("," , '', $request->input('money_to'));

            $SuppliersCatch = new SuppliersCatch;
            $SuppliersCatch->id_suppliers = $request->input('name');
            $SuppliersCatch->money = $m2;
            $SuppliersCatch->exchange_rate = $m3;
            $SuppliersCatch->date = $request->input('date');
            $SuppliersCatch->user_created = Auth::user()->username;
            $SuppliersCatch->save();

            $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
            $money = DB::table('suppliers_catch')->where([['id_suppliers', '=',  $request->input('name')], ['money', '=',  $m2], ['exchange_rate', '=',  $m3], ['date', '=',  $request->input('date')]])->sum('money');
            $minus = $money_setting+$money;

            $data=array('dolar_box'=>$minus);
            DB::table('setting')->where('id','=', 1)->update($data);

            $request->session()->flash('success', 'تمت الإضافة بنجاح.');
            return redirect('suppliersCatch');

        }

    }

    public function edit($id)
    {   
        $suppliersCatch = DB::table('suppliers_catch')->where([['id', '=', $id] , ['deleted_at' , '=' , null ]])->get();
        $suppliers = DB::table('suppliers')->where([['id', '<>', null ] , ['deleted_at' , '=' , null ]])->orderBy('id', 'DESC')->get();
        return view('suppliers_catch/edit',['suppliersCatch'=>$suppliersCatch , 'suppliers'=>$suppliers]);
        
    }

    public function update(Request $request, $id , $old_money)
    {
        
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
        ];

        $customMessages = [
            'name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
            'money.required' => 'المبلغ يجب ان لا يترك فارغاً.',
            'money.regex' => 'المبلغ يجب ان يحتوي على ارقام فقط.',       
            'exchange_rate.required' => 'سعر الصرف يجب ان لا يترك فارغاً.',
            'exchange_rate.regex' => 'سعر الصرف يجب ان يحتوي على ارقام فقط.', 
            'date.required' => 'التاريخ يجب ان لا يترك فارغاً.',
            'date.date' => 'التاريخ غير صحيح.',  

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $m1 = str_replace("," , '', $request->input('dolar_box'));
            $m2 = str_replace("," , '', $request->input('money'));
            $m3 = str_replace("," , '', $request->input('exchange_rate'));
            $m4 = str_replace("," , '', $request->input('money_from'));
            $m5 = str_replace("," , '', $request->input('money_to'));
            
            $SuppliersCatch = SuppliersCatch::find($id);
            $SuppliersCatch->id_suppliers = $request->input('name');
            $SuppliersCatch->money = $m2;
            $SuppliersCatch->exchange_rate = $m3;
            $SuppliersCatch->date = $request->input('date');
            $SuppliersCatch->user_updated = Auth::user()->username;
            $SuppliersCatch->save();

            $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
            $money = DB::table('suppliers_catch')->where([['id_suppliers', '=',  $request->input('name')], ['money', '=',  $m2], ['exchange_rate', '=',  $m3], ['date', '=',  $request->input('date')]])->sum('money');
            $minus = (($money_setting-$old_money)+$money);

            $data=array('dolar_box'=>$minus);
            DB::table('setting')->where('id','=', 1)->update($data);

            $request->session()->flash('success', 'تم التعديل بنجاح.');
            return redirect('suppliersCatch');

        }//else
            
        
    }

    public function destroy(Request $request)
    {
        $SuppliersCatch =SuppliersCatch::find($request->GET('id'));
        $SuppliersCatch->user_deleted = Auth::user()->username;
        $SuppliersCatch->save();

        $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
        $money = DB::table('suppliers_catch')->where('id', '=',  $request->GET('id') )->sum('money');
        $minus = ($money_setting-$money);

        $data=array('dolar_box'=>$minus);
        DB::table('setting')->where('id','=', 1)->update($data);
        
        if($SuppliersCatch->delete()){
            $response['data'] = 'success';
        }else{
            $response['data'] = 'error';
        }

        return response()->json($response);
        
    }

    public function get_money(Request $request)
    {

        $money_from = DB::table('suppliers_catch')->where([['id_suppliers', '=', $request->GET('id')] , ['deleted_at' , '=' , null ]])->sum('money');
        $money_to = DB::table('suppliers_expenses')->where([['id_suppliers', '=', $request->GET('id')] , ['deleted_at' , '=' , null ]])->sum('money');
        
        $response['data'] = array("money_from"=> $money_from , "money_to" => $money_to);
        return response()->json($response);

    }


}
