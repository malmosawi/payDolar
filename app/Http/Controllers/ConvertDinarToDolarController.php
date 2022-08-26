<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ConvertDinarToDolar;
use App\Models\User;
use DB;
use App;
use Auth;

class ConvertDinarToDolarController extends Controller
{
    public function default()
    {   
        $convertDinarToDolar = ConvertDinarToDolar::orderBy('id', 'DESC')->get();
        return view('convertDinarToDolar.default' , ['convertDinarToDolar'=>$convertDinarToDolar]);
    }

    public function create()
    {   
        return view('convertDinarToDolar.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'dolar_box' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'dinar_box' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'money_dolar' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'money_dinar' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
        ];

        $customMessages = [      
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
            $m2 = str_replace("," , '', $request->input('dinar_box'));
            $m3 = str_replace("," , '', $request->input('money_dolar'));
            $m4 = str_replace("," , '', $request->input('money_dinar'));
            $m5 = str_replace("," , '', $request->input('exchange_rate'));

            $m3= ((int)$m4/(int)$m5)*100;

            if((int)$m4 > (int)$m2){

                return back()->with('error', 'مبلغ الدينار اكبر من صندوق الدينار');

            }else{

                $convertDinarToDolar = new convertDinarToDolar;
                $convertDinarToDolar->money_dolar = $m3;
                $convertDinarToDolar->money_dinar = $m4;
                $convertDinarToDolar->exchange_rate = $m5;
                $convertDinarToDolar->date = $request->input('date');
                $convertDinarToDolar->user_created = Auth::user()->username;
                $convertDinarToDolar->save();

                $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                $money_dolar = DB::table('convertDinarToDolar')->where([['money_dolar', '=',  $m3 ], ['money_dinar', '=',  $m4], ['exchange_rate', '=',  $m5], ['date', '=',  $request->input('date')]])->sum('money_dolar');
                $money_dinar = DB::table('convertDinarToDolar')->where([['money_dolar', '=',  $m3 ], ['money_dinar', '=',  $m4], ['exchange_rate', '=',  $m5], ['date', '=',  $request->input('date')]])->sum('money_dinar');
                $minus = ($dinar_box-$money_dinar);
                $plus = ($dolar_box+$money_dolar);

                $data=array('dolar_box'=>$plus , 'dinar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تمت الإضافة بنجاح.');
                return redirect('convertDinarToDolar');

            }

        }

    }

    public function edit($id)
    {   
        $convertDinarToDolar = DB::table('convertDinarToDolar')->where([['id', '=', $id] , ['deleted_at' , '=' , null ]])->get();
        return view('convertDinarToDolar/edit',['convertDinarToDolar'=>$convertDinarToDolar]);
        
    }

    public function update(Request $request, $id , $old_money_dolar , $old_money_dinar)
    {
        
        $rules = [
            'dolar_box' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'dinar_box' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'money_dolar' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'money_dinar' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
        ];

        $customMessages = [      
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
            $m2 = str_replace("," , '', $request->input('dinar_box'));
            $m3 = str_replace("," , '', $request->input('money_dolar'));
            $m4 = str_replace("," , '', $request->input('money_dinar'));
            $m5 = str_replace("," , '', $request->input('exchange_rate'));

            //$m3= ((int)$m4/(int)$m5)*100;

            if((int)$m4 > ((int)$m2+(int)$old_money_dinar)){

                return back()->with('error', 'مبلغ الدينار اكبر من صندوق الدينار');

            }else{

                $convertDinarToDolar = convertDinarToDolar::find($id);
                $convertDinarToDolar->money_dolar = $m3;
                $convertDinarToDolar->money_dinar = $m4;
                $convertDinarToDolar->exchange_rate = $m5;
                $convertDinarToDolar->date = $request->input('date');
                $convertDinarToDolar->user_updated = Auth::user()->username;
                $convertDinarToDolar->save();

                $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                $money_dolar = DB::table('convertDinarToDolar')->where([['money_dolar', '=',  $m3 ], ['money_dinar', '=',  $m4], ['exchange_rate', '=',  $m5], ['date', '=',  $request->input('date')]])->sum('money_dolar');
                $money_dinar = DB::table('convertDinarToDolar')->where([['money_dolar', '=',  $m3 ], ['money_dinar', '=',  $m4], ['exchange_rate', '=',  $m5], ['date', '=',  $request->input('date')]])->sum('money_dinar');
                $minus = (($dinar_box+$old_money_dinar)-$money_dinar);
                $plus = (($dolar_box-$old_money_dolar)+$money_dolar);

                $data=array('dolar_box'=>$plus , 'dinar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تم التعديل بنجاح.');
                return redirect('convertDinarToDolar');

            }

        }
        
    }

    public function destroy(Request $request)
    {
        $convertDinarToDolar =ConvertDinarToDolar::find($request->GET('id'));
        $convertDinarToDolar->user_deleted = Auth::user()->username;
        $convertDinarToDolar->save();

        $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
        $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
        $money_dolar = DB::table('convertdinartodolar')->where('id', '=',  $request->GET('id') )->sum('money_dolar');
        $money_dinar = DB::table('convertdinartodolar')->where('id', '=',  $request->GET('id') )->sum('money_dinar');
        
        $plus = ($dinar_box+$money_dinar);
        $minus = ($dolar_box-$money_dolar);

        $data=array('dolar_box'=>$minus , 'dinar_box'=>$plus);
        DB::table('setting')->where('id','=', 1)->update($data);
        
        if($convertDinarToDolar->delete()){
            $response['data'] = 'success';
        }else{
            $response['data'] = 'error';
        }

        return response()->json($response);
        
    }

}//class
