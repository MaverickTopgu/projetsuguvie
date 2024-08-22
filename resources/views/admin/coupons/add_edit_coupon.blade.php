@extends('admin.layout.layout')
@section('content')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Ajouter Un Nouveau Coupon </h3>
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
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>
                  @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Erreur: </strong>{{ Session::get('error_message')}} 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif

                  @if(Session::has('success_message'))
                    <div style="max-width: 80%;" class="alert alert-success alert-dismissible fade show" role="alert">
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

                  <form class="forms-sample" @if(empty($coupon['id'])) action="{{ url('admin/add-edit-coupon') }}"
                  @else action="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}"  @endif method="post" enctype="multipart/form-data">@csrf
                  @if(empty($coupon['coupon_code']))
                  <div class="form-group">
                      <label for="coupon_option">Option (choix) de Coupon </label><br>
                      <span><input id="AutomaticCoupon" type="radio" name="coupon_option" value="Automatic" checked >&nbsp;Automatique&nbsp;&nbsp;</span>
                      <span><input id="ManualCoupon" type="radio" name="coupon_option" value="Manual" >&nbsp;Manuel&nbsp;&nbsp;</span>
                  </div>
                  <div class="form-group" style="display: none;" id="couponField">
                    <label for="coupon_code">Code du Coupon </label>
                    <input type="text" class="form-control" id="coupon_code" placeholder="Entrer le Code du Coupon "name="coupon_code" >
                  </div>
                  @else
                    <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                    <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                    <div class="form-group">
                      <label for="coupon_code">Le Code du Coupon: </label>
                      <span><strong>{{ $coupon['coupon_code'] }}</strong></span>
                    </div>
                  @endif
                  <div class="form-group">
                      <label for="coupon_type">Type de Coupon </label><br>
                      <span><input type="radio" name="coupon_type" value="Plusieurs Fois" @if(isset($coupon['coupon_type']) && $coupon['coupon_type']=="Plusieurs Fois") checked="" @endif>&nbsp;Plusieurs Fois&nbsp;&nbsp;</span>
                      <span><input type="radio" name="coupon_type" value="Une Seule Fois" @if(isset($coupon['coupon_type']) && $coupon['coupon_type']=="Une Seule Fois") checked="" @endif >&nbsp;Une Seule Fois&nbsp;&nbsp;</span>
                  </div>
                  <div class="form-group">
                      <label for="amount_type">Type de Montant </label><br>
                      <span><input type="radio" name="amount_type" value="Percentage" @if(isset($coupon['amount_type']) && $coupon['amount_type']=="Percentage") checked @endif >&nbsp;En Pourcentage --(%)&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;
                      <span><input type="radio" name="amount_type" value="Fixed" @if(isset($coupon['amount_type']) && $coupon['amount_type']=="Fixed") checked @endif >&nbsp;Fixé&nbsp;&nbsp; --En Franc(s) CFA</span>
                  </div>
                  <div class="form-group">
                      <label for="amount">Montant du Coupon </label>
                      <input type="text" class="form-control" id="amount" placeholder="Entrer le montant du Coupon "name="amount" @if(isset($coupon['amount'])) value="{{ $coupon['amount'] }}" @else value="{{ old('amount') }}" @endif >
                    </div>
                  <div class="form-group">
                      <label for="categories">Selectionner la Categorie </label>
                      <select class="form-control text-dark" name="categories[]" Multiple> 
                        @foreach($categories as $section)
                            <optgroup label="{{ $section['name'] }}"></optgroup>
                            @foreach($section['categories'] as $category)
                                <option value="{{ $category['id'] }}" @if(in_array($category['id'],$selCats)) selected @endif >&nbsp;&nbsp;&nbsp;
                                    -- &nbsp;{{ $category['category_name'] }}</option>
                                    @foreach($category['subcategories'] as $subcategory)
                                <option value="{{ $subcategory['id'] }}" @if(in_array($subcategory['id'],$selCats)) selected @endif>&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;-- &nbsp;{{ $subcategory['category_name'] }}</option>
                                    @endforeach
                            @endforeach
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="brands">Selectionner la Marque </label>
                      <select class="form-control text-dark" name="brands[]" Multiple> 
                        @foreach($brands as $brand)
                            <option value="{{ $brand['id'] }}" @if(in_array($brand['id'],$selBrands)) selected @endif>{{ $brand['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="users">Selectionner les Utilisateurs </label>
                      <select class="form-control text-dark" name="users[]" Multiple> 
                        @foreach($users as $user)
                            <option value="{{ $user['email'] }}" @if(in_array($user['email'],$selUsers)) selected @endif>{{ $user['email'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="expiry_date">Date d'expiration du Coupon </label>
                      <input type="date" class="form-control" id="expiry_date" placeholder="Entrer la date d'expiration du Coupon "name="expiry_date"
                       @if(isset($coupon['expiry_date'])) value="{{ $coupon['expiry_date'] }}" @else value="{{ old('expiry_date') }}" @endif >
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2">Soumettre</button>
                    <button type="reset" class="btn btn-light">Annuler</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection