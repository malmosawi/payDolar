<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Suppliers;
use App\Models\SuppliersCatch;
use App\Models\User;
use DB;
use App;
use Auth;
use PDF;
use NumberFormatter;
Use Alert;

class SuppliersCatchController extends Controller
{
    public function default()
    {   
        $suppliers_catch = SuppliersCatch::orderBy('id', 'DESC')->get();
        //$suppliers_catch = DB::table('suppliers_catch')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_catch.default' , ['suppliers_catch'=>$suppliers_catch]);
    }

    public function create()
    {   
        $suppliers = Suppliers::orderBy('id', 'DESC')->get();
        // $suppliers = DB::table('suppliers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('suppliers_catch.create' , ['suppliers'=>$suppliers]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            'note' => ['nullable', 'string' , 'max:1000'],
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

            $SuppliersCatch = new SuppliersCatch;
            $SuppliersCatch->id_suppliers = $request->input('name');
            $SuppliersCatch->money = $m2;
            $SuppliersCatch->exchange_rate = $m3;
            $SuppliersCatch->date = $request->input('date');
            $SuppliersCatch->user_created = Auth::user()->username;
            $SuppliersCatch->save();

            $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
            //$money = DB::table('suppliers_catch')->where([['id_suppliers', '=',  $request->input('name')], ['money', '=',  $m2], ['exchange_rate', '=',  $m3], ['date', '=',  $request->input('date')]])->sum('money');
            $minus = $money_setting+$SuppliersCatch->money;

            $data=array('dolar_box'=>$minus);
            DB::table('setting')->where('id','=', 1)->update($data);

            toast('تمت الإضافة بنجاح.','success');
            // $request->session()->flash('success', 'تمت الإضافة بنجاح.');
            return redirect('suppliersCatch');

        }

    }

    public function edit($id)
    {   
        $suppliersCatch = DB::table('suppliers_catch')->where([['id', '=', $id] , ['deleted_at' , '=' , null ]])->get();
        $suppliers = DB::table('suppliers')->where([['id', '<>', null ] , ['deleted_at' , '=' , null ]])->orderBy('id', 'DESC')->get();
        return view('suppliers_catch/edit',['suppliersCatch'=>$suppliersCatch , 'suppliers'=>$suppliers]);
        
    }

    public function update(Request $request, $id , $old_money)
    {
        
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            'note' => ['nullable', 'string' , 'max:1000'],
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
            
            $SuppliersCatch = SuppliersCatch::find($id);
            $SuppliersCatch->id_suppliers = $request->input('name');
            $SuppliersCatch->money = $m2;
            $SuppliersCatch->exchange_rate = $m3;
            $SuppliersCatch->date = $request->input('date');
            $SuppliersCatch->user_updated = Auth::user()->username;
            $SuppliersCatch->save();

            $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
            //$money = DB::table('suppliers_catch')->where([['id_suppliers', '=',  $request->input('name')], ['money', '=',  $m2], ['exchange_rate', '=',  $m3], ['date', '=',  $request->input('date')]])->sum('money');
            $minus = (($money_setting-$old_money)+$SuppliersCatch->money);

            $data=array('dolar_box'=>$minus);
            DB::table('setting')->where('id','=', 1)->update($data);

            toast('تم التعديل بنجاح.','success');
            // $request->session()->flash('success', 'تم التعديل بنجاح.');
            return redirect('suppliersCatch');

        }//else
            
        
    }

    public function destroy(Request $request)
    {
        $SuppliersCatch =SuppliersCatch::find($request->GET('id'));
        $SuppliersCatch->user_deleted = Auth::user()->username;
        $SuppliersCatch->save();

        $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
        $money = DB::table('suppliers_catch')->where('id', '=',  $request->GET('id') )->sum('money');
        $minus = ($money_setting-$money);

        $data=array('dolar_box'=>$minus);
        DB::table('setting')->where('id','=', 1)->update($data);
        
        if($SuppliersCatch->delete()){
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
       

            $catch = DB::table('suppliers_catch')->where([['id', '=', $id] , ['deleted_at','=', null ]])->orderBy('id', 'DESC')->get();
           
            PDF::SetTitle('PDF');
            PDF::AddPage();
            PDF::SetRTL(true);
            PDF::setPageFormat('A4','P');
            PDF::SetFont('arial','',11);

            $html1='';
            if(false !== $catch){

                $suppliers = DB::table('suppliers')->where([['id', '=', $catch[0]->id_suppliers ],['deleted_at','=', null ]])->orderBy('id', 'DESC')->get();
                $im=asset('/assets/images/refootourism.png');  

                //shape_1
                $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:2px; width:100%;" >';
                $html1 .= '<tr><th colspan="5" style=" border:1px solid black; background-color:white;" ><table style="padding:20px; width:100%;"><tr><td style="text-align:center; font-size:16px; font-family:arialbd;"> وصل قبض <br> Cash Receipt Voucher </td> <td style="text-align:left; width:100%;"></td></tr></table></th></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> شركة / Company : <label style="font-size:12px; font-family:arial;">شواطى البصرة</label></td> <td style="text-align:center; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$catch[0]->date.'</label> Date : </td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="color:red; font-size:12px; font-family:arial;">'.$catch[0]->id.'</label> No : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color: #E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> أستلمت من : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$suppliers[0]->name.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Received From : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> مبلغاً قدره :  <label style="font-size:10px; font-family:arial;">'.$this->convertNumberToWord_AR($catch[0]->money).' دولار فقط </label></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="font-size:10px; font-family:arial;">'.$this->convertNumberToWord_EN($catch[0]->money).' USD Only</label> The Sum of : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color:#E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> وذلک عن : </td> <td style="text-align:center; font-size:12px; font-family:arial;"></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> For : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> رقم الهاتف : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$suppliers[0]->phone.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Phone No. : </td></tr></table></td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $catch[0]->money).'</td><td style=" border:1px solid black;"> USD </td> <td rowspan="2" style="border:1px solid black;"> Accountant </td> <td rowspan="2" style="border:1px solid black;"> Received From </td><td rowspan="2" style="border:1px solid black;">Manager </td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; "></td><td style=" border:1px solid black;"> IQD </td> <td colspan="3" style=" border:1px solid black;"></td> </tr>';
                $html1 .= '<tr><td colspan="5" style="border:1px solid black;"> <br><br>'.$catch[0]->note.'<br> </td></tr>';
                
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
                $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:2px; width:100%;" >';
                $html1 .= '<tr><th colspan="5" style=" border:1px solid black; background-color:white;" ><table style="padding:20px; width:100%;"><tr><td style="text-align:center; font-size:16px; font-family:arialbd;"> وصل قبض <br> Cash Receipt Voucher </td> <td style="text-align:left; width:100%;"></td></tr></table></th></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> شركة / Company : <label style="font-size:12px; font-family:arial;">شواطى البصرة</label></td> <td style="text-align:center; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$catch[0]->date.'</label> Date : </td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="color:red; font-size:12px; font-family:arial;">'.$catch[0]->id.'</label> No : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color: #E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> أستلمت من : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$suppliers[0]->name.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Received From : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> مبلغاً قدره :  <label style="font-size:10px; font-family:arial;">'.$this->convertNumberToWord_AR($catch[0]->money).' دولار فقط </label></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="font-size:10px; font-family:arial;">'.$this->convertNumberToWord_EN($catch[0]->money).' USD Only</label> The Sum of : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color:#E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> وذلک عن : </td> <td style="text-align:center; font-size:12px; font-family:arial;"></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> For : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> رقم الهاتف : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$suppliers[0]->phone.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Phone No. : </td></tr></table></td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $catch[0]->money).'</td><td style=" border:1px solid black;"> USD </td> <td rowspan="2" style="border:1px solid black;"> Accountant </td> <td rowspan="2" style="border:1px solid black;"> Received From </td><td rowspan="2" style="border:1px solid black;">Manager </td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; "></td><td style=" border:1px solid black;"> IQD </td> <td colspan="3" style=" border:1px solid black;"></td> </tr>';
                $html1 .= '<tr><td colspan="5" style="border:1px solid black;"> <br><br>'.$catch[0]->note.'<br> </td></tr>';
                
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
            
            }//if catch

            PDF::Output('catch.pdf');  


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


}
