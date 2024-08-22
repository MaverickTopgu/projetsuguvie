@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Compte Client</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="index.html">Accueil</a>
                </li>
                <li class="is-marked">
                    <a href="account.html">Compte Client</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Account-Page -->
<div class="page-account u-s-p-t-80">
    <div class="container">
        @if(Session::has('error_message'))
                <div style="max-width:80%;" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong>{{ Session::get('error_message')}} 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        @endif
        @if(Session::has('success_message'))
                <div style="max-width:80%;" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>success: </strong>{{ Session::get('success_message')}} 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        @endif
        @if($errors->any())
                <div style="max-width:80%;" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong><?php echo implode('', $errors->all('<div>:message</div>')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        @endif
        <div class="row">
            <!-- Update Account -->
            <div class="col-lg-6">
                <div class="login-wrapper">
                    <h2 class="account-h2 u-s-m-b-20" style="font-size:20px; font-weight:600;">Mettre à jour les informations du compte</h2>
                    <p id="account-error"></p>
                    <p id="account-success"></p>
                    <form id="accountForm" action="javascript:;" method="post">@csrf
                        <div class="u-s-m-b-30">
                            <label for="user-email">Email
                                <span class="astk">*</span>
                            </label>
                            <input  class="text-field" value="{{ Auth::user()->email }}" readonly="true" 
                            disabled="true" style="background-color:#e9e9e9;">
                            <p id="account-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-name">Name
                                <span class="astk">*</span>
                            </label>
                            <input  class="text-field" type="text" id="user-name" name="name" value="{{ Auth::user()->name }}">
                            <p id="account-name"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-address">Adresse
                                <span class="astk">*</span>
                            </label>
                            <input  class="text-field" type="text" id="user-address" name="address" value="{{ Auth::user()->address }}">
                            <p id="account-address"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-city">Ville
                                <span class="astk">*</span>
                            </label>
                            <input  class="text-field" type="text" id="user-city" name="city" value="{{ Auth::user()->city }}">
                            <p id="account-city"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-state">Region
                                <span class="astk">*</span>
                            </label>
                            <input  class="text-field" type="text" id="user-state" name="state" value="{{ Auth::user()->state }}">
                            <p id="account-state"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-country">Pays
                                <span class="astk">*</span>
                            </label>
                            <select class="text-field" id="user-country" name="country" style="color:#495057;">
                                <option value=""> Choisissez votre Pays </option>
                                @foreach($countries as $country)
                                <option value="{{ $country['country_name'] }}" @if($country['country_name']== Auth::user()->country) selected @endif>{{ $country['country_name'] }}</option>
                                @endforeach
                            </select>
                            <p id="account-country"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-pincode">Code Pin
                                <span class="astk">*</span>
                            </label>
                            <input  class="text-field" type="text" id="user-pincode" name="pincode" value="{{ Auth::user()->pincode }}">
                            <p id="account-pincode"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-mobile">Telephone
                                <span class="astk">*</span>
                            </label>
                            <input  class="text-field" type="text" id="user-mobile" name="mobile" value="{{ Auth::user()->mobile }}">
                            <p id="account-mobile"></p>
                        </div>
                        <div class="m-b-45">
                            <button class="button button-outline-secondary w-100">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Update Account /- -->
            <!-- Update Password -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20" style="font-size:20px;font-weight:600;">Mettre à jour le Mot de passe</h2>
                    <p id="password-success"></p>
                    <p id="password-error"></p>
                    <form id="passwordForm" action="javascript:;" method="post">@csrf
                        <div class="u-s-m-b-30">
                            <label for="current-password">Mot de passe actuel
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="current-password" name="current_password" class="text-field" placeholder="saisissez votre mot de passe actuel">
                            <p id="password-current_password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="usermobile">Nouveau Mot de passe
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="new-password" name="new_password" class="text-field" placeholder="saisissez votre nouveau mot de passe">
                            <p id="password-new_password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="useremail">Confirmez le Mot de Passe
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="confirm-password" name="confirm_password" class="text-field" placeholder="Confirmation de votre nouveau mot de passe">
                            <p id="password-confirm_password"></p>
                        </div>
                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Metrre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Update password /- -->
        </div>
    </div>
</div>
<!-- Account-Page /- -->
@endsection