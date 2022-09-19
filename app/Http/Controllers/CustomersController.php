<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Customers;
use App\Models\User;
use DB;
use App;
use Auth;
Use Alert;

class CustomersController extends Controller
{
    public function default()
    {   
        $customers = Customers::orderBy('id', 'DESC')->get();
        // $customers = DB::table('customers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('customers.default' , ['customers'=>$customers]);
    }

    public function create()
    {   
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'address' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'phone' => ['required', 'regex:/(^([0-9]+)?$)/u' , 'unique:customers' , 'min:11' , 'max:11'],
            'person_image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
            'mother_name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'identification_number' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'unique:customers' , 'max:255'],
            'identification_version' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'identification_date' => ['required', 'date' , 'max:255'],
            // 'year' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
            'job' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'job_place' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'bank_name' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'card_password' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'unique:customers' , 'max:255'],
            'phone_council' => ['nullable', 'regex:/(^([0-9]+)?$)/u' , 'max:255'],
        ];

        $customMessages = [
            'name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
            'address.required' => 'العنوان يجب ان لا يترك فارغاً.',
            'address.regex' => 'العنوان يجب ان يحتوي على احرف وارقام فقط.',                
            'phone.required' => 'رقم الهاتف يجب ان لا يترك فارغاً.',
            'phone.regex' => 'رقم الهاتف يجب ان يحتوي على ارقام فقط.', 
            'phone.unique' => 'رقم الهاتف مستخدم مسبقاً',       
            'mother_name.required' => 'اسم الام يجب ان لا يترك فارغاً.',
            'mother_name.regex' => 'اسم الام يجب ان يحتوي على احرف وارقام فقط.', 
            'identification_number.required' => 'رقم الهوية يجب ان لا يترك فارغاً.',
            'identification_number.regex' => 'رقم الهوية يجب ان يحتوي على ارقام فقط.', 
            'identification_number.unique' => 'رقم الهوية مستخدم مسبقاً',     
            'identification_version.required' => 'جهة الاصدار يجب ان لا يترك فارغاً.',
            'identification_version.regex' => 'جهة الاصدار يجب ان يحتوي على احرف وارقام فقط.',  
            'identification_date.required' => 'التاريخ يجب ان لا يترك فارغاً.',
            'identification_date.date' => 'التاريخ غير صحيح.',  
            // 'year.required' => 'السنة يجب ان لا يترك فارغاً.',
            // 'year.regex' => 'السنة يجب ان يحتوي على ارقام فقط.',
            // 'job.required' => 'الوظيفة يجب ان لا يترك فارغاً.',
            'job.regex' => 'الوظيفة يجب ان يحتوي على احرف وارقام فقط.',   
            // 'job_place.required' => 'الدائرة يجب ان لا يترك فارغاً.',
            'job_place.regex' => 'الدائرة يجب ان يحتوي على احرف وارقام فقط.',  
            // 'bank_name.required' => 'المصرف يجب ان لا يترك فارغاً.',
            'bank_name.regex' => 'المصرف يجب ان يحتوي على احرف وارقام فقط.',
            // 'card_password.required' => 'رمز البطاقة الذكية يجب ان لا يترك فارغاً.',
            'card_password.regex' => 'رمز البطاقة الذكية يجب ان يحتوي على احرف وارقام فقط.',
            'card_password.unique' => 'رمز البطاقة الذكية مستخدم مسبقاً',   
            'phone_council.regex' => 'رقم الهاتف مجلس البلدي يجب ان يحتوي على ارقام فقط.',
            // 'person_image.required' => 'الصورة الشخصية يجب ان لا تترك فارغة.',
            'person_image.mimes' => 'يجب اختيار صورة ذات امتداد [jpg, jpeg, png].',
            'person_image.max' => 'حجم الصورة يجب ان لا يزيد عن 2m.',
                    

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            if($request->file('person_image') !=''){
                $image = $request->file('person_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/assets/person_image'), $imageName);
            }

            $customer = new Customers;
            $customer->name = $request->input('name');
            $customer->address = $request->input('address');
            $customer->phone = $request->input('phone');
            $customer->mother_name = $request->input('mother_name');
            $customer->identification_number = $request->input('identification_number');
            $customer->identification_version = $request->input('identification_version');
            $customer->identification_date = $request->input('identification_date');
            // $customer->year = $request->input('year');
            $customer->job = $request->input('job');
            $customer->job_place = $request->input('job_place');
            $customer->bank_name = $request->input('bank_name');
            $customer->card_password = $request->input('card_password');
            $customer->phone_council = $request->input('phone_council');
            if($request->file('person_image') !=''){
                $customer->person_image = $imageName;
            }
            $customer->user_created = Auth::user()->username;
            $customer->save();

            toast('تمت الإضافة بنجاح.','success');
            // $request->session()->flash('success', 'تمت الإضافة بنجاح.');
            return redirect('customers');
        }

    }

    public function edit($id)
    {   
        $customers = DB::table('customers')->where('id', '=', $id)->get();
        return view('customers/edit',['customers'=>$customers]);
        
    }

    public function update(Request $request, $id)
    {
        // $rules = [
        //     'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
        //     'address' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
        //     'phone' => ['required', 'regex:/(^([0-9]+)?$)/u'],
        //     'person_image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
        //     'mother_name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
        //     'identification_number' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
        //     'identification_version' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'],
        //     'identification_date' => ['required', 'date'],
        //     'year' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
        //     'job' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
        //     'job_place' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
        //     'bank_name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
        //     'card_password' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'],
        //     'phone_council' => ['nullable', 'regex:/(^([0-9]+)?$)/u'],
        // ];

        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'address' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'phone' => ['required', 'regex:/(^([0-9]+)?$)/u'  , 'min:11' , 'max:11'],
            'person_image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
            'mother_name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'identification_number' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u'  , 'max:255'],
            'identification_version' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'identification_date' => ['required', 'date' , 'max:255'],
            'job' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'job_place' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'bank_name' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'card_password' => ['nullable', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u'  , 'max:255'],
            'phone_council' => ['nullable', 'regex:/(^([0-9]+)?$)/u' , 'max:255'],
        ];

        $customMessages = [
            'name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
            'address.required' => 'العنوان يجب ان لا يترك فارغاً.',
            'address.regex' => 'العنوان يجب ان يحتوي على احرف وارقام فقط.',                
            'phone.required' => 'رقم الهاتف يجب ان لا يترك فارغاً.',
            'phone.regex' => 'رقم الهاتف يجب ان يحتوي على ارقام فقط.',       
            'mother_name.required' => 'اسم الام يجب ان لا يترك فارغاً.',
            'mother_name.regex' => 'اسم الام يجب ان يحتوي على احرف وارقام فقط.', 
            'identification_number.required' => 'رقم الهوية يجب ان لا يترك فارغاً.',
            'identification_number.regex' => 'رقم الهوية يجب ان يحتوي على ارقام فقط.',   
            'identification_version.required' => 'جهة الاصدار يجب ان لا يترك فارغاً.',
            'identification_version.regex' => 'جهة الاصدار يجب ان يحتوي على احرف وارقام فقط.',  
            'identification_date.required' => 'التاريخ يجب ان لا يترك فارغاً.',
            'identification_date.date' => 'التاريخ غير صحيح.',  
            'year.required' => 'السنة يجب ان لا يترك فارغاً.',
            'year.regex' => 'السنة يجب ان يحتوي على ارقام فقط.',
            'job.required' => 'الوظيفة يجب ان لا يترك فارغاً.',
            'job.regex' => 'الوظيفة يجب ان يحتوي على احرف وارقام فقط.',   
            'job_place.required' => 'الدائرة يجب ان لا يترك فارغاً.',
            'job_place.regex' => 'الدائرة يجب ان يحتوي على احرف وارقام فقط.',  
            'bank_name.required' => 'المصرف يجب ان لا يترك فارغاً.',
            'bank_name.regex' => 'المصرف يجب ان يحتوي على احرف وارقام فقط.',
            'card_password.required' => 'رمز البطاقة الذكية يجب ان لا يترك فارغاً.',
            'card_password.regex' => 'رمز البطاقة الذكية يجب ان يحتوي على احرف وارقام فقط.',
            'phone_council.regex' => 'رقم الهاتف مجلس البلدي يجب ان يحتوي على ارقام فقط.',
            // 'person_image.required' => 'رمز البطاقة الذكية يجب ان لا يترك فارغاً.',
            'person_image.mimes' => 'يجب اختيار صورة ذات امتداد [jpg, jpeg, png].',
            'person_image.max' => 'حجم الصورة يجب ان لا يزيد عن 2m.',
                    

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            if($request->file('person_image') !=''){
                $image = $request->file('person_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/assets/person_image'), $imageName);

                $img = DB::table('customers')->where('id', '=', $id)->get();
                $im=$img[0]->person_image;
                if(\File::exists(public_path("/assets/person_image/$im"))) {
                    \File::delete(public_path("/assets/person_image/$im"));
                }

            }
            
            
            $customer = Customers::find($id);
            $customer->name = $request->input('name');
            $customer->address = $request->input('address');
            $customer->phone = $request->input('phone');
            $customer->mother_name = $request->input('mother_name');
            $customer->identification_number = $request->input('identification_number');
            $customer->identification_version = $request->input('identification_version');
            $customer->identification_date = $request->input('identification_date');
            // $customer->year = $request->input('year');
            $customer->job = $request->input('job');
            $customer->job_place = $request->input('job_place');
            $customer->bank_name = $request->input('bank_name');
            $customer->card_password = $request->input('card_password');
            $customer->phone_council = $request->input('phone_council');
            if($request->file('person_image') !=''){
                $customer->person_image = $imageName;
            }
            $customer->user_updated = Auth::user()->username;
            $customer->save();

            toast('تم التعديل بنجاح.','success');
            // $request->session()->flash('success', 'تم التعديل بنجاح.');
            return redirect('customers');
        }
        
    }


    public function destroy(Request $request)
    {
        $customers =Customers::find($request->GET('id'));
        $customers->user_deleted = Auth::user()->username;
        $customers->save();
        
        if($customers->delete()){
            $response['data'] = 'success';
        }else{
            $response['data'] = 'error';
        }

        return response()->json($response);
        
    }

}
