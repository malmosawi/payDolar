<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\DisExpenses;
use App\Models\User;
use DB;
use App;
use Auth;

class DisExpensesController extends Controller
{
    
    public function default()
    {   
        $disexpenses = DisExpenses::orderBy('id', 'DESC')->get();
        // $disexpenses = DB::table('disexpenses')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('disexpenses.default' , ['disexpenses'=>$disexpenses]);
    }

    public function create()
    {   
        $expenses = DB::table('expenses')->where([['id', '<>', null] , ['deleted_at', '=', null ]])->orderBy('id', 'DESC')->get();
        return view('disexpenses.create' , ['expenses'=>$expenses]);
    }

    public function store(Request $request)
    {
        $rules = [
            'expenses_name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
        ];

        $customMessages = [
            'expenses_name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'expenses_name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
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

            $m1 = str_replace("," , '', $request->input('dinar_box'));
            $m2 = str_replace("," , '', $request->input('money'));
            $m3 = str_replace("," , '', $request->input('exchange_rate'));

            if($m2 < $m1){

                $disexpenses = new DisExpenses;
                $disexpenses->id_expenses = $request->input('expenses_name');
                $disexpenses->money = $m2;
                $disexpenses->exchange_rate = $m3;
                $disexpenses->date = $request->input('date');
                $disexpenses->user_created = Auth::user()->username;
                $disexpenses->save();

                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                $money = DB::table('dis_expenses')->where([['id_expenses', '=',  $request->input('expenses_name')], ['money', '=',  $m2], ['exchange_rate', '=',  $m3], ['date', '=',  $request->input('date')]])->sum('money');
                $minus = $money_setting-$money;

                $data=array('dinar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);
            

                $request->session()->flash('success', 'تمت الإضافة بنجاح.');
                return redirect('disexpenses');

            }else{
                return back()->with('error', 'المبلغ المصروف اكبر من صندوق الدينار');
            }
            
        }

    }

    public function edit($id)
    {   
        $disexpensess = DB::table('dis_expenses')->where('id', '=', $id)->get();
        $expenses = DB::table('expenses')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('disexpenses/edit',['disexpensess'=>$disexpensess , 'expenses'=>$expenses]);
        
    }

    public function update(Request $request, $id , $old_money)
    {
        
        $rules = [
            'expenses_name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
        ];

        $customMessages = [
            'expenses_name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'expenses_name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
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

            $m1 = str_replace("," , '', $request->input('dinar_box'));
            $m2 = str_replace("," , '', $request->input('money'));
            $m3 = str_replace("," , '', $request->input('exchange_rate'));

            if($m2 < $m1){

                $disexpenses = DisExpenses::find($id);
                $disexpenses->id_expenses = $request->input('expenses_name');
                $disexpenses->money = $m2;
                $disexpenses->exchange_rate = $m3;
                $disexpenses->date = $request->input('date');
                $disexpenses->user_updated = Auth::user()->username;
                $disexpenses->save();

                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                $money = DB::table('dis_expenses')->where([['id_expenses', '=',  $request->input('expenses_name')], ['money', '=',  $m2], ['exchange_rate', '=',  $m3], ['date', '=',  $request->input('date')]])->sum('money');
                $minus = (($money_setting+(int)$old_money)-$money);

                $data=array('dinar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);
            

                $request->session()->flash('success', 'تم تعديل بنجاح.');
                return redirect('disexpenses');

            }else{
                return back()->with('error', 'المبلغ المصروف اكبر من صندوق الدينار');
            }

        }
        
    }


    public function destroy(Request $request)
    {
        $disexpenses =DisExpenses::find($request->GET('id'));
        $disexpenses->user_deleted = Auth::user()->username;
        $disexpenses->save();

        $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
        $money = DB::table('dis_expenses')->where('id', '=',  $request->GET('id') )->sum('money');
        $minus = ($money_setting+$money);

        $data=array('dinar_box'=>$minus);
        DB::table('setting')->where('id','=', 1)->update($data);
        
        if($disexpenses->delete()){
            $response['data'] = 'success';
        }else{
            $response['data'] = 'error';
        }

        return response()->json($response);
        
    }


}
