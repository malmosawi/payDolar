<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InstallmentPay;
use App\Models\User;
use DB;
use App;
use Auth;
use PDF;
use NumberFormatter;

class InstallmentPayController extends Controller
{
    public function default()
    {   
        $contracts = DB::table('contract')->where([['id', '<>', null ] , ['deleted_at' , '=' , null ]])->orderBy('date', 'DESC')->get();
        return view('installmentPay.default' , ['contracts'=>$contracts]);
    }

    public function get_table(Request $request)
    {

        $customers = DB::table('contract')->where([['id_customers', '=', $request->GET('id_customers')] , ['deleted_at' , '=' , null ]])->orderBy('date', 'DESC')->get();
        $txt="";
        
        foreach ($customers as $key => $customer) {
            $txt.="<tr>";
            $contract = DB::table('contract')->where([['id', '=', $customer->id ] , ['date' , '=' , $customer->date ]])->orderBy('date', 'DESC')->get();
            // $contract = DB::table('contract')->where([['id', '=', $request->GET('id_contract') ] , ['date' , '=' , $request->GET('date') ]])->orderBy('date', 'DESC')->get();
        
            $txt.="<td>".preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract[0]->money )."</td>";
            // $txt.="<td>sfhfjdj</td>";
            $money_dinar = (((int)$contract[0]->money/100)*(int)$contract[0]->exchange_rate);
            $txt.="<td>".preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $money_dinar )."</td>";
            $txt.="<td>".preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $contract[0]->exchange_rate )."</td>";
            $kist_dolar = ((int)$contract[0]->money/(int)$contract[0]->months_number);
            $txt.="<td>".preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $kist_dolar )."</td>";
            $kist_dinar = ((int)$money_dinar/(int)$contract[0]->months_number);
            $txt.="<td class='kist_dinar'>".preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $kist_dinar )."</td>";
            $money_customers= DB::table('installment_pay')->where([['id_contract', '=', $contract[0]->id ] , ['date_contract' , '=' , $contract[0]->date ]])->sum('money');
            $txt.="<td>$money_customers</td>"; 
            $txt.="<td><input name='date-contract' id='date-contract' value='".$contract[0]->date."'</td>";  
            $txt.="<td>"; 
                $arr = explode('-', $contract[0]->date);
                for ($i=1; $i <= $contract[0]->months_number ; $i++) { 

                    if(($i+(int)$arr[1])>12)
                        $month=($i+(int)$arr[1])%12;
                    else
                        $month=($i+(int)$arr[1]);

                    $months_number= DB::table('installment_pay')->where([['id_contract', '=', $contract[0]->id ] , ['date_contract' , '=' , $contract[0]->date ] , ['months_number' , '=' , $month ]])->sum('months_number');
                    
                    $id_contract=$contract[0]->id;
                    if((int)$months_number ==0){
                        $txt.= '<form action="{{route('."installmentPay.store".' , ["'.id_contract.'"=>$id_contract , "'.kist_dinar.'"=>$kist_dinar , '."month".'=>$month ] )}}" autocomplete="on" method="post" enctype="multipart/form-data" > <input type="hidden" name="_token" value="'.csrf_token().'"> <input type="submit" value="شهر '.($month).'" name="submit" class="mb-2 btn btn-danger"></form>';
                    }else{
                        $txt.= '<a href="{{url("installmentPay/$id_contract/$month/update")}}" id="month_store" data-id="$id_contract" data-month="$month" data-toggle="modal" data-target="#modal_month_update" class="btn btn-success"> شهر '.($month).'</a>';
                    }
                }
            $txt.="</td>"; 
            $txt.="</tr>";
        }
        
        $response['data'] = $txt;
        return response()->json($response);

    }


    public function store($id_contract ,$kist_dinar, $month)
    {
            
        $contract = DB::table('contract')->where('id', '=', $id_contract )->orderBy('id', 'DESC')->get();
                            
        $installmentPay = new InstallmentPay;
        $installmentPay->id_contract = $contract[0]->id;
        $installmentPay->date_contract = $contract[0]->date;
        $installmentPay->money = str_replace("," , '', $kist_dinar);
        $installmentPay->exchange_rate = $contract[0]->exchange_rate;
        $installmentPay->months_number = $month;
        $installmentPay->date = date("Y-m-d");
        $installmentPay->user_created = Auth::user()->username;
        $installmentPay->save();

        $dinar_box = DB::table('setting')->where('id', '=', 1 )->sum('dinar_box');
        $plus = $dinar_box+(int)str_replace("," , '', $kist_dinar);

        $data=array('dinar_box'=>$plus);
        DB::table('setting')->where('id','=', 1)->update($data);

        return redirect('installmentPay');
        
    }


    public function print_catch($id_contract ,$date_contract, $month)
    {   
       

            $installmentPay = DB::table('installment_pay')->where([['id_contract', '=', $id_contract] ,['date_contract', '=', $date_contract] ,['months_number', '=', $month] , ['deleted_at','=', null ]])->orderBy('id', 'DESC')->get();
           
            PDF::SetTitle('PDF');
            PDF::AddPage();
            PDF::SetRTL(true);
            PDF::setPageFormat('A4','P');
            PDF::SetFont('arial','',11);

            $html1='';
            if(false !== $installmentPay){

                $contract = DB::table('contract')->where([ ['id', '=', $id_contract] , ['date', '=', $date_contract] ])->orderBy('id', 'DESC')->get();
                $customers = DB::table('customers')->where([['id', '=', $contract[0]->id_customers ],['deleted_at','=', null ]])->orderBy('id', 'DESC')->get();
                $im=asset('/assets/images/refootourism.png');  

                //shape_1
                $html1 .= '<table style=" align:center; text-align:center; margin:5px; padding:5px; width:100%;" >';
                $html1 .= '<tr><th colspan="5" style=" border:1px solid black; background-color:white;" ><table style="padding:20px; width:100%;"><tr><td style="text-align:center; font-size:16px; font-family:arialbd;"> وصل قبض <br> Cash Receipt Voucher </td> <td style="text-align:left; width:100%;"></td></tr></table></th></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> شركة / Company : <label style="font-size:12px; font-family:arial;">شواطى البصرة</label></td> <td style="text-align:center; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$installmentPay[0]->date.'</label> Date : </td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="color:red; font-size:12px; font-family:arial;">'.$installmentPay[0]->id.'</label> No : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color: #E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> أستلمت من : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$customers[0]->name.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Received From : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> مبلغاً قدره :  <label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_AR($installmentPay[0]->money).' دينار فقط </label></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_EN($installmentPay[0]->money).' IQD Only</label> The Sum of : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color:#E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> وذلک عن : </td> <td style="text-align:center; font-size:12px; font-family:arial;"></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> For : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> رقم الهاتف : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$customers[0]->phone.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Phone No. : </td></tr></table></td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; "></td><td style=" border:1px solid black;"> USD </td> <td rowspan="2" style="border:1px solid black;"> Accountant </td> <td rowspan="2" style="border:1px solid black;"> Received From </td><td rowspan="2" style="border:1px solid black;">Manager </td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $installmentPay[0]->money).'</td><td style=" border:1px solid black;"> IQD </td> <td colspan="3" style=" border:1px solid black;"></td> </tr>';
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
                $html1 .= '<tr><th colspan="5" style=" border:1px solid black; background-color:white;" ><table style="padding:20px; width:100%;"><tr><td style="text-align:center; font-size:16px; font-family:arialbd;"> وصل قبض <br> Cash Receipt Voucher </td> <td style="text-align:left; width:100%;"></td></tr></table></th></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> شركة / Company : <label style="font-size:12px; font-family:arial;">شواطى البصرة</label></td> <td style="text-align:center; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$installmentPay[0]->date.'</label> Date : </td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="color:red; font-size:12px; font-family:arial;">'.$installmentPay[0]->id.'</label> No : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color: #E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> أستلمت من : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$customers[0]->name.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Received From : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> مبلغاً قدره :  <label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_AR($installmentPay[0]->money).' دينار فقط </label></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"><label style="font-size:12px; font-family:arial;">'.$this->convertNumberToWord_EN($installmentPay[0]->money).' IQD Only</label> The Sum of : </td></tr></table></td></tr>';
                $html1 .= '<tr style="background-color:#E7E9EB;"><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> وذلک عن : </td> <td style="text-align:center; font-size:12px; font-family:arial;"></td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> For : </td></tr></table></td></tr>';
                $html1 .= '<tr><td colspan="5" style=" border:1px solid black; "><table style="padding:5px; width:100%;"><tr><td style="text-align:right; font-size:12px; font-family:arialbd;"> رقم الهاتف : </td> <td style="text-align:center; font-size:12px; font-family:arial;">'.$customers[0]->phone.'</td> <td style="text-align:left; font-size:12px; font-family:arialbd;"> Phone No. : </td></tr></table></td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; "></td><td style=" border:1px solid black;"> USD </td> <td rowspan="2" style="border:1px solid black;"> Accountant </td> <td rowspan="2" style="border:1px solid black;"> Received From </td><td rowspan="2" style="border:1px solid black;">Manager </td></tr>';
                $html1 .= '<tr><td style=" border:1px solid black; ">'.preg_replace("/\B(?=(\d{3})+(?!\d))/", ",", $installmentPay[0]->money).'</td><td style=" border:1px solid black;"> IQD </td> <td colspan="3" style=" border:1px solid black;"></td> </tr>';
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
            
            }//if installmentPay

            PDF::Output('installmentPay.pdf');  


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


}//class
