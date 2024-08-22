@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Mettre à jour les informations du vendeur</h3>
                        <!-- <h6 class="font-weight-normal mb-0">Mettre à Jour le Mot de Passe Administrateur </h6> -->
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($slug=="personal")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Mettre à Jour les informations personelles du vendeur</h4>
                  @if(Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Erreur: </strong>{{ Session::get('error_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif

                     @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong>{{ Session::get('success_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                     @if($errors->any())
                                    
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                     
                                    @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="post" name="updateAdminPasswordForm" id="updateAdminPasswordForm" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Nom d'utilisateur vendeur / adresse-Email</label>
                      <input  class="form-control"  value="{{ Auth::guard('admin')->user()->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="vendor_name">Nom </label>
                      <input type="text" class="form-control" id="vendor_name" value="{{ Auth::guard('admin')->user()->name }}" placeholder="Entrer votre Nom"name="vendor_name">
                      
                    </div>
                    
                    <div class="form-group">
                      <label for="vendor_address">Adresse </label>
                      <input type="text" class="form-control" id="vendor_address" value="{{ $vendorDetails['addresse'] }}" placeholder="Entrer votre adresse"name="vendor_address">
                    </div>
                    <div class="form-group">
                      <label for="vendor_city">Ville </label>
                      <input type="text" class="form-control" id="vendor_city" value="{{ $vendorDetails['city'] }}" placeholder="Entrer votre ville"name="vendor_city" >
                      
                    </div>
                    <div class="form-group">
                      <label for="vendor_state">Region </label>
                      <input type="text" class="form-control" id="vendor_state" value="{{ $vendorDetails['state'] }}" placeholder="Entrer votre region"name="vendor_state" >
                      
                    </div>
                    <div class="form-group">
                      <label for="vendor_country">Pays </label>
                      <!-- <input type="text" class="form-control" id="vendor_country" value="{{ $vendorDetails['country'] }}" placeholder="Entrer votre pays"name="vendor_country" Required> -->
                      <select class="form-control" id="vendor_country" name="vendor_country" style="color:#495057;">
                        <option value=""> Choisissez votre Pays </option>
                        @foreach($countries as $country)
                        <option value="{{ $country['country_name'] }}" @if($country['country_name']== $vendorDetails['country']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                      </select>
                      
                    </div>
                    
                    <div class="form-group">
                      <label for="vendor_pincode">Code Pin </label>
                      <input type="text" class="form-control" id="vendor_pincode" value="{{ $vendorDetails['pincode'] }}" placeholder="Entrer votre code pin"name="vendor_pincode">
                      
                    </div>
                    
                    <div class="form-group">
                      <label for="vendor_mobile"> Mobile/telephone </label>
                      <input type="text" class="form-control" id="vendor_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" placeholder="Entrer votre numero de telephone" name="vendor_mobile" Required maxlength="10" minlength="10" >
                    </div>
                    
                    <div class="form-group">
                      <label for="vendor_image"> Photo </label>
                      <input type="file" class="form-control" id="vendor_image" name="vendor_image" >
                      @if(!empty(Auth::guard('admin')->user()->image))
                        <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}"> voir la photo </a>
                        <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            
            </div>
          </div>
        </div>
        @elseif($slug=="business")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Mettre à Jour les informations de commerce du vendeur</h4>
                  @if(Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Erreur: </strong>{{ Session::get('error_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif

                     @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong>{{ Session::get('success_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                     @if($errors->any())
                                    
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                     
                                    @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="post" name="updateAdminPasswordForm" id="updateAdminPasswordForm" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Nom d'utilisateur vendeur / adresse-Email</label>
                      <input  class="form-control"  value="{{ Auth::guard('admin')->user()->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="shop_name">Nom de la Boutique </label>
                      <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Entrer le Nom de la Boutique" @if(isset($vendorDetails['shop_name'])) value="{{ $vendorDetails['shop_name'] }}" @endif >
                    </div>
                    
                    <div class="form-group">
                      <label for="shop_address">Adresse de la Boutique </label>
                      <input type="text" class="form-control" id="shop_address" @if(isset($vendorDetails['shop_address'])) value="{{ $vendorDetails['shop_address'] }}" @endif placeholder="Entrer l'adresse de la Boutique" name="shop_address" >
                    </div>
                    <div class="form-group">
                      <label for="shop_city">Ville de la Boutique </label>
                      <input type="text" class="form-control" id="shop_city" @if(isset($vendorDetails['shop_city'])) value="{{ $vendorDetails['shop_city'] }}" @endif placeholder="Entrer la ville de la Boutique" name="shop_city" >
                      
                    </div>
                    <div class="form-group">
                      <label for="shop_state">Region de la Boutique </label>
                      <input type="text" class="form-control" id="shop_state" @if(isset($vendorDetails['shop_state'])) value="{{ $vendorDetails['shop_state'] }}" @endif placeholder="Entrer la region de la Boutique" name="shop_state" >
                      
                    </div>
                    <div class="form-group">
                      <label for="shop_country">Pays de la Boutique </label>
                      <select class="form-control" id="shop_country" name="shop_country" style="color:#495057;">
                        <option value=""> Choisissez votre Pays </option>
                        @foreach($countries as $country)
                          <option value="{{ $country['country_name'] }}" @if(isset($vendorDetails['shop_country']) && $country['country_name']==$vendorDetails['shop_country']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                      </select>
                      
                    </div>
                    
                    <div class="form-group">
                      <label for="shop_pincode">Code Pin de la Boutique </label>
                      <input type="text" class="form-control" id="shop_pincode"  @if(isset($vendorDetails['shop_pincode'])) value="{{ $vendorDetails['shop_pincode'] }}" @endif placeholder="Entrer le code pin de la Boutique"name="shop_pincode" >
                    </div>
                    
                    <div class="form-group">
                      <label for="shop_mobile"> Mobile/telephone de la Boutique </label>
                      <input type="text" class="form-control" id="shop_mobile" @if(isset($vendorDetails['shop_mobile'])) value="{{ $vendorDetails['shop_mobile'] }}" @endif placeholder="Entrer le numero de telephone de la Boutique" name="shop_mobile"  maxlength="10" minlength="8" >
                    </div>

                    <div class="form-group">
                      <label for="business_license_number">Numero de la Licence de commerce </label>
                      <input type="text" class="form-control" id="business_license_number" @if(isset($vendorDetails['business_license_number'])) value="{{ $vendorDetails['business_license_number'] }}" @endif placeholder="Entrer le numero de la licence de commerce"name="business_license_number" >
                    </div>

                    <div class="form-group">
                      <label for="gst_number">Numero GST </label>
                      <input type="text" class="form-control" id="gst_number" @if(isset($vendorDetails['gst_number'])) value="{{ $vendorDetails['gst_number'] }}" @endif placeholder="Entrer le numero GST"name="gst_number" >
                    </div>

                    <div class="form-group">
                      <label for="pan_number">Numero PAN </label>
                      <input type="text" class="form-control" id="pan_number" @if(isset($vendorDetails['pan_number'])) value="{{ $vendorDetails['pan_number'] }}" @endif placeholder="Entrer le numero PAN"name="pan_number" >
                    </div>

                    <div class="form-group">
                      <label for="address_proof"> confirmation (preuve) de l'adresse </label>
                      <select class="form-control" name="address_proof" id="address_proof" >
                        <option value="Passport" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Passport") selected @endif>Passeport</option>
                        <option value="Voting Card" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Voting Card") selected @endif>Carte d'électeur / carte NINA</option>
                        <option value="PAN" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="PAN") selected @endif>PAN</option>
                        <option value="Driving License" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Driving License") selected @endif>Permis de Conduire</option>
                        <option value="Aadhar Card" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Aadhar Card") selected @endif>Aadhar Card</option>
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label for="address_proof_image">confirmation (preuve) en image de l'adresse </label>
                      <input type="file" class="form-control" id="address_proof_image" name="address_proof_image" >
                      @if(!empty($vendorDetails['address_proof_image']))
                        <a target="_blank" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}"> voir la photo </a>
                        <input type="hidden" name="current_address_proof" value="{{ $vendorDetails['address_proof_image'] }}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            
            </div>
          </div>
        </div>
        @elseif($slug=="bank")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Mettre à Jour les informations bancaires du vendeur</h4>
                  @if(Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Erreur: </strong>{{ Session::get('error_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif

                     @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong>{{ Session::get('success_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                     @if($errors->any())
                                    
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                     
                                    @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="post" name="updateAdminPasswordForm" id="updateAdminPasswordForm" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Nom d'utilisateur vendeur / adresse-Email</label>
                      <input  class="form-control"  value="{{ Auth::guard('admin')->user()->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="account_holder_name">Nom du Propriétaire du Compte </label>
                      <input type="text" class="form-control" id="account_holder_name" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['account_holder_name'] }}" @endif placeholder="Entrer le Nom du titulaire du Compte"name="account_holder_name" >
                      
                    </div>

                    <div class="form-group">
                      <label for="bank_name">Nom de la Banque </label>
                      <input type="text" class="form-control" id="bank_name" @if(isset($vendorDetails['bank_name'])) value="{{ $vendorDetails['bank_name'] }}" @endif placeholder="Entrer le nom de votre banque"name="bank_name" >
                    </div>
                    
                    <div class="form-group">
                      <label for="account_number">Numero du Compte Bancaire </label>
                      <input type="text" class="form-control" id="account_number" @if(isset($vendorDetails['account_number'])) value="{{ $vendorDetails['account_number'] }}" @endif placeholder="Entrer le numero du compte"name="account_number" >
                    </div>
                    <div class="form-group">
                      <label for="bank_ifsc_code">code IFSC bancaire </label>
                      <input type="text" class="form-control" id="bank_ifsc_code" @if(isset($vendorDetails['bank_ifsc_code'])) value="{{ $vendorDetails['bank_ifsc_code'] }}" @endif placeholder="Entrer la ville de la Boutique"name="bank_ifsc_code" >
                      
                    </div>
                  
                    
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            
            </div>
          </div>
        </div>
        
        @elseif($slug=="orangemoney")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Mettre à Jour les informations Orange Money du vendeur</h4>
                  @if(Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Erreur: </strong>{{ Session::get('error_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif

                     @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success: </strong>{{ Session::get('success_message')}} 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                     @if($errors->any())
                                    
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                     
                                    @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                @endif
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/orangemoney') }}" method="post" name="updateAdminPasswordForm" id="updateAdminPasswordForm" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Nom d'utilisateur vendeur / adresse-Email</label>
                      <input  class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="account_holder_name">Nom du Propriétaire du Compte </label>
                      <input type="text" class="form-control" id="account_holder_name" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['account_holder_name'] }}" @endif placeholder="Entrer le Nom du titulaire du Compte"name="account_holder_name" >
                      
                    </div>

                    
                    <div class="form-group">
                      <label for="account_number">Numero du Compte Orange Money </label>
                      <input type="text" class="form-control" id="account_number" @if(isset($vendorDetails['account_number'])) value="{{ $vendorDetails['account_number'] }}" @endif placeholder="Entrer le numero du compte"name="account_number" >
                    </div>
                    
                   
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            
            </div>
          </div>
        </div>
        @endif
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection