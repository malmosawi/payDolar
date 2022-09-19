<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use DB;
use App;
use Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
      return view('auth/login');
    }

    public function checklogin(Request $request)
    {
      
      $rules = [
        'username' => ['required', 'regex:/(^([a-zA-z0-9]+)?$)/u'],
        'password' => ['required', 'regex:/(^([a-zA-z0-9]+)?$)/u', 'min:8']
      ];

      $customMessages = [
          'username.required' => 'أسم المستخدم يجب ان لا يترك فارغاً.',
          'username.regex' => 'أسم المستخدم يجب ان يحتوي على أحرف و ارقام فقط.',
          'password.required' => 'كلمة المرور يجب ان لا تترك فارغة.',
          'password.regex' => 'كلمة المرور يجب ان تحتوي على أحرف و ارقام فقط.',
          'password.min' => 'كلمة المرور يجب ان لا تقل عن 8 حروف.',   
      ];

      // $request->validate( $rules , $customMessages);
      $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $user_data = array(
              'username'  => $request->input('username'),
              'password' => $request->input('password')
            );
        
            if(Auth::attempt($user_data)){
      
              $setting = DB::table('setting')->where('id', '=', 1)->orderBy('id', 'DESC')->first();
              Session::put('exchange_rate',$setting->exchange_rate);
              Session::put('exchange_rate_benfit',$setting->exchange_rate_benfit);
              Session::put('benfit_dolar',$setting->benfit_dolar);
              Session::put('benfit_dinar',$setting->benfit_dinar);
              Session::put('dolar_box',$setting->dolar_box);  
              Session::put('dinar_box',$setting->dinar_box);  
              return redirect('contract/create');
              
            }else{
              return back()->with('error', 'خطأ في تسجيل الدخول.');
            }
        }
      

    }

    function logout()
    {
      // Auth::guard()->logout();

      //   $request->session()->invalidate();

      //   $request->session()->regenerateToken();

      //   return redirect('/');
      Auth::logout();
      return redirect('login');
    }
    

    public function profile(Request $request, $id)
    {
        $request->session()->flash('show', 'show_profile');

        $rules = [
            'name' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
            'username' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
            'password' => ['nullable', 'regex:/(^([a-zA-z0-9]+)?$)/u', 'min:8']
        ];
    
        $customMessages = [
            //'name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'name.regex' => 'الاسم يجب ان يحتوي على أحرف و ارقام فقط.',
            //'username.required' => 'أسم المستخدم يجب ان لا يترك فارغاً.',
            'username.regex' => 'أسم المستخدم يجب ان يحتوي على أحرف و ارقام فقط.',
            //'password.required' => 'كلمة المرور يجب ان لا تترك فارغة.',
            'password.regex' => 'كلمة المرور يجب ان تحتوي على أحرف و ارقام فقط.',
            'password.min' => 'كلمة المرور يجب ان لا تقل عن 8 حروف.',   
        ];
    
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
            return back()->withErrors($validator->errors())->withInput();
        }else{

            if($request->input('name') != "" && $request->input('username') != ""){
                $user = User::find($id);
                $user->name= $request->input('name');
                $user->username= $request->input('username');

                if($request->input('password') != '' || $request->input('password') != null){
                    $user->password= Hash::make($request->input('password'));
                }
                $user->save();
                $request->session()->flash('success', 'تم التعديل بنجاح.');
                // return redirect('customers');
                Auth::logout();
                return redirect('login');

            }//if

            
        }

    }

}
