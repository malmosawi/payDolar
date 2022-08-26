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
        $contracts = Contract::orderBy('id', 'DESC')->get();
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
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'add_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'money_month' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'months_number' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
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

            $m1 = str_replace("," , '', $request->input('dolar_box'));
            $m2 = str_replace("," , '', $request->input('dinar_box'));
            $m3 = str_replace("," , '', $request->input('money'));
            $m4 = str_replace("," , '', $request->input('money_month'));
            $m5 = str_replace("," , '', $request->input('exchange_rate'));

            if((int)$m3 > (int)$m1){

                return back()->with('error', 'مبلغ الدولار اكبر من صندوق الدولار');

            }else{

                $contract = new Contract;
                $contract->id_customers = $request->input('name');
                $contract->money = $m3;
                $contract->exchange_rate = $m5;
                $contract->add_rate = $request->input('add_rate');
                $contract->money_month = $m4;
                $contract->months_number = $request->input('months_number');
                $contract->date = $request->input('date');
                $contract->user_created = Auth::user()->username;
                $contract->save();

                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $money = DB::table('contract')->where([['id_customers', '=',  $request->input('name')], ['money', '=',  $m3], ['exchange_rate', '=',  $m5] , ['add_rate', '=',  $request->input('add_rate')] , ['money_month', '=',  $m4] , ['months_number', '=',  $request->input('months_number')], ['date', '=',  $request->input('date')]])->sum('money');
                $minus = $money_setting-$money;

                $data=array('dolar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تمت الإضافة بنجاح.');
                return redirect('contract');
            }//else

        }

    }

    public function edit($id)
    {   
        $contracts = DB::table('contract')->where([['id', '=', $id] , ['deleted_at' ,'=' , null ]])->get();
        $customers = DB::table('customers')->where([['id', '<>', null] , ['deleted_at' ,'=' , null ]])->get();
        return view('contract/edit',['contracts'=>$contracts , 'customers'=>$customers]);
        
    }

    public function update(Request $request, $id , $old_money_dolar)
    {
        
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'add_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'money_month' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'months_number' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
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

            $m1 = str_replace("," , '', $request->input('dolar_box'));
            $m2 = str_replace("," , '', $request->input('dinar_box'));
            $m3 = str_replace("," , '', $request->input('money'));
            $m4 = str_replace("," , '', $request->input('money_month'));
            $m5 = str_replace("," , '', $request->input('exchange_rate'));

            if((int)$m3 > ((int)$m1+(int)$old_money_dolar)){

                return back()->with('error', 'مبلغ الدولار اكبر من صندوق الدولار');

            }else{

                $contract = Contract::find($id);
                $contract->id_customers = $request->input('name');
                $contract->money = $m3;
                $contract->exchange_rate = $m5;
                $contract->add_rate = $request->input('add_rate');
                $contract->money_month = $m4;
                $contract->months_number = $request->input('months_number');
                $contract->date = $request->input('date');
                $contract->user_updated = Auth::user()->username;
                $contract->save();

                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $money = DB::table('contract')->where([['id_customers', '=',  $request->input('name')], ['money', '=',  $m3], ['exchange_rate', '=',  $m5] , ['add_rate', '=',  $request->input('add_rate')] , ['money_month', '=',  $m4] , ['months_number', '=',  $request->input('months_number')], ['date', '=',  $request->input('date')]])->sum('money');
                $minus = (($money_setting+$old_money_dolar)-$money);

                $data=array('dolar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تم التعديل بنجاح.');
                return redirect('contract');
            }//else

        }
        
    }


    public function destroy(Request $request)
    {
        $contract =Contract::find($request->GET('id'));
        $contract->user_deleted = Auth::user()->username;
        $contract->save();

        $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
        $money = DB::table('contract')->where('id', '=',  $request->GET('id') )->sum('money');
        $minus = ($money_setting+$money);

        $data=array('dolar_box'=>$minus);
        DB::table('setting')->where('id','=', 1)->update($data);
        
        if($contract->delete()){
            $response['data'] = 'success';
        }else{
            $response['data'] = 'error';
        }

        return response()->json($response);
        
    }


}
