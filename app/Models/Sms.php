<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\SmsApi;

class Sms extends Model
{
    use HasFactory;

    public static function sendSms($message,$mobile){
        
        /*Code for SMS Script Starts*/
        $request ="";
        $param['authorization']="4b508e3dedbc840e5fa53ee27d15141b-1dfac27d-ae78-4744-b6dd-d3f30fbd23b0";
        //$param['sender_id'] = 'FSTSMS';
        $param['message']= $message;
        $param['numbers']= $mobile;
        $param['language']="french";
        $param['route']="p";

        foreach($param as $key=>$val) {
            $request.= $key."=".urlencode($val);
            $request.= "&";
        }
        $request = substr($request, 0, strlen($request)-1);

        $url ="y3w5d9.api.infobip.com/".$request;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        /*Code for SMS Script Ends*/

    }
}
