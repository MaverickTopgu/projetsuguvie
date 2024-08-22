<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Country;
use Auth;
use Validator;
use Session;
use Hash;

class UserController extends Controller
{
    public function loginRegister(){
        return view('front.users.login_register');
    }

    public function userRegister(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            $validator = Validator::make($request->all(), [
                'name'=>'required|string|max:100',
                'mobile' => 'required|numeric|digits_between:8,15',
                'email'=>'required|email|max:150|unique:users',
                'password'=>'required|min:8',
                'accept'=>'required'
            ],
            [
                'name.required'=>'le champ correspondant au nom est requis !',
                'mobile.required'=>'le champ correspondant au telephone est requis !',
                'email.required'=>'le champ correspondant à l\'adresse email est requis !',
                'password.required'=>'le champ correspondant au mot de passe est requis !',
                'accept.required'=>'veuillez accepter nos termes & conditions'
            ]
            );

            if($validator->passes()){
                // Register the User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                //Activate the user only when user confirm his email account
                $email = $data['email'];
                $messageData = ['name'=>$data['name'],'email'=>$data['email'],
                'code'=>base64_encode($data['email'])];

                Mail::send('emails.confirmation',$messageData,function($message)use($email){
                    $message->to($email)->subject('Confirmez votre Compte DôkôBa - vos achats en un éclair !');
                });

                //Redirect back user with success message
                $redirectTo = url('user/login-register');
                return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>
                'Veuillez confirmer votre email afin d\'activer votre Compte']);


                //Activate the user straight way without sending any confirmation email


                //Send Register Email
                /* $email = $data['email'];
                $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
                Mail::send('emails.register',$messageData,function($message)use($email){
                    $message->to($email)->subject('Bienvenue à DôkôBa - vos achats en un éclair !');
                }); */

                //Send Register SMS
                /* $message = "Cher/Chère Client, votre inscription sur la plateforme DôkôBa a réussi ! 
                connectez vous à votre compte afin d'avoir toutes les informations relatives à vos commandes ainqu'aux nouvelles offres. 
                Bienvznuz chez DôkôBa ";
                $mobile = $data['mobile'];
                Sms::sendSms($message,$mobile); */

                /* if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    $redirectTo = url('cart');

                    //Update User Cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }

                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                } */
                
                
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }
    }

    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'name'=>'required|string|max:100',
                'city' => 'required|nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'address' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'mobile' => 'required|digits_between:8,15',
                'pincode' => 'nullable|digits_between:4,15'
                
            ],
            [
                'name.required'=>'le champ correspondant au nom est requis !',
                'city.required'=>'le champ correspondant à la ville est requis !',
                'address.required'=>'le champ correspondant à l\'adresse est requis !',
                'country.required'=>'le champ correspondant au pays est requis !',
                'mobile.required'=>'le champ correspondant au telephone est requis !'
                
            ]
            );

            if($validator->passes()){

                //Update User Details
                User::where('id',Auth::user()->id)->update(['name'=>$data['name'],
                'mobile'=>$data['mobile'],'city'=>$data['city'],'state'=>$data['state'],
                'country'=>$data['country'],'pincode'=>$data['pincode'],'address'=>$data['address']]);

                //Redirect back User with success message
                return response()->json(['type'=>'success','message'=>'Les informations de Votre Compte ont été mise à jour avec succès !']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }
    }

    public function userUpdatePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'current_password'=>'required',
                'new_password'=>'required|min:8',
                'confirm_password'=>'required|min:8|same:new_password',
            ],
            [
                'current_password.required'=>'le champ correspondant au mot de passe actuel est requis !',
                'new_password.required'=>'le champ correspondant au nouveau mot de passe est requis !',
                'confirm_password.required'=>'le champ correspondant à la confirmation du nouveau mot de passe est requis !', 
                'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 8 caractères.',
                'new_password.max' => 'Le nouveau mot de passe ne doit pas dépasser 15 caractères.',
                'confirm_password.min' => 'Le mot de passe de confirmation doit contenir au moins 8 caractères.',
                'confirm_password.max' => 'Le mot de passe de confirmation ne doit pas dépasser 15 caractères.',
                'confirm_password.same' => 'Le mot de passe de confirmation ne correspond pas au nouveau mot de passe.'     
            ]
            
            );

            if($validator->passes()){

                $current_password = $data['current_password'];
                $checkPassword = User::where('id',Auth::user()->id)->first();
                if(Hash::check($current_password,$checkPassword->password)){

                    //Update User Current Password
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    //Redirect back User with success message
                return response()->json(['type'=>'success','message'=>'Votre mot de passe a été mise à jour avec succès !']);

                }else{
                    //Redirect back User with error message
                    return response()->json(['type'=>'incorrect','message'=>'mot de passe incorrect !']);
                }

                //Redirect back User with success message
                return response()->json(['type'=>'success','message'=>'Les informations de Votre Compte ont été mise à jour avec succès !']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }
    }

    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo"<pre>";print_r($data);die;

            $validator = Validator::make($request->all(), [
                    'email'=>'required|email|max:150|exists:users',
                ],
                [
                    'email.exists'=>'l\'adresse email n\'existe pas !',
                ]
            );

            if($validator->passes()){
                //Generate New Password
                $new_password = Str::random(16);
                // Update New Password
                User::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);

                //Get Uer Details
                $userDetails = User::where('email',$data['email'])->first()->toArray(); 

                //Send Email to User
                $email = $data['email'];
                $messageData = ['name'=>$userDetails['name'],'email'=>$email,
                    'password'=>$new_password];
                Mail::send('emails.user_forgot_password',$messageData,function($message)
            use($email){
                $message->to($email)->subject('Nouveau Mot de passe - DôkôBa --- Votre marché à porté de click !');
            });

            //Show Success Message
            return response()->json(['type'=>'success','message'=>'un nouveau mot de passe a été envoyé à votre adresse email.']);
                

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            return view('front.users.forgot_password');
        }
    }

    public function userLogin(Request $request){
        if($request->Ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data);die;

            $validator = Validator::make($request->all(), [
                'email'=>'required|email|max:150|exists:users',
                'password'=>'required|min:8',
            ]);

            if($validator->passes()){
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                    if(Auth::user()->status==0){
                        Auth::logout();

                        return response()->json(['type'=>'inactive','message'=>'Votre Compte ,n\'a pas été activé ! veuillez procéder à 
                        l\'activation en cliquant sur le lien dans le mail d\'activation de compte ']);
                    }

                    //Update User Cart with user id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }

                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }    
            }else{
                return response()->json(['type'=>'incorrect','message'=>'adresse email ou mot de passe incorrect !']);
            }
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }
    

    public function userLogout(){
        Auth::logout();
        return redirect('/');
    }

    public function confirmAccount($code){
        $email = base64_decode($code);
        $userCount = User::where('email',$email)->count();
        if($userCount>0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status==1){
                //Redirect the user to Login/Register Page with error message
                return redirect('user/login-register')->with('error_message','Votre Compte est déjà activé. Vous pouvez vous connecter maintenant !');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                //Send Welcome Email
                $messageData = ['name'=>$userDetails->name,'mobile'=>$userDetails->mobile,'email'=>$email];
                Mail::send('emails.register',$messageData,function($message)use($email){
                    $message->to($email)->subject('Bienvenue à DôkôBa - vos achats en un éclair !');
                }); 

                //Redirect the user to Login/Register Page with success message
                return redirect('user/login-register')->with('success_message','Votre Compte est activé. Vous pouvez vous connecter maintenant !');
            }
        }else{
            abort(404);
        }
    }
}
