<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ConvertDolarToDinar;
use App\Models\User;
use DB;
use App;
use Auth;

class ConvertDolarToDinarController extends Controller
{
    public function default()
    {   
        $convertDolarToDinar = ConvertDolarToDinar::orderBy('id', 'DESC')->get();
        return view('convertDolarToDinar.default' , ['convertDolarToDinar'=>$convertDolarToDinar]);
    }

    public function create()
    {   
        return view('convertDolarToDinar.create');
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

            $m4= ((int)$m3/100)*$m5;

            if((int)$m3 > (int)$m1){

                return back()->with('error', 'مبلغ الدولار اكبر من صندوق الدولار');

            }else{

                $convertDolarToDinar = new ConvertDolarToDinar;
                $convertDolarToDinar->money_dolar = $m3;
                $convertDolarToDinar->money_dinar = $m4;
                $convertDolarToDinar->exchange_rate = $m5;
                $convertDolarToDinar->date = $request->input('date');
                $convertDolarToDinar->user_created = Auth::user()->username;
                $convertDolarToDinar->save();

                $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                $money_dolar = DB::table('convertDolarToDinar')->where([['money_dolar', '=',  $m3 ], ['money_dinar', '=',  $m4], ['exchange_rate', '=',  $m5], ['date', '=',  $request->input('date')]])->sum('money_dolar');
                $money_dinar = DB::table('convertDolarToDinar')->where([['money_dolar', '=',  $m3 ], ['money_dinar', '=',  $m4], ['exchange_rate', '=',  $m5], ['date', '=',  $request->input('date')]])->sum('money_dinar');
                $minus = ($dolar_box-$money_dolar);
                $plus = ($dinar_box+$money_dinar);

                $data=array('dolar_box'=>$minus , 'dinar_box'=>$plus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تمت الإضافة بنجاح.');
                return redirect('convertDolarToDinar');

            }

        }

    }

    public function edit($id)
    {   
        $convertDolarToDinars = DB::table('convertDolarToDinar')->where([['id', '=', $id] , ['deleted_at' , '=' , null ]])->get();
        return view('convertDolarToDinar/edit',['convertDolarToDinars'=>$convertDolarToDinars]);
        
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

            //$m4= ((int)$m3/100)*$m5;

            if((int)$m3 > ((int)$m1+(int)$old_money_dolar)){

                return back()->with('error', 'مبلغ الدولار اكبر من صندوق الدولار');

            }else{

                $convertDolarToDinar = ConvertDolarToDinar::find($id);
                $convertDolarToDinar->money_dolar = $m3;
                $convertDolarToDinar->money_dinar = $m4;
                $convertDolarToDinar->exchange_rate = $m5;
                $convertDolarToDinar->date = $request->input('date');
                $convertDolarToDinar->user_updated = Auth::user()->username;
                $convertDolarToDinar->save();

                $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
                $money_dolar = DB::table('convertDolarToDinar')->where([['money_dolar', '=',  $m3 ], ['money_dinar', '=',  $m4], ['exchange_rate', '=',  $m5], ['date', '=',  $request->input('date')]])->sum('money_dolar');
                $money_dinar = DB::table('convertDolarToDinar')->where([['money_dolar', '=',  $m3 ], ['money_dinar', '=',  $m4], ['exchange_rate', '=',  $m5], ['date', '=',  $request->input('date')]])->sum('money_dinar');
                $minus = (($dolar_box+$old_money_dolar)-$money_dolar);
                $plus = (($dinar_box-$old_money_dinar)+$money_dinar);

                $data=array('dolar_box'=>$minus , 'dinar_box'=>$plus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تم التعديل بنجاح.');
                return redirect('convertDolarToDinar');

            }

        }
        
    }

    public function destroy(Request $request)
    {
        $convertDolarToDinar =ConvertDolarToDinar::find($request->GET('id'));
        $convertDolarToDinar->user_deleted = Auth::user()->username;
        $convertDolarToDinar->save();

        $dolar_box = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
        $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
        $money_dolar = DB::table('convertDolarToDinar')->where('id', '=',  $request->GET('id') )->sum('money_dolar');
        $money_dinar = DB::table('convertDolarToDinar')->where('id', '=',  $request->GET('id') )->sum('money_dinar');
        
        $minus = ($dolar_box+$money_dolar);
        $plus = ($dinar_box-$money_dinar);

        $data=array('dolar_box'=>$minus , 'dinar_box'=>$plus);
        DB::table('setting')->where('id','=', 1)->update($data);
        
        if($convertDolarToDinar->delete()){
            $response['data'] = 'success';
        }else{
            $response['data'] = 'error';
        }

        return response()->json($response);
        
    }

}//class
