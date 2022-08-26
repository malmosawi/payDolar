<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InstallmentPay;
use App\Models\User;
use DB;
use App;
use Auth;

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


}//class
