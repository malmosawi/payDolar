<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Expenses;
use App\Models\User;
use DB;
use App;
use Auth;
use PDF;
use NumberFormatter;
Use Alert;

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

            toast('تمت الإضافة بنجاح.','success');
            // $request->session()->flash('success', 'تمت الإضافة بنجاح.');
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

            toast('تم التعديل بنجاح.','success');
            // $request->session()->flash('success', 'تم التعديل بنجاح.');
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


    public function show(Request $request , $id)
    {   
        PDF::SetTitle('PDF');
        PDF::AddPage();
        PDF::SetRTL(true);
        PDF::setPageFormat('A4','P');
        PDF::SetFont('arial','',11);

        $dis_expenses = DB::table('dis_expenses')->where([['id_expenses', '=', $id ],['deleted_at','=', null ]])->whereBetween('date',[$request->input('date_from'),$request->input('date_to')])->orderBy('date', 'DESC')->get();

        $html1='';
        if(false !== $dis_expenses){
            $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:5px; width:100%;" >';
            $html1 .= '<tr style=" border:1px solid black;"><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">تسلسل</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">إسم المصروف</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">المبلغ (بالدينار)</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">التاريخ</p></th></tr>';
        
            $c = 1;
            $x= PDF::getY();
            
            foreach($dis_expenses as $dis_expens){
                
                $expenses = DB::table('expenses')->where([['id', '=', $dis_expens->id] , ['deleted_at','=', null ]])->first();
                
                if ($x < (PDF::getPageHeight() - 100)) {

                    $html1 .= '<tr style=" border:1px solid black;"><td style=" border:1px solid black; ">'.$c.'</td><td style=" border:1px solid black; ">'.$expenses->expenses_name.'</td><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $dis_expens->money ).'</td><td style=" border:1px solid black; ">'.$dis_expens->date.'</td></tr>';
                    $x=$x+10;
                    $c=$c+1;
                }else{
                    $html1 .= '</table>';
                    $y= PDF::GetY();
                    PDF::SetXY(0,$y+5);
                    PDF::SetLeftMargin(5);
                    PDF::SetRightMargin(5);
                    PDF::WriteHtml($html1,true,false,false,true,'C');
                    PDF::AddPage();
                    PDF::SetRTL(true);
                    PDF::setPageFormat('A4','L');
                    PDF::SetFont('arial','',11);
                    PDF::SetLeftMargin(5);
                    PDF::SetRightMargin(5);
                    $html1='';
                    $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:5px; width:100%;" >';
                    $html1 .= '<tr style=" border:1px solid black;"><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">تسلسل</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">إسم المصروف</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">المبلغ (بالدينار)</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">التاريخ</p></th></tr>';
                    $x= PDF::getY();
                }//else
        
            }//foreach_suppliers

            $html1 .= '</table>';
            $y= PDF::GetY();
            PDF::SetXY(0,$y+5);
            PDF::SetLeftMargin(5);
            PDF::SetRightMargin(5);
            PDF::WriteHtml($html1,true,false,false,true,'C');
        
        }//if visits

        PDF::Output('expenses.pdf');  


    }


    public function showAll(Request $request)
    {   
        PDF::SetTitle('PDF');
        PDF::AddPage();
        PDF::SetRTL(true);
        PDF::setPageFormat('A4','P');
        PDF::SetFont('arial','',11);

        $dis_expenses = DB::table('dis_expenses')->where([['id_expenses', '<>', null ],['deleted_at','=', null ]])->whereBetween('date',[$request->input('date_from2'),$request->input('date_to2')])->orderBy('date', 'DESC')->get();

        $html1='';
        if(false !== $dis_expenses){
            $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:5px; width:100%;" >';
            $html1 .= '<tr style=" border:1px solid black;"><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">تسلسل</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">إسم المصروف</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">المبلغ (بالدينار)</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">التاريخ</p></th></tr>';
        
            $c = 1;
            $x= PDF::getY();
            
            foreach($dis_expenses as $dis_expens){
                
                $expenses = DB::table('expenses')->where([['id', '=', $dis_expens->id] , ['deleted_at','=', null ]])->first();
                
                if ($x < (PDF::getPageHeight() - 100)) {

                    $html1 .= '<tr style=" border:1px solid black;"><td style=" border:1px solid black; ">'.$c.'</td><td style=" border:1px solid black; ">'.$expenses->expenses_name.'</td><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $dis_expens->money ).'</td><td style=" border:1px solid black; ">'.$dis_expens->date.'</td></tr>';
                    $x=$x+10;
                    $c=$c+1;
                }else{
                    $html1 .= '</table>';
                    $y= PDF::GetY();
                    PDF::SetXY(0,$y+5);
                    PDF::SetLeftMargin(5);
                    PDF::SetRightMargin(5);
                    PDF::WriteHtml($html1,true,false,false,true,'C');
                    PDF::AddPage();
                    PDF::SetRTL(true);
                    PDF::setPageFormat('A4','L');
                    PDF::SetFont('arial','',11);
                    PDF::SetLeftMargin(5);
                    PDF::SetRightMargin(5);
                    $html1='';
                    $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:5px; width:100%;" >';
                    $html1 .= '<tr style=" border:1px solid black;"><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">تسلسل</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">إسم المصروف</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">المبلغ (بالدينار)</p></th><th style=" border:1px solid black; background-color:#f3f3f4;" ><p style="font-size:12px; font-family:arialbd;">التاريخ</p></th></tr>';
                    $x= PDF::getY();
                }//else
        
            }//foreach_suppliers

            $html1 .= '</table>';
            $y= PDF::GetY();
            PDF::SetXY(0,$y+5);
            PDF::SetLeftMargin(5);
            PDF::SetRightMargin(5);
            PDF::WriteHtml($html1,true,false,false,true,'C');
        
        }//if visits

        PDF::Output('expenses.pdf');  


    }


}
