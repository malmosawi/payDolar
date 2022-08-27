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
use PDF;
use NumberFormatter;

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

    public function print_catch($id)
    {   
       

            $expenses = DB::table('suppliers_expenses')->where([['id', '=', $id] , ['deleted_at','=', null ]])->orderBy('id', 'DESC')->get();
           
            PDF::SetTitle('PDF');
            PDF::AddPage();
            PDF::SetRTL(true);
            PDF::setPageFormat('A4','P');
            PDF::SetFont('arial','',11);

            $html1='';
            if(false !== $expenses){

                $suppliers = DB::table('suppliers')->where([['id', '=', $expenses[0]->id_suppliers ],['deleted_at','=', null ]])->orderBy('id', 'DESC')->get();
                $im=asset('/assets/images/refootourism.png');  

                //shape_1
                $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:5px; width:100%;" >';
                $html1 .= '<tr><th colspan="5" style=" border:1px solid black; background-color:white;" ><table style="padding:20px; width:100%;"><tr><td style="text-align:center; font-size:16px; font-family:arialbd;"> وصل صرف <br> Cash Receipt Voucher </td> <td style="text-align:left; width:100%;"></td></tr></table></th></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> شركة / Company : <label style="font-size:12px; font-family:arial;">شواطى البصرة</label></td> <td style="text-align:center; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$expenses[0]->date.'</label> Date : </td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="color:red; font-size:12px; font-family:arial;">'.$expenses[0]->id.'</label> No : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color: #E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> سلمت الى : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$suppliers[0]->name.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Received To : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> مبلغاً قدره :  <label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_AR($expenses[0]->money).' دولار فقط </label></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_EN($expenses[0]->money).' USD Only</label> The Sum of : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color:#E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> وذلک عن : </td> <td style="text-align:center; font-size:12px; font-family:arial;"></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> For : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> رقم الهاتف : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$suppliers[0]->phone.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Phone No. : </td></tr></table></td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $expenses[0]->money).'</td><td style=" border:1px solid black;"> USD </td> <td rowspan="2" style="border:1px solid black;"> Accountant </td> <td rowspan="2" style="border:1px solid black;"> Received To </td><td rowspan="2" style="border:1px solid black;">Manager </td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; "></td><td style=" border:1px solid black;"> IQD </td> <td colspan="3" style=" border:1px solid black;"></td> </tr>';
                $html1 .= '<tr><td colspan="5" style="border:1px solid black;"> <br><br><br><br> </td></tr>';
                
                $html1 .= '</table>';

                $y= PDF::GetY();
                PDF::SetXY(0,$y);
                PDF::SetLeftMargin(5);
                PDF::SetRightMargin(5);
                PDF::WriteHtml($html1,true,false,false,true,'C');

                $img= '<img src="'.$im.'" style="width:150px; height:60px;">';
                PDF::SetRTL(false);
                PDF::SetXY(120,15);
                PDF::WriteHtml($img,true,false,false,true,'C');

                //-----------------------------------------------------------------------------------------------------------------------------------------------------  
                //shape_2
                $html1='';
                $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:5px; width:100%;" >';
                $html1 .= '<tr><th colspan="5" style=" border:1px solid black; background-color:white;" ><table style="padding:20px; width:100%;"><tr><td style="text-align:center; font-size:16px; font-family:arialbd;"> وصل صرف <br> Cash Receipt Voucher </td> <td style="text-align:left; width:100%;"></td></tr></table></th></tr>';
                $html1 .= '<tr style="background-color: #E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> سلمت الى : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$suppliers[0]->name.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Received To : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> مبلغاً قدره :  <label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_AR($expenses[0]->money).' دولار فقط </label></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_EN($expenses[0]->money).' USD Only</label> The Sum of : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color:#E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> وذلک عن : </td> <td style="text-align:center; font-size:12px; font-family:arial;"></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> For : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> رقم الهاتف : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$suppliers[0]->phone.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Phone No. : </td></tr></table></td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $expenses[0]->money).'</td><td style=" border:1px solid black;"> USD </td> <td rowspan="2" style="border:1px solid black;"> Accountant </td> <td rowspan="2" style="border:1px solid black;"> Received To </td><td rowspan="2" style="border:1px solid black;">Manager </td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; "></td><td style=" border:1px solid black;"> IQD </td> <td colspan="3" style=" border:1px solid black;"></td> </tr>';
                $html1 .= '<tr><td colspan="5" style="border:1px solid black;"> <br><br><br><br> </td></tr>';
                
                $html1 .= '</table>';

                PDF::SetRTL(true);
                $y= PDF::GetY();
                PDF::SetXY(0,$y+118);
                PDF::SetLeftMargin(5);
                PDF::SetRightMargin(5);
                PDF::WriteHtml($html1,true,false,false,true,'C');

                $img= '<img src="'.$im.'" style="width:150px; height:60px;">';
                PDF::SetRTL(false);
                PDF::SetXY(120,165);
                PDF::WriteHtml($img,true,false,false,true,'C');
            
            }//if expenses

            PDF::Output('expenses.pdf');  


    }

    function convertNumberToWord_AR($num)
    {
        $num = trim($num);
        $num = (double) $num;
        if(!$num) {
            return false;
        }else{
            $f = new NumberFormatter("ar", NumberFormatter::SPELLOUT);
            $aver_word=$f->format($num);
        }//else

        return $aver_word;
    }

    function convertNumberToWord_EN($num)
    {
        $num = trim($num);
        $num = (double) $num;
        if(!$num) {
            return false;
        }else{
            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
            $aver_word=ucfirst($f->format($num));
        }//else

        return $aver_word;
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
