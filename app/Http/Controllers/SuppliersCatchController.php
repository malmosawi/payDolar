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
        $suppliers_catch = DB::table('suppliers_catch')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_catch.default' , ['suppliers_catch'=>$suppliers_catch]);
    }

    public function create()
    {   
        $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_catch.create' , ['suppliers'=>$suppliers]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'date' => ['required', 'date'],
            
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

            $SuppliersCatch = new SuppliersCatch;
            $SuppliersCatch->id_suppliers = $request->input('name');
            $SuppliersCatch->money = $request->input('money');
            $SuppliersCatch->exchange_rate = $request->input('exchange_rate');
            $SuppliersCatch->date = $request->input('date');
            $SuppliersCatch->created_at = Auth::user()->username;
            $SuppliersCatch->save();

            $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
            $money = DB::table('suppliers_catch')->where([['id_suppliers', '=',  $request->input('name')], ['money', '=',  $request->input('money')], ['exchange_rate', '=',  $request->input('exchange_rate')], ['date', '=',  $request->input('date')]])->sum('money');
            $minus = $money_setting+$money;

            $data=array('dolar_box'=>$minus);
            DB::table('setting')->where('id','=', 1)->update($data);

            $request->session()->flash('success', 'تمت الإضافة بنجاح.');
            return redirect('suppliersCatch');
        }

    }

    public function edit($id)
    {   
        $suppliersCatch = DB::table('suppliers_catch')->where('id', '=', $id)->get();
        $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_catch/edit',['suppliersCatch'=>$suppliersCatch , 'suppliers'=>$suppliers]);
        
    }

    public function update(Request $request, $id)
    {
        
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'date' => ['required', 'date'],
            
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

            $SuppliersCatch = SuppliersCatch::find($id);
            $SuppliersCatch->id_suppliers = $request->input('name');
            $SuppliersCatch->money = $request->input('money');
            $SuppliersCatch->exchange_rate = $request->input('exchange_rate');
            $SuppliersCatch->date = $request->input('date');
            $SuppliersCatch->updated_at = Auth::user()->username;
            $SuppliersCatch->save();

            $request->session()->flash('success', 'تم التعديل بنجاح.');
            return redirect('suppliersCatch');
        }
        
    }


}
