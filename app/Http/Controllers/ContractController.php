<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Contract;
use App\Models\User;
use DB;
use App;
use Auth;
use PDF;
use NumberFormatter;

class ContractController extends Controller
{
    public function default()
    {   
        $contracts = Contract::orderBy('id', 'DESC')->get();
        return view('contract.default' , ['contracts'=>$contracts]);
    }

    public function create()
    {   
        $customers = DB::table('customers')->where('id', '<>', null)->orderBy('id', 'DESC')->get();
        return view('contract.create' , ['customers'=>$customers]);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'add_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'money_month' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'months_number' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
        ];

        $customMessages = [
            'name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
            'money.required' => 'المبلغ يجب ان لا يترك فارغاً.',
            'money.regex' => 'المبلغ يجب ان يحتوي على ارقام فقط.',       
            'exchange_rate.required' => 'سعر الصرف يجب ان لا يترك فارغاً.',
            'exchange_rate.regex' => 'سعر الصرف يجب ان يحتوي على ارقام فقط.', 
            'add_rate.required' => 'نسبة الاضافة يجب ان لا يترك فارغاً.',
            'add_rate.regex' => 'نسبة الاضافة يجب ان يحتوي على ارقام فقط.',
            'money_month.required' => 'المبلغ الدفع الشهري يجب ان لا يترك فارغاً.',
            'money_month.regex' => 'المبلغ الدفع الشهري يجب ان يحتوي على ارقام فقط.',
            'months_number.required' => 'عدد اشهر التسديد يجب ان لا يترك فارغاً.',
            'months_number.regex' => 'عدد اشهر التسديد يجب ان يحتوي على ارقام فقط.',
            'date.required' => 'التاريخ يجب ان لا يترك فارغاً.',
            'date.date' => 'التاريخ غير صحيح.',  

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $m1 = str_replace("," , '', $request->input('dolar_box'));
            $m2 = str_replace("," , '', $request->input('dinar_box'));
            $m3 = str_replace("," , '', $request->input('money'));
            $m4 = str_replace("," , '', $request->input('money_month'));
            $m5 = str_replace("," , '', $request->input('exchange_rate'));

            if((int)$m3 > (int)$m1){

                return back()->with('error', 'مبلغ الدولار اكبر من صندوق الدولار');

            }else{

                $contract = new Contract;
                $contract->id_customers = $request->input('name');
                $contract->money = $m3;
                $contract->exchange_rate = $m5;
                $contract->add_rate = $request->input('add_rate');
                $contract->money_month = $m4;
                $contract->months_number = $request->input('months_number');
                $contract->date = $request->input('date');
                $contract->user_created = Auth::user()->username;
                $contract->save();

                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $money = DB::table('contract')->where([['id_customers', '=',  $request->input('name')], ['money', '=',  $m3], ['exchange_rate', '=',  $m5] , ['add_rate', '=',  $request->input('add_rate')] , ['money_month', '=',  $m4] , ['months_number', '=',  $request->input('months_number')], ['date', '=',  $request->input('date')]])->sum('money');
                $minus = $money_setting-$money;

                $data=array('dolar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تمت الإضافة بنجاح.');
                return redirect('contract');
            }//else

        }

    }

    public function edit($id)
    {   
        $contracts = DB::table('contract')->where([['id', '=', $id] , ['deleted_at' ,'=' , null ]])->get();
        $customers = DB::table('customers')->where([['id', '<>', null] , ['deleted_at' ,'=' , null ]])->get();
        return view('contract/edit',['contracts'=>$contracts , 'customers'=>$customers]);
        
    }

    public function update(Request $request, $id , $old_money_dolar)
    {
        
        $rules = [
            'name' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9 ]+)?$)/u' , 'max:255'],
            'money' => ['required','regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'exchange_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'add_rate' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'money_month' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'months_number' => ['required', 'regex:/(^([\p{Arabic}a-zA-z0-9.,()-\/ ]+)?$)/u' , 'max:255'],
            'date' => ['required', 'date' , 'max:255'],
            
        ];

        $customMessages = [
            'name.required' => 'الاسم يجب ان لا يترك فارغاً.',
            'name.regex' => 'الاسم يجب ان يحتوي على احرف وارقام فقط.',
            'money.required' => 'المبلغ يجب ان لا يترك فارغاً.',
            'money.regex' => 'المبلغ يجب ان يحتوي على ارقام فقط.',       
            'exchange_rate.required' => 'سعر الصرف يجب ان لا يترك فارغاً.',
            'exchange_rate.regex' => 'سعر الصرف يجب ان يحتوي على ارقام فقط.', 
            'add_rate.required' => 'نسبة الاضافة يجب ان لا يترك فارغاً.',
            'add_rate.regex' => 'نسبة الاضافة يجب ان يحتوي على ارقام فقط.',
            'money_month.required' => 'المبلغ الدفع الشهري يجب ان لا يترك فارغاً.',
            'money_month.regex' => 'المبلغ الدفع الشهري يجب ان يحتوي على ارقام فقط.',
            'months_number.required' => 'عدد اشهر التسديد يجب ان لا يترك فارغاً.',
            'months_number.regex' => 'عدد اشهر التسديد يجب ان يحتوي على ارقام فقط.',
            'date.required' => 'التاريخ يجب ان لا يترك فارغاً.',
            'date.date' => 'التاريخ غير صحيح.',  

        ];

            
        $validator = Validator::make($request->all(), $rules, $customMessages);
        
        if($validator->fails()){
          return back()->withErrors($validator->errors())->withInput();
        }else{

            $m1 = str_replace("," , '', $request->input('dolar_box'));
            $m2 = str_replace("," , '', $request->input('dinar_box'));
            $m3 = str_replace("," , '', $request->input('money'));
            $m4 = str_replace("," , '', $request->input('money_month'));
            $m5 = str_replace("," , '', $request->input('exchange_rate'));

            if((int)$m3 > ((int)$m1+(int)$old_money_dolar)){

                return back()->with('error', 'مبلغ الدولار اكبر من صندوق الدولار');

            }else{

                $contract = Contract::find($id);
                $contract->id_customers = $request->input('name');
                $contract->money = $m3;
                $contract->exchange_rate = $m5;
                $contract->add_rate = $request->input('add_rate');
                $contract->money_month = $m4;
                $contract->months_number = $request->input('months_number');
                $contract->date = $request->input('date');
                $contract->user_updated = Auth::user()->username;
                $contract->save();

                $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
                $money = DB::table('contract')->where([['id_customers', '=',  $request->input('name')], ['money', '=',  $m3], ['exchange_rate', '=',  $m5] , ['add_rate', '=',  $request->input('add_rate')] , ['money_month', '=',  $m4] , ['months_number', '=',  $request->input('months_number')], ['date', '=',  $request->input('date')]])->sum('money');
                $minus = (($money_setting+$old_money_dolar)-$money);

                $data=array('dolar_box'=>$minus);
                DB::table('setting')->where('id','=', 1)->update($data);

                $request->session()->flash('success', 'تم التعديل بنجاح.');
                return redirect('contract');
            }//else

        }
        
    }


    public function destroy(Request $request)
    {
        $contract =Contract::find($request->GET('id'));
        $contract->user_deleted = Auth::user()->username;
        $contract->save();

        $money_setting = DB::table('setting')->where('id', '=', 1 )->sum('dolar_box');
        $money = DB::table('contract')->where('id', '=',  $request->GET('id') )->sum('money');
        $minus = ($money_setting+$money);

        $data=array('dolar_box'=>$minus);
        DB::table('setting')->where('id','=', 1)->update($data);
        
        if($contract->delete()){
            $response['data'] = 'success';
        }else{
            $response['data'] = 'error';
        }

        return response()->json($response);
        
    }

    public function print_catch($id)
    {   
       

            $contract = DB::table('contract')->where([['id', '=', $id] , ['deleted_at','=', null ]])->orderBy('id', 'DESC')->get();
           
            PDF::SetTitle('PDF');
            PDF::AddPage();
            PDF::SetRTL(true);
            PDF::setPageFormat('A4','P');
            PDF::SetFont('arial','',11);

            $html1='';
            if(false !== $contract){

                $customers = DB::table('customers')->where([['id', '=', $contract[0]->id_customers ],['deleted_at','=', null ]])->orderBy('id', 'DESC')->get();
                $im=asset('/assets/images/refootourism.png');  

                //shape_1
                $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:5px; width:100%;" >';
                $html1 .= '<tr><th colspan="5" style=" border:1px solid black; background-color:white;" ><table style="padding:20px; width:100%;"><tr><td style="text-align:center; font-size:16px; font-family:arialbd;"> وصل صرف <br> Cash Receipt Voucher </td> <td style="text-align:left; width:100%;"></td></tr></table></th></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> شركة / Company : <label style="font-size:12px; font-family:arial;">شواطى البصرة</label></td> <td style="text-align:center; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$contract[0]->date.'</label> Date : </td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="color:red; font-size:12px; font-family:arial;">'.$contract[0]->id.'</label> No : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color: #E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> سلمت الى : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$customers[0]->name.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Received To : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> مبلغاً قدره :  <label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_AR($contract[0]->money).' دولار فقط </label></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_EN($contract[0]->money).' USD Only</label> The Sum of : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color:#E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> وذلک عن : </td> <td style="text-align:center; font-size:12px; font-family:arial;"></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> For : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> رقم الهاتف : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$customers[0]->phone.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Phone No. : </td></tr></table></td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract[0]->money).'</td><td style=" border:1px solid black;"> USD </td> <td rowspan="2" style="border:1px solid black;"> Accountant </td> <td rowspan="2" style="border:1px solid black;"> Received To </td><td rowspan="2" style="border:1px solid black;">Manager </td></tr>';
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
                $html1 .= '<tr style="background-color: #E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> سلمت الى : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$customers[0]->name.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Received To : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> مبلغاً قدره :  <label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_AR($contract[0]->money).' دولار فقط </label></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_EN($contract[0]->money).' USD Only</label> The Sum of : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color:#E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> وذلک عن : </td> <td style="text-align:center; font-size:12px; font-family:arial;"></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> For : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> رقم الهاتف : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$customers[0]->phone.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Phone No. : </td></tr></table></td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract[0]->money).'</td><td style=" border:1px solid black;"> USD </td> <td rowspan="2" style="border:1px solid black;"> Accountant </td> <td rowspan="2" style="border:1px solid black;"> Received To </td><td rowspan="2" style="border:1px solid black;">Manager </td></tr>';
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
            
            }//if contract

            PDF::Output('contract.pdf');  


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
