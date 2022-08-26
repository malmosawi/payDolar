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
        $suppliers_expenses = SuppliersExpenses::orderBy('id', 'DESC')->get();
        // $suppliers_expenses = DB::table('suppliers_expenses')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_expenses.default' , ['suppliers_expenses'=>$suppliers_expenses]);
    }

    public function create()
    {   
        $suppliers = Suppliers::orderBy('id', 'DESC')->get();
        // $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_expenses.create' , ['suppliers'=>$suppliers]);
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
            $m6=(int)$m2 + (int)$m5;

            if((int)$m2 > (int)$m1){

                return back()->with('error', 'المبلغ المسدد للمورد اكبر من صندوق الدولار.');

            }else if(($m6 < (int)$m4)){

                $suppliersExpenses = new SuppliersExpenses;
                $suppliersExpenses->id_suppliers = $request->input('name');
                $suppliersExpenses->money = $m2;
                $suppliersExpenses->exchange_rate = $m3;
                $suppliersExpenses->date = $request->input('date');
                $suppliersExpenses->user_created = Auth::user()->username;
                $suppliersExpenses->save();

                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $money = DB::table('suppliers_expenses')->where([['id_suppliers', '=',  $request->input('name')], ['money', '=',  $m2], ['exchange_rate', '=',  $m3], ['date', '=',  $request->input('date')]])->sum('money');
                $minus = ($money_setting-$money);

                $data=array('dolar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تمت الإضافة بنجاح.');
                return redirect('suppliersExpenses');

            }else{
                return back()->with('error', 'المبلغ المسدد للمورد اكبر من المبلغ المستلم من المورد.');
            }

        }

    }

    public function edit($id)
    {   
        $suppliersExpensess = DB::table('suppliers_expenses')->where([['id', '=', $id] , ['deleted_at' , '=' , null ]])->get();
        $suppliers = DB::table('suppliers')->where([['id', '<>', null ] , ['deleted_at' , '=' , null ]])->orderBy('id', 'DESC')->get();
        return view('suppliers_expenses/edit',['suppliersExpensess'=>$suppliersExpensess , 'suppliers'=>$suppliers]);
        
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
            $m6=(int)$m2 + (int)$m5;

            if((int)$m2 > (int)$m1){

                return back()->with('error', 'المبلغ المسدد للمورد اكبر من صندوق الدولار.');

            }else if(($m6 < (int)$m4)){

                $suppliersExpenses = SuppliersExpenses::find($id);
                $suppliersExpenses->id_suppliers = $request->input('name');
                $suppliersExpenses->money = $m2;
                $suppliersExpenses->exchange_rate = $m3;
                $suppliersExpenses->date = $request->input('date');
                $suppliersExpenses->user_updated = Auth::user()->username;
                $suppliersExpenses->save();

                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $money = DB::table('suppliers_expenses')->where([['id_suppliers', '=',  $request->input('name')], ['money', '=',  $m2], ['exchange_rate', '=',  $m3], ['date', '=',  $request->input('date')]])->sum('money');
                $minus = (($money_setting+$old_money)-$money);

                $data=array('dolar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تم التعديل بنجاح.');
                return redirect('suppliersExpenses');

            }else{
                return back()->with('error', 'المبلغ المسدد للمورد اكبر من المبلغ المستلم من المورد.');
            }

        }
        
    }

    public function destroy(Request $request)
    {
        $suppliersExpenses =SuppliersExpenses::find($request->GET('id'));
        $suppliersExpenses->user_deleted = Auth::user()->username;
        $suppliersExpenses->save();

        $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
        $money = DB::table('suppliers_expenses')->where('id', '=',  $request->GET('id') )->sum('money');
        $minus = ($money_setting+$money);

        $data=array('dolar_box'=>$minus);
        DB::table('setting')->where('id','=', 1)->update($data);
        
        if($suppliersExpenses->delete()){
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


    // public function get_money2(Request $request)
    // {

    //     $money1 = DB::table('suppliers_catch')->where('id_suppliers', '=', $request->GET('id') )->sum('money');
    //     $money2 = DB::table('suppliers_expenses')->where('id_suppliers', '=', $request->GET('id') )->sum('money');
        
    //     echo "<option selected disabled >اختر...</option>";
    //     if($money1 != $money2){
    //         for ($i=100; $i <=((int)$money1-(int)$money2) ; $i+=100) { 
    //             echo "<option value='$i'>$i</option>";
    //         }
    //     }

    // }


}
