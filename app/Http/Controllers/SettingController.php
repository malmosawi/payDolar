<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Setting;
use App\Models\User;
use DB;
use App;
use Auth;
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
            'exchange_rate' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
            'add_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
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

            $setting = Setting::find(1);
            $setting->exchange_rate = $m3;
            $setting->add_rate = $request->input('add_rate');
            $setting->created_at = Auth::user()->username;
            $setting->updated_at = Auth::user()->username;
            $setting->save();

            Auth::logout();
            return redirect('login');
            // $request->session()->flash('success', 'تم التحديث بنجاح.');
            // return redirect('setting');
        }

    }

    

}//class
