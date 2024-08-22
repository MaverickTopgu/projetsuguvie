$(document).ready(function(){
    $("#getPrice").change(function(){
        var size = $(this).val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/get-product-price',
            data:{size:size,product_id:product_id},
            type:'post',
            success:function(resp){
                //alert(resp['discount']);
                if(resp['discount']>0){
					$(".getAttributePrice").html("<div class='price'><h4>"+resp['final_price']+" F-CFA</h4></div><div class='original-price'><span>Prix Original: </span><span>"+resp['product_price']+" F-CFA</span></div>");
				}else{
					$(".getAttributePrice").html("<div class='price'><h4>"+resp['final_price']+" F-CFA</h4></div>");
				}
			},error:function(){
				alert("Error");
			}
        });
    });

    //Update Cart Items Qty
    $(document).on('click','.updateCartItem',function(){
        if($(this).hasClass('plus-a')){
            //Get Qty
            var quantity = $(this).data('qty');
            //increase the qty by 1
            new_qty = parseInt(quantity) + 1;
            //alert(new_qty);
        }
        if($(this).hasClass('minus-a')){
            //Get Qty
            var quantity = $(this).data('qty');
            //Check Qty is atleast 1
            if(quantity<=1){
                alert("La quantité d'articles doit être égale ou supérieure à 1 !");
                return false;
            }
            //increase the qty by 1
            new_qty = parseInt(quantity) - 1;
            //alert(new_qty);
        }
        var cartid = $(this).data('cartid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{cartid:cartid,qty:new_qty},
            url:'/cart/update',
            type:'post',
            success:function(resp){
                $(".totalCartItems").html(resp.totalCartItems);
                if(resp.status==false){
                    alert(resp.message);
                }
                $("#appendCartItems").html(resp.view);
                $("#appendHeaderCartItems").html(resp.headerview);
            },error:function(){
                alert("Erreur");
            }
        }); 
    });

    //Delete Cart Item
    $(document).on('click','.deleteCartitem',function(){
        var cartid = $(this).data('cartid');
        var result = confirm("souhaitez-vous supprimer cet article du panier ?");
        if(result){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{cartid:cartid},
                url:'/cart/delete',
                type:'post',
                success:function(resp){
                    $(".totalCartItems").html(resp.totalCartItems);
                    $("#appendCartItems").html(resp.view);
                    $("#appendHeaderCartItems").html(resp.headerview);
                },error:function(){
                    alert("Erreur");
                }
    
            })
        }
    });

    //Register Form Validation
    $("#registerForm").submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/register",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#register-"+i).attr('style','color:red');
                        $("#register-"+i).html(error);
                    setTimeout(function(){
                        $("#register-"+i).css({
                            'display':'none'
                        });
                    },5000);
                    });
                }else if(resp.type=="success"){
                    //alert(resp.message);
                    $(".loader").hide();
                    $("#register-success").attr('style','color:green;font-weight: 600');
                    $("#register-success").html(resp.message);
                }
                
            },error:function(){
                alert("Erreur");
            }
        })
    });

     //Account Form Validation
     $("#accountForm").submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/account",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#account-"+i).attr('style','color:red');
                        $("#account-"+i).html(error);
                    setTimeout(function(){
                        $("#account-"+i).css({
                            'display':'none'
                        });
                    },5000);
                    });
                }else if(resp.type=="success"){
                    //alert(resp.message);
                    $(".loader").hide();
                    $("#account-success").attr('style','color:green;font-weight: 600');
                    $("#account-success").html(resp.message);
                    setTimeout(function(){
                        $("#account-success").css({
                            'display':'none'
                        });
                    },5000);
                }
                
            },error:function(){
                alert("Erreur");
            }
        })
    });

    //Password Form Validation
    $("#passwordForm").submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/update-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#password-"+i).attr('style','color:red');
                        $("#password-"+i).html(error);
                    setTimeout(function(){
                        $("#password-"+i).css({
                            'display':'none'
                        });
                    },5000);
                    });
                }else if(resp.type=="incorrect"){
                    $(".loader").hide();
                    $("#password-error").attr('style','color:red');
                    $("#password-error").html(resp.message);
                    setTimeout(function(){
                        $("#password-error").css({
                            'display':'none'
                        });
                    },5000);
                }else if(resp.type=="success"){
                    //alert(resp.message);
                    $(".loader").hide();
                    $("#password-success").attr('style','color:green;font-weight: 600');
                    $("#password-success").html(resp.message);
                    setTimeout(function(){
                        $("#password-success").css({
                            'display':'none'
                        });
                    },5000);
                }
                
            },error:function(){
                alert("Erreur");
            }
        })
    });

     //Login Form Validation
     $("#loginForm").submit(function(){
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/login",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $.each(resp.errors,function(i,error){
                        $("#login-"+i).attr('style','color:red');
                        $("#login-"+i).html(error);
                    setTimeout(function(){
                        $("#login-"+i).css({
                            'display':'none'
                        });
                    },3000);
                    });
                }else if(resp.type=="incorrect"){
                    //alert(resp.message);
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                }else if(resp.type=="inactive"){
                    //alert(resp.message);
                    $("#login-error").attr('style','color:red');
                    $("#login-error").html(resp.message);
                }else if(resp.type=="success"){
                    window.location.href = resp.url;
                }
            },error:function(){
                alert("Erreur");
            }
        })
    });

    //Forgot Password Form Validation
    $("#forgotForm").submit(function(){
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url:"/user/forgot-password",
            type:"POST",
            data:formdata,
            success:function(resp){
                if(resp.type=="error"){
                    $(".loader").hide();
                    $.each(resp.errors,function(i,error){
                        $("#forgot-"+i).attr('style','color:red');
                        $("#forgot-"+i).html(error);
                    setTimeout(function(){
                        $("#forgot-"+i).css({
                            'display':'none'
                        });
                    },5000);
                    });
                }else if(resp.type=="success"){
                    //alert(resp.message);
                    $(".loader").hide();
                    $("#forgot-success").attr('style','color:green;font-weight: 600');
                    $("#forgot-success").html(resp.message);
                }
                
            },error:function(){
                alert("Erreur");
            }
        })
    });

    //Apply Coupon

    $("#ApplyCoupon").submit(function(){
        var user = $(this).attr("user");
        //alert(user);
        if(user==1){
            //do nothing
        }else{
            alert("Connectez-vous s'il vous plait afin d'utiliser votre Coupon de Réduction !");
            return false;
        }
        var code = $("#code").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            data:{code:code},
            url:'/apply-coupon',
            success:function(resp){
                if(resp.message!=""){
                    alert(resp.message);
                }
                $(".totalCartItems").html(resp.totalCartItems);
                $("#appendCartItems").html(resp.view);
                $("#appendHeaderCartItems").html(resp.headerview);
                if(resp.couponAmount>0){
                    $(".couponAmount").text(resp.couponAmount+" F-CFA");
                }else{
                    $(".couponAmount").text("0 F-CFA");
                }
                if(resp.grand_total>0){
                    $(".grand_total").text(resp.grand_total+" F-CFA");
                }
            },error:function(){
                alert("Erreur");
            }
        })
    });

    //Edit Delivery Address
    $(document).on('click','.editAddress',function(){
        var addressid = $(this).data("addressid");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{addressid:addressid},
            url:'/get-delivery-address',
            type:'post',
            success:function(resp){
                $("#showdifferent").removeClass("collapse");
                $(".newAddress").hide();
                $(".deliveryText").text("Modifier l'adresse de livraison");
                $('[name=delivery_id]').val(resp.address['id']);
                $('[name=delivery_name]').val(resp.address['name']);
                $('[name=delivery_address]').val(resp.address['address']);
                $('[name=delivery_city]').val(resp.address['city']);
                $('[name=delivery_state]').val(resp.address['state']);
                $('[name=delivery_country]').val(resp.address['country']);
                $('[name=delivery_pincode]').val(resp.address['pincode']);
                $('[name=delivery_mobile]').val(resp.address['mobile']);
            },error:function(){
                alert(Erreur);
            }
        });

    });

    //Save Delivery Address
    $(document).on('submit',"#addressAddEditForm",function(){
        var formdata = $("#addressAddEditForm").serialize();
        $.ajax({
            url:'/save-delivery-address',
            type:'post',
            data:formdata,
            success:function(data){
                //alert(data);
                $("#deliveryAddresses").html(data.view); 
            },error:function(){
                alert(Erreur);
            }
        });
    });
});

function get_filter(class_name){
    var filter = [];
    $('.'+class_name+':checked').each(function(){
        filter.push($(this).val());
    });
    return filter;
}