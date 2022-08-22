<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Expenses;
use App\Models\User;
use DB;
use App;
use Auth;

class expensesController extends Controller
{
    public function default()
    {   
        $expenses = Expenses::orderBy('id', 'DESC')->get();
        // $expenses = DB::table('expenses')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('expenses.default' , ['expenses'=>$expenses]);
    }

    public function create()
    {   
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'expenses_name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'unique:expenses' , 'max:255'],
        ];

        $customMessages = [
            'expenses_name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'expenses_name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $expenses = new Expenses;
            $expenses->expenses_name = $request->input('expenses_name');
            
            $expenses->user_created = Auth::user()->username;
            $expenses->save();

            $request->session()->flash('success', 'تمت الإضافة بنجاح.');
            return redirect('expenses');
        }

    }

    public function edit($id)
    {   
        $expenses = DB::table('expenses')->where('id', '=', $id)->get();
        return view('expenses/edit',['expenses'=>$expenses]);
        
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'expenses_name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
        ];

        $customMessages = [
            'expenses_name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'expenses_name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $expenses = Expenses::find($id);
            $expenses->expenses_name = $request->input('expenses_name');
            $expenses->user_updated = Auth::user()->username;
            $expenses->save();

            $request->session()->flash('success', 'تم التعديل بنجاح.');
            return redirect('expenses');
        }
        
    }

    public function destroy(Request $request)
    {
        $expenses =Expenses::find($request->GET('id'));
        $expenses->user_deleted = Auth::user()->username;
        $expenses->save();
        
        if($expenses->delete()){
            $response['data'] = 'success';
        }else{
            $response['data'] = 'error';
        }

        return response()->json($response);
        
    }


}
