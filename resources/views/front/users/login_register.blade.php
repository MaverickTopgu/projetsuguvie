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
            <!-- Login -->
            <div class="col-lg-6">
                <div class="login-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Se connecter</h2>
                    <h6 class="account-h6 u-s-m-b-30">Content de vous revoir! Connectez-vous à votre compte.</h6>
                    <p id="login-error"></p>
                    <form id="loginForm" action="javascript:;" method="post">@csrf
                        <div class="u-s-m-b-30">
                            <label for="user-email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="email" id="users-email" class="text-field" placeholder="votre adresse Email">
                            <p id="login-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-password">Mot de Passe
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="password" id="users-password" class="text-field" placeholder="votre mot de Passe">
                            <p id="login-password"></p>
                        </div>
                        <div class="group-inline u-s-m-b-30">
                           <!--  <div class="group-1">
                                <input type="checkbox" class="check-box" id="remember-me-token">
                                <label class="label-text" for="remember-me-token">Se Souvenir de moi.</label>
                            </div> -->
                            <div class="group-2 text-right">
                                <div class="page-anchor">
                                    <a href="{{ url('user/forgot-password') }}">
                                        <i class="fas fa-circle-o-notch u-s-m-r-9"></i>Mot de passe oublié ?</a>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-45">
                            <button class="button button-outline-secondary w-100">Se Connecter</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Login /- -->
            <!-- Register -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">S'inscrire</h2>
                    <h6 class="account-h6 u-s-m-b-30">L'inscription sur ce site vous permet d'accéder au statut et à l'historique de vos commandes.</h6>
                    <p id="register-success"></p>
                    <form id="registerForm" action="javascript:;" method="post">@csrf
                        <div class="u-s-m-b-30">
                            <label for="username">Nom
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="user-name" name="name" class="text-field" placeholder="Le nom de l'utilisateur">
                            <p id="register-name"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="usermobile">Telephone
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="user-mobile" name="mobile" class="text-field" placeholder="Le numero de telephone de l'utilisateur">
                            <p id="register-mobile"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="useremail">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" id="user-email" name="email" class="text-field" placeholder="l'adresse Email de l'utilisateur">
                            <p id="register-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="userpassword">Mot de Passe
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="user-password" name="password" class="text-field" placeholder="mot de passe">
                            <p id="register-password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <input type="checkbox" class="check-box" id="accept" name="accept">
                            <label class="label-text no-color" for="accept">J'ai lu et j'accepte les
                                <a href="terms-and-conditions.html" class="u-c-brand">termes & conditions</a>
                            </label>
                            <p id="register-accept"></p>
                        </div>
                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Register /- -->
        </div>
    </div>
</div>
<!-- Account-Page /- -->
@endsection