<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InstallmentPay;
use App\Models\User;
use DB;
use App;
use Auth;

class InstallmentPayController extends Controller
{
    public function default()
    {   
        $installment_pay = DB::table('installment_pay')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('installmentPay.default' , ['installment_pay'=>$installment_pay]);
    }

    public function create()
    {   
        $customers = DB::table('customers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('installmentPay.create' , ['customers'=>$customers]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            // 'add_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            // 'money_month' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
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
            // 'add_rate.required' => 'نسبة الاضافة يجب ان لا يترك فارغاً.',
            // 'add_rate.regex' => 'نسبة الاضافة يجب ان يحتوي على ارقام فقط.',
            // 'money_month.required' => 'المبلغ الدفع الشهري يجب ان لا يترك فارغاً.',
            // 'money_month.regex' => 'المبلغ الدفع الشهري يجب ان يحتوي على ارقام فقط.',
            'months_number.required' => 'عدد اشهر التسديد يجب ان لا يترك فارغاً.',
            'months_number.regex' => 'عدد اشهر التسديد يجب ان يحتوي على ارقام فقط.',
            'date.required' => 'التاريخ يجب ان لا يترك فارغاً.',
            'date.date' => 'التاريخ غير صحيح.',  

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $customers = DB::table('customers')->where('id', '=', $request->input('name'))->orderBy('id', 'DESC')->get();
            $contract = DB::table('contract')->where('id_customers', '=', $customers[0]->id)->orderBy('id', 'DESC')->get();
                                
            $installmentPay = new InstallmentPay;
            $installmentPay->id_contract = $contract[0]->id;
            $installmentPay->money = $request->input('money');
            $installmentPay->exchange_rate = $request->input('exchange_rate');
            // $installmentPay->add_rate = $request->input('add_rate');
            // $installmentPay->money_month = $request->input('money_month');
            $installmentPay->months_number = $request->input('months_number');
            $installmentPay->date = $request->input('date');
            $installmentPay->created_at = Auth::user()->username;
            $installmentPay->save();

            $request->session()->flash('success', 'تمت الإضافة بنجاح.');
            return redirect('installmentPay');
        }

    }

    public function edit($id)
    {   
        $installment_pay = DB::table('installmentPay')->where('id', '=', $id)->get();
        $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('installmentPay/edit',['installment_pay'=>$installment_pay , 'suppliers'=>$suppliers]);
        
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

            $installmentPay = installmentPay::find($id);
            $installmentPay->id_suppliers = $request->input('name');
            $installmentPay->money = $request->input('money');
            $installmentPay->exchange_rate = $request->input('exchange_rate');
            $installmentPay->date = $request->input('date');
            $installmentPay->updated_at = Auth::user()->username;
            $installmentPay->save();

            $request->session()->flash('success', 'تم التعديل بنجاح.');
            return redirect('installmentPay');
        }
        
    }


}
