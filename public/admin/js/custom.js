$(document).ready(function()
{
    //call datatable class
    $('#sections').DataTable({"language": {
        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }});

    $('#categories').DataTable({"language": {
        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }});

    $('#brands').DataTable({"language": {
        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }});

    $('#products').DataTable({"language": {
        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }});

    $('#banners').DataTable({"language": {
        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }});

    $('#filters').DataTable({"language": {
        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }});

    $('#coupons').DataTable({"language": {
        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }});

    $('#users').DataTable({"language": {
        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
    }});

    $(".nav-item").removeClass("active");
    $(".nav-link").removeClass("active");

    //Check Admin Password is correct or not
    $("#current_password").keyup(function()
    {
        var current_password = $("#current_password").val();
        // alert(current_password);
        $.ajax(
           
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'post',
                url:'/admin/check-admin-password',
                data:{current_password:current_password},
                success:function(resp)
                {
                    // alert(resp);
                    if(resp=="false")
                    {
                        $("#check_password").html("<font color='red'> Le Mot de passe Actuel est Incorrect !</font>");
                    }else if(resp=="true")
                    {
                        $("#check_password").html("<font color='green'> Le Mot de passe Actuel est Correct !</font>");

                    }
                },error:function()
                {
                    alert('Error');
                }
            });
    })

     //Update Admin Status 
     $(document).on("click",".updateAdminStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        
        //alert(admin_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'post',
                url:'/admin/update-admin-status',
                data:{status:status,admin_id:admin_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#admin-"+admin_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#admin-"+admin_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Erreur");
                }
            })
        
    });

    //Update Banner Status 
    $(document).on("click",".updateBannerStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        //alert(banner_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'post',
                url:'/admin/update-banner-status',
                data:{status:status,banner_id:banner_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#banner-"+banner_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#banner-"+banner_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

     //Update Section Status 
     $(document).on("click",".updateSectionStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        //alert(section_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'post',
                url:'/admin/update-section-status',
                data:{status:status,section_id:section_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#section-"+section_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#section-"+section_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

     //Update Category Status 
     $(document).on("click",".updateCategoryStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        //alert(category_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'post',
                url:'/admin/update-category-status',
                data:{status:status,category_id:category_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#category-"+category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#category-"+category_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });


     //Update Brands Status 
     $(document).on("click",".updateBrandStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        //alert(brand_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'post',
                url:'/admin/update-brand-status',
                data:{status:status,brand_id:brand_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#brand-"+brand_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#brand-"+brand_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

    //Update Users Status 
    $(document).on("click",".updateUserStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var user_id = $(this).attr("user_id");
        //alert(user_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'post',
                url:'/admin/update-user-status',
                data:{status:status,user_id:user_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#user-"+user_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#user-"+user_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

    //Update Products Status 
    $(document).on("click",".updateProductStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        //alert(product_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                type:'post',
                url:'/admin/update-product-status',
                data:{status:status,product_id:product_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#product-"+product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#product-"+product_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

    //Update Coupons Status 
    $(document).on("click",".updateCouponStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var coupon_id = $(this).attr("coupon_id");
        //alert(coupon_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
                type:'post',
                url:'/admin/update-coupon-status',
                data:{status:status,coupon_id:coupon_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#coupon-"+coupon_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#coupon-"+coupon_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Erreur");
                }
            })
        
    });

    //Update Filter Status 
    $(document).on("click",".updateFilterStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        //alert(filter_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                type:'post',
                url:'/admin/update-filter-status',
                data:{status:status,filter_id:filter_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#filter-"+filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#filter-"+filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

    //Update FilterValue Status 
    $(document).on("click",".updateFilterValueStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var filter_id = $(this).attr("filter_id");
        //alert(filter_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                type:'post',
                url:'/admin/update-filter-value-status',
                data:{status:status,filter_id:filter_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#filter-"+filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#filter-"+filter_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

    //Update Attribute Status 
    $(document).on("click",".updateAttributeStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var attribute_id = $(this).attr("attribute_id");
        //alert(attribute_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                type:'post',
                url:'/admin/update-attribute-status',
                data:{status:status,attribute_id:attribute_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#attribute-"+attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#attribute-"+attribute_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

    //Update Image Status 
    $(document).on("click",".updateImageStatus",function()
    {
        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");
        //alert(image_id);
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                type:'post',
                url:'/admin/update-image-status',
                data:{status:status,image_id:image_id},
                success:function(resp)
                {
                    //alert(resp);
                    if(resp['status']==0)
                    {
                        $("#image-"+image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-outline ' status='Inactive'></i>")
                    }
                    else if(resp['status']==1)
                    {
                        $("#image-"+image_id).html("<i style='font-size:25px;' class='mdi mdi-bookmark-check ' status='Active'></i>")
                    }
                },error:function()
                {
                    alert("Error");
                }
            })
        
    });

    
    

    // //Confirm Deletion (Simple Javascript)
    // $(".confirmDelete").click(function()
    // {
    //     var title = $(this).attr("title");
    //     if(confirm("Êtes vous sûr de vouloir supprimer la "+title+" ?"))
    //     {
    //         return true;
    //     }else
    //     {
    //         return false;
    //     }
    // })

     //Confirm Deletion (SweetAlert Library)
        $(document).on("click",".confirmDelete",function(){

        
        var module = $(this).attr('module');
        var moduleid = $(this).attr('moduleid');

        Swal.fire({
            title: 'Êtes vous sûr ?',
            text: "vous ne pourrez plus revenir en arriere !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Annuler',
            confirmButtonText: 'Oui, supprimer!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Supprimée!',
                'La Session a été supprimée avec succès .',
                'success'
              )
              window.location = "/admin/delete-"+module+"/"+moduleid;

            }
          })
     })
     
     //Append Categories Level

     $("#section_id").change(function()
     {
        var section_id = $(this).val();
        $.ajax(
            {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'get',
                url:'/admin/append-categories-level',
                data:{section_id:section_id},
                success:function(resp)
                {
                    
                    $("#appendCategoriesLevel").html(resp);
                },
                error:function()
                {
                    alert("Erreur");
                }
            })
     });

     //Products Attributes Add/Remove Script

     var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" placeholder="La taille" style="width: 160px;"/>&nbsp;<input type="text" name="sku[]" placeholder="numero de réference" style="width: 160px;"/>&nbsp;<input type="text" name="price[]" placeholder="Le prix" style="width: 160px;"/>&nbsp;<input type="text" name="stock[]" placeholder="La quantité" style="width: 160px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Retirer</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    // Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increase field counter
            $(wrapper).append(fieldHTML); //Add field html
        }else{
            alert('A maximum of '+maxField+' fields are allowed to be added. ');
        }
    });
    
    // Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrease field counter
        });

        //Show Filters on selection of Category
        $("#category_id").on('change',function(){
            var category_id = $(this).val();
            //alert(category_id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
                type:'post',
                url:'category-filters',
                data:{category_id:category_id},
                success:function(resp){
                    $(".loadFilters").html(resp.view);
                }
            });
        });

        //Show/Hide Coupon field for Manual/Automatic
        $("#ManualCoupon").click(function(){
            $("#couponField").show();
        });

        $("#AutomaticCoupon").click(function(){
            $("#couponField").hide();
        });

        
});