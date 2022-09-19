<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;
use App\Models\User;
use DB;
use App;
use Auth;
Use Alert;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    
    public function create()
    {   
        $settings = DB::table('setting')->where('id', '=', 1)->orderBy('id', 'DESC')->get();
        return view('setting.create' , ['settings'=>$settings]);
    }

    public function store(Request $request)
    {
        $rules = [
            'exchange_rate' => ['required','regex:/(^([0-9.,]+)?$)/u' ,'max:255'],
            'exchange_rate_benfit' => ['required','regex:/(^([0-9.,]+)?$)/u' ,'max:255'],
            'benfit_dolar' => ['required','regex:/(^([0-9.,]+)?$)/u' ,'max:255'],
            'benfit_dinar' => ['required','regex:/(^([0-9.,]+)?$)/u' ,'max:255'],
        ];

        $customMessages = [
            'exchange_rate.required' => 'سعر الصرف يجب ان لا يترك فارغاً.',
            'exchange_rate.regex' => 'سعر الصرف يجب ان يحتوي على ارقام فقط.',
            'add_rate.required' => 'نسبة الاضافة يجب ان لا يترك فارغاً.',
            'add_rate.regex' => 'نسبة الاضافة يجب ان يحتوي على ارقام فقط.',       
        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $m1 = str_replace("," , '', $request->input('dolar_box'));
            $m2 = str_replace("," , '', $request->input('dinar_box'));
            $m3 = str_replace("," , '', $request->input('exchange_rate'));
            $m4 = str_replace("," , '', $request->input('exchange_rate_benfit'));
            $m5 = str_replace("," , '', $request->input('benfit_dolar'));
            $m6 = str_replace("," , '', $request->input('benfit_dinar'));

            $setting = Setting::find(1);
            $setting->exchange_rate = $m3;
            $setting->exchange_rate_benfit = $m4;
            $setting->benfit_dolar = $m5;
            $setting->benfit_dinar = $m6;
            $setting->created_at = Auth::user()->username;
            $setting->updated_at = Auth::user()->username;
            $setting->save();

            Session::put('exchange_rate',$setting->exchange_rate);
            Session::put('exchange_rate_benfit',$setting->exchange_rate_benfit);
            Session::put('benfit_dolar',$setting->benfit_dolar);
            Session::put('benfit_dinar',$setting->benfit_dinar);
            Session::put('dolar_box',$setting->dolar_box);  
            Session::put('dinar_box',$setting->dinar_box);  

            toast('تم التعديل بنجاح.','success');
            return redirect('setting');
            //Auth::logout();
            //return redirect('login');
            // $request->session()->flash('success', 'تم التحديث بنجاح.');
            
        }

    }

    

}//class
