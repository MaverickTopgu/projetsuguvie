<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Section;
use App\Models\Brand;
use App\Models\User;
use Session; 
use Auth;
//use Illuminate\Support\Str;


class CouponsController extends Controller
{
    public function coupons(){
        Session::put('page','coupons');
        $adminType = Auth::guard('admin')->user()->type;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','votre compte vendeur est non approuvé pour le moment. 
                assurez vous de fournir les informations personnels et autres requis.');
            }
            $coupons = Coupon::where('vendor_id',$vendor_id)->get()->toArray();
        }else{
            $coupons = Coupon::get()->toArray();
        }
        
        
        //dd($coupons);
        return view('admin.coupons.coupons')->with(compact('coupons'));
    }

    public function updateCouponStatus(Request $request)
    {
        if($request->ajax())
        {
            $data=$request->all();
            //echo"<pre>";print_r($data);die;
            if($data['status']=="Active")
            {
                $status=0;
            }else
            {
                $status=1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
    }

    public function deleteCoupon($id)
    {
        //Delete Coupon
        Coupon::where('id',$id)->delete();
        $message = "Le Coupon a été supprimé avec Succès !";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditCoupon(Request $request,$id=null){
        if($id==""){
            //Add Coupon
            $title = "Ajouter un Coupon";
            //$title = "Add Coupon";
            $coupon = new Coupon;
            $selCats = array();
            $selBrands = array();
            $selUsers = array();
            $message = "le Coupon a été ajouté avec succès !";
        }else{
            //Update Coupon
            $title = "Modifier un Coupon";
            //$title = "Edit Coupon";
            $coupon = Coupon::find($id);
            $selCats = explode(',',$coupon['categories']);
            $selBrands = explode(',',$coupon['brands']);
            $selUsers = explode(',',$coupon['users']);
            $message = "le Coupon a été modifié avec succès !";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);

            $rules=
            [
                'categories'=>'required',
                'brands'=>'required',
                'coupon_option'=>'required',
                'coupon_type'=>'required',
                'amount_type'=>'required',
                'amount'=>'required|numeric',
                'expiry_date'=>'required',
                
            ];

            $customMessages = [
                // Add Custom Mesages here
                'categories.required' => 'Selectionner la ou les categorie(s) !',
                'brands.required' => 'Selectionner la ou les Marque(s) !',
                'coupon_option.required' => 'Selectionner l\'option (choix) du Coupon',
                'coupon_type.required' => 'Selectionner le type de Coupon',
                'amount_type.required' => 'Selectionner le type de Montant',
                'amount.required' => 'Entrer le Montant',
                'amount.numeric' => 'Entrer un Montant valide !',
                'expiry_date.required' => 'Entrer la date d\'expiration du coupon',
            
                
            ];

            $this->validate($request,$rules,$customMessages);

            if(isset($data['categories'])){
                $categories = implode(",",$data['categories']);
            }else{
                $categories="";
            }
            if(isset($data['brands'])){
                $brands = implode(",",$data['brands']);
            }else{
                $brands="";
            }
            if(isset($data['users'])){
                $users = implode(",",$data['users']);
            }else{
                $users="";
            }
            if($data['coupon_option']=="Automatic" && empty($id)){
               $coupon_code= str_random(8);
            }else{
               $coupon_code = $data['coupon_code'];
            }
            
            $adminType = Auth::guard('admin')->user()->type;

            if($adminType=="vendor"){
                $coupon->vendor_id = Auth::guard('admin')->user()->vendor_id;
            }else{
                $coupon->vendor_id = 0;
            }

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->brands = $brands;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1;
            $coupon->save();

            return redirect ('admin/coupons')->with('success_message',$message);
            
        }

        // Get Sections with Categories and Sub Categories

        $categories = Section::with('categories')->get()->toArray();
        //dd($categories);

        //Get All Brands

        $brands = Brand::where('status',1)->get()->toArray(); 

        //Get All User Email
        $users = User::select('email')->where('status',1)->get();

        return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','categories','brands',
        'users','selCats','selBrands','selUsers'));
    }
}
