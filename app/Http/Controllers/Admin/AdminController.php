<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Hash;
use Auth;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use App\Models\VendorsOrangemoneyDetail;
use App\Models\Country;

use Image;
use Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }

    public function updateAdminPassword(Request $request)
    {
        Session::put('page','update_admin_password');
        // echo"<pre>";print_r(Auth::guard('admin')->user());die;

        if ($request->isMethod('post'))
        {
            $data = $request->all();
            // echo"<pre>"; print_r($data);die;

            //check if current password entered by admin is correct
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password))
            {
                //check if new password enterred by admin is matching with confirm password
                if($data['confirm_password']==$data['new_password'])
                {
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);
                        return redirect()->back()->with('success_message','Votre Mot de passe à été mis à jour avec succes!');

                }else
                {
                    return redirect()->back()->with('error_message','Votre nouveau Mot de passe ne correspond pas à la confirmation !');
                }
            }else
            {
                return redirect()->back()->with('error_message','Votre Mot de passe Actuel est Incorrect !');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request)
    {
        $data = $request->all();
        // echo"<pre>"; print_r($data);die;
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password))
        {
            return "true";
        }else
        {
            return "false";
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page','update_admin_details');

        if($request->isMethod('post'))
        {
            $data = $request->all();
           // echo"<pre>";print_r($data);die;

            $rules=
            [
                'admin_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'=>'required|numeric',
            ];

            $customMessages = [
                // Add Custom Mesages here
                'admin_name.required' => 'votre Nom est réquis!',
                'admin_name.regex' => 'un nom valide est réquis!',
                'admin_moble.required' => 'votre Numero de telephone est réquis!',
                'admin_mobile.mobile'=>'saisissez un numero de telephone valide! ',
                
                
            ];
            $this->validate($request,$rules,$customMessages);

            //upload Admin Photo
            if($request->hasFile('admin_image'))
            {
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid())
                {
                    //Get Image Extension
                    $extension=$image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    //Upload the Image
                    Image::make($image_tmp)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image']))
            {
                $imageName = $data['current_admin_image'];

            }else 
            {
                $imageName ="";
            }

            //Update Admin Details
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            return redirect()->back()->with('success_message','Les informations Administrateurs ont éte mise à jour avec succes !');
        }
        return view('admin.settings.update_admin_details');
    }

    public function updateVendorDetails($slug, Request $request)
    {
        
        if($slug=="personal")
        {
            Session::put('page','update_personal_details');

            if($request->isMethod('post'))
            {
                $data = $request->all();
                //echo"<pre>";print_r($data);die;

                $rules=
                [
                    'vendor_name'=>'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_city'=>'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_mobile'=>'required|numeric',
                ];
    
                $customMessages = [
                    // Add Custom Mesages here
                    'vendor_name.required' => 'votre Nom est réquis!',
                    'vendor_city.required' => 'votre ville est réquise!',
                    'vendor_name.regex' => 'un nom valide est réquis!',
                    'vendor_city.regex' => 'une ville valide est réquise!',
                    'vendor_moble.required' => 'votre Numero de telephone est réquis!',
                    'vendor_mobile.mobile'=>'saisissez un numero de telephone valide! ',
                    
                    
                ];
                $this->validate($request,$rules,$customMessages);
    
                //upload Admin Photo
                if($request->hasFile('vendor_image'))
                {
                    $image_tmp = $request->file('vendor_image');
                    if($image_tmp->isValid())
                    {
                        //Get Image Extension
                        $extension=$image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        //Upload the Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_vendor_image']))
                {
                    $imageName = $data['current_vendor_image'];
    
                }else 
                {
                    $imageName ="";
                }
    
                //Update in Admins table Details
                Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],'image'=>$imageName]);
                //Update in Vendors table
                Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'],
                'addresse'=>$data['vendor_address'],'city'=>$data['vendor_city'],'state'=>$data['vendor_state'],'country'=>$data['vendor_country'],'pincode'=>$data['vendor_pincode']]);
                return redirect()->back()->with('success_message','Les informations Vendeur ont éte mise à jour avec succes !');
           
            }
            $vendorDetails = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();


        }else if($slug=="business")
        {
            Session::put('page','update_business_details');

            if($request->isMethod('post'))
            {
                $data = $request->all();
                //echo"<pre>";print_r($data);die;

                $rules=
                [
                    'shop_name'=>'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city'=>'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile'=>'required|numeric',
                    'address_proof'=>'required',
                    
                ];
    
                $customMessages = [
                    // Add Custom Mesages here
                    'shop_name.required' => 'votre Nom est réquis!',
                    'shop_city.required' => 'votre ville est réquise!',
                    'shop_name.regex' => 'un nom valide est réquis!',
                    'shop_city.regex' => 'une ville valide est réquise!',
                    'shop_moble.required' => 'votre Numero de telephone est réquis!',
                    'shop_mobile.numeric'=>'saisissez un numero de telephone valide! ',

                    
                    
                ];
                $this->validate($request,$rules,$customMessages);
    
                //upload Admin Photo
                if($request->hasFile('address_proof_image'))
                {
                    $image_tmp = $request->file('address_proof_image');
                    if($image_tmp->isValid())
                    {
                        //Get Image Extension
                        $extension=$image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/proofs/'.$imageName;
                        //Upload the Image
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_address_proof_image']))
                {
                    $imageName = $data['current_address_proof_image'];
    
                }else 
                {
                    $imageName ="";
                }
                $vendorCount = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){
                    //Update in vendors_business_details table
                    VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shop_name'],
                    'shop_mobile'=>$data['shop_mobile'],
                    'shop_address'=>$data['shop_address'],
                    'shop_city'=>$data['shop_city'],
                    'shop_state'=>$data['shop_state'],
                    'shop_country'=>$data['shop_country'],
                    'shop_pincode'=>$data['shop_pincode'], 'business_license_number'=>$data['business_license_number'],
                    'gst_number'=>$data['gst_number'], 'pan_number'=>$data['pan_number'],
                    'address_proof'=>$data['address_proof'], 'address_proof_image'=>$imageName]);

                }else{
                    VendorsBusinessDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'shop_name'=>$data['shop_name'],
                    'shop_mobile'=>$data['shop_mobile'],
                    'shop_address'=>$data['shop_address'],
                    'shop_city'=>$data['shop_city'],
                    'shop_state'=>$data['shop_state'],
                    'shop_country'=>$data['shop_country'],
                    'shop_pincode'=>$data['shop_pincode'], 'business_license_number'=>$data['business_license_number'],
                    'gst_number'=>$data['gst_number'], 'pan_number'=>$data['pan_number'],
                    'address_proof'=>$data['address_proof'], 'address_proof_image'=>$imageName]);
                }
                
               
                return redirect()->back()->with('success_message','Les informations Vendeur ont éte mise à jour avec succes !');
           
            }
            $vendorCount = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }else{
                $vendorDetails = array();
            }
           // dd($vendorDetails);
        }else if($slug=="bank")
        {
            Session::put('page','update_bank_details');

            if($request->isMethod('post'))
            {
                $data = $request->all();
                //echo"<pre>";print_r($data);die;

                $rules=
                [
                    'account_holder_name'=>'required|regex:/^[\pL\s\-]+$/u',
                    'bank_name'=>'required|regex:/^[\pL\s\-]+$/u',
                    'account_number'=>'required|numeric',
                    'bank_ifsc_code'=>'required',
                    
                ];
    
                $customMessages = [
                    // Add Custom Mesages here
                    'account_holder_name.required' => 'Le nom du tilulaire est réquis!',
                    'account_holder_name.regex' => 'un nom valide est réquis!',

                    'bank_name.required' => 'le nom de la banque est réquise!',
                    'account_number.required' => 'un Numero de compte est réquis!',
                    'account_number.numeric'=>'saisissez un numero de compte valide! ',
                    'bank_ifsc_code.required'=>'saisissez un code IFSC valide! ',      
                ];

                $this->validate($request,$rules,$customMessages);
                $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){            
                    //Update in vendors_bank_details table
                    VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name'],
                    'bank_name'=>$data['bank_name'],
                    'account_number'=>$data['account_number'],
                    'bank_ifsc_code'=>$data['bank_ifsc_code']],);
                }else{
                     //Update in vendors_bank_details table
                     VendorsBankDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'account_holder_name'=>$data['account_holder_name'],
                     'bank_name'=>$data['bank_name'],
                     'account_number'=>$data['account_number'],
                     'bank_ifsc_code'=>$data['bank_ifsc_code']],);
                }
                return redirect()->back()->with('success_message','Les informations Vendeur ont éte mise à jour avec succes !');
           
            }
            $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }else{
                $vendorDetails = array();
            }

        }else if($slug=="orangemoney")
        {
            Session::put('page','update_orangemoney_details');

            if($request->isMethod('post'))
            {
                $data = $request->all();
                //echo"<pre>";print_r($data);die;

                $rules=
                [
                    'account_holder_name'=>'required|regex:/^[\pL\s\-]+$/u',
                    'account_number'=>'required|numeric',
                    
                ];
    
                $customMessages = [
                    // Add Custom Mesages here
                    'account_holder_name.required' => 'Le nom du tilulaire est réquis!',
                    'account_holder_name.regex' => 'un nom valide est réquis!',

                    'account_number.required' => 'un Numero est réquis!',
                    'account_number.numeric'=>'saisissez un numero valide! ',
   
                ];

                $this->validate($request,$rules,$customMessages);
                $vendorCount = VendorsOrangemoneyDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){ 
                    //Update in vendors_Orangemoney_details table
                    VendorsOrangemoneyDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['account_holder_name'],
                    'account_number'=>$data['account_number'],],);
                }else{
                    VendorsOrangemoneyDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'account_holder_name'=>$data['account_holder_name'],
                    'account_number'=>$data['account_number'],],);
                }
                return redirect()->back()->with('success_message','Les informations Vendeur ont éte mise à jour avec succes !');
           
            }
            $vendorCount = VendorsOrangemoneyDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsOrangemoneyDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }else{
                $vendorDetails = array();
            }

        }
        $countries =Country::where('status',1)->get()->toArray();
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails','countries'));
    }

    public function login(Request $request)
    {
       // echo $password = Hash::make('12345678');die;
       if($request->isMethod('post'))
       {
            $data = $request->all();
           // echo"<pre>"; print_r($data);die;

           $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ];

        $customMessages = [
            // Add Custom Mesages here
            'email.required' => 'votre adresse email est réquise !',
            'email.email'=>'saisissez une adresse email coreecte ! ',
            'password.required'=>'votre mot de passe est réquis !',
            
        ];
            $this->validate($request,$rules,$customMessages);

            /* if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1]))
            {
                return redirect('admin/dashboard');
            }else
            {
                return redirect()->back()->with('error_message','adresse Email ou Mot de passe incorrect !');
            } */

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
            {
                if(Auth::guard('admin')->user()->type=="vendor" && Auth::guard('admin')->user()->confirm=="No"){
                    return redirect()->back()->with('error_message','cliquer sur le lien de confirmation qui vous a été envoye pour activer votre compte vendeur. ');
                }else if(Auth::guard('admin')->user()->type!="vendor" && Auth::guard('admin')->user()->status==0){
                    return redirect()->back()->with('error_message','votre compte administrateur est incatif ');
                }else{
                    return redirect('admin/dashboard');
                }
            }else
            {
                return redirect()->back()->with('error_message','adresse Email ou Mot de passe incorrect !');
            }
       }
        return view('admin.login');
    }
    public function admins($type=null)
    {
        $admins =Admin::query();
        if(!empty($type))
        {
            $admins=$admins->where('type',$type);
            $title = ucfirst($type)."s";
            Session::put('page','view_'.strtolower($title));//on peut mettre egalement mb_strtolower au cas ou on a des problemes avec strtolower
            

        }else
        {
            $title = "All Administrateurs/Sous-administrateurs/Vendeurs";
            Session::put('page','view_all');
        }
        $admins= $admins ->get()->toArray();
       // dd($admins);
       return view('admin.admins.admins')->with(compact('admins','title'));
    }

    public function viewVendorDetails($id)
    {
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank','VendorOrangemoney')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        //dd($vendorDetails);

        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request)
    {
        if($request->ajax())
        {
            $data=$request->all();
            /*echo"<pre>";print_r($data);die;*/
            if($data['status']=="Active")
            {
                $status=0;
            }else
            {
                $status=1;
            }
            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
            $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray();
            Vendor::where('id',$adminDetails['vendor_id'])->update(['status'=>$status]);
            if($adminDetails['type']=="vendor" && $status==1){
                
                //Send Approval Email
                $email = $adminDetails['email'];
                $messageData = [
                    'email' => $adminDetails['email'],
                    'name' => $adminDetails['name'],
                    'mobile' => $adminDetails['mobile']
                ];

                Mail::send('emails.vendor_approved',$messageData,function($message)use($email){
                    $message->to($email)->subject('Votre compte Vendeur a été approuvé !');
                });
            }

            return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
