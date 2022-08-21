<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contract;
use App\Models\User;
use DB;
use App;
use Auth;

class ContractController extends Controller
{
    public function default()
    {   
        $contracts = DB::table('contract')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('contract.default' , ['contracts'=>$contracts]);
    }

    public function create()
    {   
        $customers = DB::table('customers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('contract.create' , ['customers'=>$customers]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'add_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'money_month' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'months_number' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'date' => ['required', 'date'],
            
        ];

        $customMessages = [
            'name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
            'money.required' => 'المبلغ يجب ان لا يترك فارغاً.',
            'money.regex' => 'المبلغ يجب ان يحتوي على ارقام فقط.',       
            'exchange_rate.required' => 'سعر الصرف يجب ان لا يترك فارغاً.',
            'exchange_rate.regex' => 'سعر الصرف يجب ان يحتوي على ارقام فقط.', 
            'add_rate.required' => 'نسبة الاضافة يجب ان لا يترك فارغاً.',
            'add_rate.regex' => 'نسبة الاضافة يجب ان يحتوي على ارقام فقط.',
            'money_month.required' => 'المبلغ الدفع الشهري يجب ان لا يترك فارغاً.',
            'money_month.regex' => 'المبلغ الدفع الشهري يجب ان يحتوي على ارقام فقط.',
            'months_number.required' => 'عدد اشهر التسديد يجب ان لا يترك فارغاً.',
            'months_number.regex' => 'عدد اشهر التسديد يجب ان يحتوي على ارقام فقط.',
            'date.required' => 'التاريخ يجب ان لا يترك فارغاً.',
            'date.date' => 'التاريخ غير صحيح.',  

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $contract = new Contract;
            $contract->id_customers = $request->input('name');
            $contract->money = $request->input('money');
            $contract->exchange_rate = $request->input('exchange_rate');
            $contract->add_rate = $request->input('add_rate');
            $contract->money_month = $request->input('money_month');
            $contract->months_number = $request->input('months_number');
            $contract->date = $request->input('date');
            $contract->created_at = Auth::user()->username;
            $contract->save();

            $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
            $money = DB::table('contract')->where([['id_customers', '=',  $request->input('name')], ['money', '=',  $request->input('money')], ['exchange_rate', '=',  $request->input('exchange_rate')] , ['add_rate', '=',  $request->input('add_rate')] , ['money_month', '=',  $request->input('money_month')] , ['months_number', '=',  $request->input('months_number')], ['date', '=',  $request->input('date')]])->sum('money');
            $minus = $money_setting-$money;

            $data=array('dolar_box'=>$minus);
            DB::table('setting')->where('id','=', 1)->update($data);

            $request->session()->flash('success', 'تمت الإضافة بنجاح.');
            return redirect('contract');
        }

    }

    public function edit($id)
    {   
        $contracts = DB::table('contract')->where('id', '=', $id)->get();
        $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('contract/edit',['contracts'=>$contracts , 'suppliers'=>$suppliers]);
        
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

            $contract = contract::find($id);
            $contract->id_suppliers = $request->input('name');
            $contract->money = $request->input('money');
            $contract->exchange_rate = $request->input('exchange_rate');
            $contract->date = $request->input('date');
            $contract->updated_at = Auth::user()->username;
            $contract->save();

            $request->session()->flash('success', 'تم التعديل بنجاح.');
            return redirect('contract');
        }
        
    }


}
