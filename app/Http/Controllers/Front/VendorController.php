<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Vendor;
use Validator;
use DB;

class VendorController extends Controller
{
    public function loginRegister(){
        return view('front.vendors.login_register');

    }

    public function vendorRegister(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            //Validate Vendor
            $rules =[
                "name"=>"required",
                "email" => "required|email|unique:admins|unique:vendors",
                "mobile" => "required||min:14|numeric|unique:admins|unique:vendors",
                "accept" => "required"
            ];
            $customMessages = [
                "name.required" => "le nom est requis !",
                "email.required" => "l'adresse email est requise !",
                "email.unique" => "l'adresse email existe deja !",
                "mobile.required" => "le numero de telephone est requise !",
                "mobile.unique" => "le numero de telephone  existe deja !",
                "accept.required" => "acceptez les termes & conditions s'il vous plait !",
            ];
            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            DB::beginTransaction();
            
            //Create Vendor Account 

            //Insert the vendor details in vendors table
            $vendor = new Vendor;
            $vendor->name = $data['name'];
            $vendor->mobile = $data['mobile'];
            $vendor->email = $data['email'];
            $vendor->status = 0;

            //Set Default Timezone to Mali
            date_default_timezone_set("Africa/Bamako");
            $vendor->created_at = date("Y-m-d H:i:s");
            $vendor->updated_at = date("Y-m-d H:i:s");
            $vendor->save();

            $vendor_id = DB::getPdo()->lastInsertId();

            //insert the vendor details in admins table
            $admin = new Admin;
            $admin->type = 'vendor';
            $admin->vendor_id = $vendor_id;
            $admin->name = $data['name'];
            $admin->mobile = $data['mobile'];
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->status = 0;
            //Set Default Timezone to Mali
            date_default_timezone_set("Africa/Bamako");
            $admin->created_at = date("Y-m-d H:i:s");
            $admin->updated_at = date("Y-m-d H:i:s");
            $admin->save();

            //Send Confirmation Email
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'name' => $data['name'],
                'code' => base64_encode($data['email'])
            ];

            Mail::send('emails.vendor_confirmation',$messageData,function($message)use($email){
                $message->to($email)->subject('Confirmer votre compte Vendeur');
            });

            DB::commit();

            //Redirect back Vendor with success message
            $message = "Merci pour votre inscription en tant que vendeur. veuillez s'il vous plait activer votre compte à travers le mail qui vous été envoyé";

            return redirect()->back()->with('success_message',$message);

        }
    }

    public function confirmVendor($email){
        //Decode Vendor Email
        $email = base64_decode($email);

        //check if vendor Email exists
        $vendorCount = Vendor::where('email',$email)->count();
        if($vendorCount>0){
            //Vendor Email is already activate or not
            $vendorDetails = Vendor::where('email',$email)->first();
            if($vendorDetails->confirm == "Yes"){
                $message = "Votre Compte Vendeur a deja été confirmé. vous pouvez vous connecter";
                return redirect('vendor/login-register')->with('error_message',$message);
            }else{
                //update confirm column to yes in both admins / vendors tables to activate account
                Admin::where('email',$email)->update(['confirm'=>'Yes']);
                Vendor::where('email',$email)->update(['confirm'=>'Yes']);

                //Send Register Email
                $messageData = [
                    'email' => $email,
                    'name' => $vendorDetails->name,
                    'mobile' => $vendorDetails->mobile,
                ];

                Mail::send('emails.vendor_confirmed',$messageData,function($message)use($email){
                    $message->to($email)->subject('Confirmation de votre compte Vendeur');
                });

                //Redirect to Vendor Login/Register page with success message
                $message = "Votre compte vendeur est confirmé.
                 vous pouvez vous connectez et inserez vos informations personnelles,
                  orangeMoney ainsi que bancaires pour ajouter des produits.";
                return redirect('vendor/login-register')->with('success_message',$message);

                    }
        }else{
            abort(404);
        }

    }
}
