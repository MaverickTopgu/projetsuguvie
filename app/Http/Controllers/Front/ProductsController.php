<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use App\Models\Vendor;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Models\Country;
use Session;
use DB;
use Auth;

class ProductsController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data);die;
            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                //Get Category Details
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                
                //Checking for Dynamic Filters
                $productFilters = ProductsFilter::productFilters();
                foreach($productFilters as $key => $filter){
                    //if filter is selected
                    if(isset($filter['filter_column']) && isset($data[$filter['filter_column']]) && !empty($filter['filter_column']) && !empty($data[$filter['filter_column']])){
                        $categoryProducts->whereIn($filter['filter_column'],$data[$filter['filter_column']]);
                    }
                }
            
                //checking for sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('products.product_price','Asc');
    
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('products.product_price','Desc');
    
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
    
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
    
                    }
                }

                //checking for size
                if(isset($data['size']) && !empty($data['size'])){
                    $productIds = ProductsAttribute::select('product_id')->whereIn('size',$data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                 //checking for Color
                 if(isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('product_color',$data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }
                //checking for Price
                $productIds = array();
                if(!empty($data['price'])){
                    foreach($data['price'] as $key => $price){
                        $priceArr = explode('-',$price);
                        if(isset($priceArr[0]) && isset($priceArr[1])){
                            $getPricepids = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])->get()->toArray();
                            $productIds[] = array_column($getPricepids, 'id');
                        }
                    }
                    $productIds = array_unique(array_flatten($productIds));
                    //echo "<pre>";print_r($productIds);die;
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //checking for Brand
                if(isset($data['brand']) && !empty($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id', $productIds);
                }
                
                $categoryProducts = $categoryProducts->paginate(30);
                /* dd($categoryDetails);
                echo "La categorie existe ";die; */
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
    
            }else{
                abort(404);
            }
        }else{
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                //Get Category Details
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
    
                //checking for sort
                if(isset($_GET['sort']) && !empty($_GET['sort'])){
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderby('products.id','Desc');
                    }else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderby('products.product_price','Asc');
    
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderby('products.product_price','Desc');
    
                    }else if($_GET['sort']=="name_a_z"){
                        $categoryProducts->orderby('products.product_name','Asc');
    
                    }else if($_GET['sort']=="name_z_a"){
                        $categoryProducts->orderby('products.product_name','Desc');
    
                    }
                }
                
                $categoryProducts = $categoryProducts->paginate(30);
                /* dd($categoryDetails);
                echo "La categorie existe ";die; */
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
    
            }else{
                abort(404);
            }
        }
       
        
    }

    public function vendorListing($vendorid){
        //Get Vendor Shop Name
        $getVendorShop = Vendor::getVendorShop($vendorid);

       // Get Vendor Products
       $vendorProducts = Product::with('brand')->where('vendor_id',$vendorid)->where('status',1);
       $vendorProducts = $vendorProducts->paginate(30);
       return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));
    }

    public function detail($id){
        $productDetails = Product::with(['section','category','brand','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images','vendor'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
        //dd($productDetails);

        //Get Similar Products
        $similarProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])
        ->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();
        //dd($similarProducts);

        //Set Session for Recently Viewed Products
        if(empty(Session::get('session_id'))){
           $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }

        Session::put('session_id',$session_id);

        //Insert Product in table if not already exists
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedProducts==0){
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
        }

        //Get Recently Viewed Products Ids
        $recentProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)
        ->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        //dd($recentProductsIds);

        //Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('brand')->whereIn('id',$recentProductsIds)->get()->toArray();
        //dd($recentlyViewedProducts);

        //Get Group Products (Porduct Colors)
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_image')->where('id','!=',$id)
            ->where(['group_code'=>$productDetails['group_code'],'status'=>1])->get()->toArray();
            //dd($groupProducts);
        }

        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');
        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentlyViewedProducts','groupProducts'));
    }

    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['size']);
            return $getDiscountAttributePrice;
        }
    }

    public function cartAdd(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            //Check Product Stock is available or not
            $getProductStock = ProductsAttribute::getProductStock($data['product_id'],$data['size']);
            if($getProductStock<$data['quantity']){
                return redirect()->back()->with('error_message','la quantité souhaitée n\'est pas disponible' );
                }

            //Generate Session Id if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
                }

            //Check Product if already exists in the User Cart
            if(Auth::check()){
                //User is logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],
                'size'=>$data['size'],'user_id'=>$user_id])->count();
                }else{
                //User is not logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],
                'size'=>$data['size'],'session_id'=>$session_id])->count();
                }

                if($countProducts>0){
                    return redirect()->back()->with('error_message','Cet article existe déjà dans le panier !');
                }

            //Save Product in Carts table
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->size = $data['size'];
            $item->quantity = $data['quantity'];
            $item->save();
            return redirect()->back()->with('success_message','le produit a été ajouté à votre panier <a style="text-decoration:underline !important;" href="/cart">voir mon panier</a>');
        }
    }

    public function cart(){
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);
        return view('front.products.cart')->with(compact('getCartItems'));
    }

    public function cartUpdate(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;

            //Get Cart Details 
            $cartDetails = Cart::find($data['cartid']);

            //Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->
                where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();

                //echo "<pre>";print_r($availableStock);die;

                //Check if desired Stock from user is available
                if($data['qty']>$availableStock['stock']){
                    $getCartItems = Cart::getCartItems();
                    return response()->json([
                        'status'=>false,
                        'message'=>'Le produit n\'est plus disponible en stock !',
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                        ]);
                }

                //Check if product size is available
                $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],
                    'size'=>$cartDetails['size'],'status'=>1])->count();
                if($availableSize==0){
                    $getCartItems = Cart::getCartItems();
                    return response()->json([
                        'status'=>false,
                        'message'=>'La taille de produit n\'est plus disponible . veuillez supprimer ce produit et en choisir un autre !',
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                        ]);
                }

            // Update the Qty    
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
        }
    }

    public function cartDelete(Request $request){
        if($request->ajax()){
            Session::forget('couponAmount');
            Session::forget('couponCode');
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            Cart::where('id',$data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
        }
    }

    public function applyCoupon(Request $request){
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
           $getCartItems = Cart::getCartItems();
           //echo "<pre>"; print_r($getCartItems);die;
           $totalCartItems = totalCartItems();
           $couponCount = Coupon::where('coupon_code',$data['code'])->count();
           if($couponCount==0){
            return response()->json([
                'status'=>false,
                'totalCartItems'=>$totalCartItems,
                'message'=>'Le Coupon n\'est pas valide !',
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
           }else{
            // Check for other Coupon conditions
            
            // Get Coupon Details
            $couponDetails = Coupon::where('coupon_code',$data['code'])->first();

            // Check if Coupon is active

            if($couponDetails->status==0){
                $message = "Le Coupon n'est pas active !";
            }

            // Check if Coupon is expired
            $expiry_date = $couponDetails->expiry_date;
            $current_date = date('y-m-d');
            
            if($expiry_date > $current_date){
                $message = "Le Coupon est expiré !";
            }

            // Check if Coupon is from selected categories

            // Get all selected categories from coupon and convert to array
            $catArr = explode(",",$couponDetails->categories);

            // Check if any cart item not belong to coupon category
            $total_amount = 0;
            foreach($getCartItems as $key => $item){
                if(!in_array($item['product']['category_id'],$catArr)){
                    $message = "Ce code coupon ne correspond à aucun des articles selectionnées !";
                }
                $attrPrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
                //echo "<pre>";print_r($attrPrice);die;
                $total_amount = $total_amount + ($attrPrice['final_price']*$item['quantity']);
            }

            // Check if coupon is from selected users
            // Get all selected users from coupon and convert to array
            if(isset($couponDetails->users)&&!empty($couponDetails->users)){
                $usersArr = explode(",",$couponDetails->users);

                if(count($usersArr)){
                    // Get User Id's of all selected users
                    foreach ($usersArr as $key => $user) {
                        $getUserId = User::select('id')->where('email',$user)->first()->toArray();
                        $usersId[] = $getUserId['id'];
                    }

                    // Check if any cart item not belong to coupon user
                    foreach ($getCartItems as $item) {
                        if(!in_array($item['user_id'],$usersId)){
                            $message = "Ce code coupon ne vous est pas destiné. Réessayez avec un autre !";
                        }
                    }
                }

            }
            

            if($couponDetails->vendor_id>0){
                $productIds = Product::select('id')->where('vendor_id',$couponDetails->vendor_id)->pluck('id')->toArray();
                // Check if coupon belongs to Vendor products
                foreach ($getCartItems as $item) {
                    if(!in_array($item['product']['id'],$productIds)){
                        $message = "Ce code coupon ne vous est pas destiné. Réessayez avec un autre !";
                    }
                }
            }

            //If error message is there
            if(isset($message)){
                return response()->json([
                    'status'=>false,
                    'totalCartItems'=>$totalCartItems,
                    'message'=>$message,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]); 
            }else{
                // Coupon code is correct

                // Check if Coupon amount type is Fixed or percentage
                if($couponDetails->amount_type=="Fixed"){
                    $couponAmount = $couponDetails->amount;
                }else{
                    $couponAmount = $total_amount * ($couponDetails->amount/100);
                }

                $grand_total = $total_amount - $couponAmount;

                // Add Coupon Code & Amount in Session Variables
                Session::put('couponAmount',$couponAmount);
                Session::put('couponCode',$data['code']);

                $message = "La réduction à été appliqué !";
                
                return response()->json([
                    'status'=>true,
                    'totalCartItems'=>$totalCartItems,
                    'couponAmount'=>$couponAmount,
                    'grand_total'=>$grand_total,
                    'message'=>$message,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]); 
            }

           }
        }
    }

    public function checkout(){
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        $countries = Country::where('status',1)->get()->toArray();
        return view('front.products.checkout')->with(compact('deliveryAddresses','countries'));
    }
}

