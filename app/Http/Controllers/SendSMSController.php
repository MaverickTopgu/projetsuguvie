<?php

namespace App\Http\Controllers;

use Infobip\Api\SmsApi;
use Infobip\Configuration;
use Illuminate\Http\Request;
//use App\Http\Controllers\SmsApi;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;


class SendSMSController extends Controller
{
    public function loadPage(){
        return view('send_sms');
    }

    public function sendSMS(Request $request){
        $configuration = new Configuration(
            host: 'y3w5d9.api.infobip.com', // get these data from the account dashboard
            apiKey: '4b508e3dedbc840e5fa53ee27d15141b-1dfac27d-ae78-4744-b6dd-d3f30fbd23b0'
        );

        $sendSmsApi = new SmsApi(config: $configuration);
    
        $message = new SmsTextualMessage(
            destinations: [
                new SmsDestination(to: $request->number)
            ],
            from: 'DKB',
            text: $request->message,
        );
    
        $request = new SmsAdvancedTextualRequest(messages: [$message]);
    
        try {
            $smsResponse = $sendSmsApi->sendSmsMessage($request);
            return redirect('/send_sms')->with('success','le SMS a été envoyé avec succès !');
        } catch (ApiException $apiException) {
            return redirect('send_sms')->with('fail',$apiException->getMessage());
        }
    }
}
