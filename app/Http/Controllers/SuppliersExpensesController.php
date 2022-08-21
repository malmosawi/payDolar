<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Suppliers;
use App\Models\SuppliersExpenses;
use App\Models\User;
use DB;
use App;
use Auth;

class SuppliersExpensesController extends Controller
{
    public function default()
    {   
        $suppliers_expenses = DB::table('suppliers_expenses')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_expenses.default' , ['suppliers_expenses'=>$suppliers_expenses]);
    }

    public function create()
    {   
        $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_expenses.create' , ['suppliers'=>$suppliers]);
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

            $SuppliersExpenses = new SuppliersExpenses;
            $SuppliersExpenses->id_suppliers = $request->input('name');
            $SuppliersExpenses->money = $request->input('money');
            $SuppliersExpenses->exchange_rate = $request->input('exchange_rate');
            $SuppliersExpenses->date = $request->input('date');
            $SuppliersExpenses->created_at = Auth::user()->username;
            $SuppliersExpenses->save();

            $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
            $money = DB::table('suppliers_expenses')->where([['id_suppliers', '=',  $request->input('name')], ['money', '=',  $request->input('money')], ['exchange_rate', '=',  $request->input('exchange_rate')], ['date', '=',  $request->input('date')]])->sum('money');
            $minus = $money_setting-$money;

            $data=array('dolar_box'=>$minus);
            DB::table('setting')->where('id','=', 1)->update($data);
        

            $request->session()->flash('success', 'تمت الإضافة بنجاح.');
            return redirect('suppliersExpenses');
        }

    }

    public function edit($id)
    {   
        $suppliersExpensess = DB::table('suppliers_expenses')->where('id', '=', $id)->get();
        $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_expenses/edit',['suppliersExpensess'=>$suppliersExpensess , 'suppliers'=>$suppliers]);
        
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

            $SuppliersExpenses = SuppliersExpenses::find($id);
            $SuppliersExpenses->id_suppliers = $request->input('name');
            $SuppliersExpenses->money = $request->input('money');
            $SuppliersExpenses->exchange_rate = $request->input('exchange_rate');
            $SuppliersExpenses->date = $request->input('date');
            $SuppliersExpenses->updated_at = Auth::user()->username;
            $SuppliersExpenses->save();

            $request->session()->flash('success', 'تم التعديل بنجاح.');
            return redirect('suppliersExpenses');
        }
        
    }


    public function get_money(Request $request)
    {

        $money1 = DB::table('suppliers_catch')->where('id_suppliers', '=', $request->GET('id') )->sum('money');
        $money2 = DB::table('suppliers_expenses')->where('id_suppliers', '=', $request->GET('id') )->sum('money');
        
        echo "<option selected disabled >اختر...</option>";
        if($money1 != $money2){
            for ($i=100; $i <=((int)$money1-(int)$money2) ; $i+=100) { 
                echo "<option value='$i'>$i</option>";
            }
        }

    }


}
