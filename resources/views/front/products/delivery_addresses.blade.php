
@if(count($deliveryAddresses)>0)
    <h4 class="section-h4">Adresses de livraison</h4>
    @foreach($deliveryAddresses as $address)
    <!-- partie modif avec gpt-4 -->
    <div style="display: flex; align-items: center; padding: 15px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 10px;" class="">
        <div class="control-group" style="margin-right: 15px;">
            <input type="radio" id="address{{$address['id']}}" name="address_id" value="{{ $address['id'] }}">
        </div>
        <div style="flex: 1;">
            <label style="font-size:14px;" class="control-label" for="">{{ $address['name'] }} |
                {{ $address['address'] }} | {{ $address['city'] }} | {{ $address['state'] }} |
                {{ $address['country'] }} | ({{  $address['mobile'] }})</label>
        </div>
        <a style="font-size:14px; color: #007bff; text-decoration: none;" href="javascript:;" data-addressid="{{ $address['id'] }}" class="editAddress">Modifier</a>
    </div>
    <!-- partie modif avec gpt-4 -->

    @endforeach <br>
    <!-- Form-Fields /- -->
    <h4 class="section-h4 deliveryText" >Ajouter une nouvelle adresse de livraison</h4>
    <div class="u-s-m-b-24">
        <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent">
        <label class="label-text newAddress" for="ship-to-different-address">Expédier à une autre adresse ?</label>
    </div>
    <div class="collapse" id="showdifferent">
        <!-- Form-Fields -->
        <form id="addressAddEditForm" action="javascript:;" method="post">@csrf
            <input type="hidden" name="delivery_id">
            <div class="group-inline u-s-m-b-13">
                <div class="group-1 u-s-p-r-16">
                    <label for="delivery_name">Nom et Prenom
                        <span class="astk">*</span>
                    </label>
                    <input type="text" name="delivery_name" id="delivery_name" class="text-field">
                </div>
                <div class="group-2">
                    <label for="delivery_address">Adresse
                        <span class="astk">*</span>
                    </label>
                    <input type="text" name="delivery_address" id="delivery_address" class="text-field">
                </div>
            </div>
            <div class="group-inline u-s-m-b-13">
                <div class="group-1 u-s-p-r-16">
                    <label for="delivery_city">Ville
                        <span class="astk">*</span>
                    </label>
                    <input type="text" name="delivery_city" id="delivery_city" class="text-field">
                </div>
                <div class="group-2">
                    <label for="delivery_state">Région
                        <span class="astk">*</span>
                    </label>
                    <input type="text" name="delivery_state" id="delivery_state" class="text-field">
                </div>
            </div>
            <div class="u-s-m-b-13">
                <label for="delivery_country">Pays
                    <span class="astk">*</span>
                </label>
                <div class="select-box-wrapper">
                    <select class="select-box" id="delivery_country" name="delivery_country" >
                        <option value=""> Choisissez votre Pays </option>
                        @foreach($countries as $country)
                        <option value="{{ $country['country_name'] }}" @if($country['country_name']== Auth::user()->country) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="u-s-m-b-13">
                <label for="delivery_pincode">Code Pin
                    <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_pincode" name="delivery_pincode" class="text-field">
            </div>
            <div class="u-s-m-b-13">
                <label for="delivery_mobile">Telephone
                    <span class="astk">*</span>
                </label>
                <input type="text" id="delivery_mobile" name="delivery_mobile" class="text-field">
            </div>
            <div class="u-s-m-b-13">
                <button type="submit" class="button button-outline-secondary" style="width:100%;">Sauvegarder</button>
            </div>
        </form>
        <!-- Form-Fields /- -->
    </div>
    <div>
        <label for="order-notes">Notes de commande</label>
        <textarea class="text-area" id="order-notes" placeholder="Notes concernant votre commande, par ex. notes spéciales pour la livraison."></textarea>
    </div>

@else

    <h4 class="section-h4">Ajouter de nouvelles adresses de livraison</h4>
    <!-- Form-Fields -->
    <div class="group-inline u-s-m-b-13">
        <div class="group-1 u-s-p-r-16">
            <label for="first-name">First Name
                <span class="astk">*</span>
            </label>
            <input type="text" id="first-name" class="text-field">
        </div>
        <div class="group-2">
            <label for="last-name">Last Name
                <span class="astk">*</span>
            </label>
            <input type="text" id="last-name" class="text-field">
        </div>
    </div>
    <div class="u-s-m-b-13">
        <label for="select-country">Country
            <span class="astk">*</span>
        </label>
        <div class="select-box-wrapper">
            <select class="select-box" id="select-country">
                <option selected="selected" value="">Choose your country...</option>
                <option value="">United Kingdom (UK)</option>
                <option value="">United States (US)</option>
                <option value="">United Arab Emirates (UAE)</option>
            </select>
        </div>
    </div>
    <div class="street-address u-s-m-b-13">
        <label for="req-st-address">Street Address
            <span class="astk">*</span>
        </label>
        <input type="text" id="req-st-address" class="text-field" placeholder="House name and street name">
        <label class="sr-only" for="opt-st-address"></label>
        <input type="text" id="opt-st-address" class="text-field" placeholder="Apartment, suite unit etc. (optional)">
    </div>
    <div class="u-s-m-b-13">
        <label for="town-city">Town / City
            <span class="astk">*</span>
        </label>
        <input type="text" id="town-city" class="text-field">
    </div>
    <div class="u-s-m-b-13">
        <label for="select-state">State / Country
            <span class="astk"> *</span>
        </label>
        <div class="select-box-wrapper">
            <select class="select-box" id="select-state">
                <option selected="selected" value="">Choose your state...</option>
                <option value="">Alabama</option>
                <option value="">Alaska</option>
                <option value="">Arizona</option>
            </select>
        </div>
    </div>
    <div class="u-s-m-b-13">
        <label for="postcode">Postcode / Zip
            <span class="astk">*</span>
        </label>
        <input type="text" id="postcode" class="text-field">
    </div>
    <div class="group-inline u-s-m-b-13">
        <div class="group-1 u-s-p-r-16">
            <label for="email">Email address
                <span class="astk">*</span>
            </label>
            <input type="text" id="email" class="text-field">
        </div>
        <div class="group-2">
            <label for="phone">Phone
                <span class="astk">*</span>
            </label>
            <input type="text" id="phone" class="text-field">
        </div>
    </div>
    <!-- <div class="u-s-m-b-30">
        <input type="checkbox" class="check-box" id="create-account">
        <label class="label-text" for="create-account">Create Account</label>
    </div> -->

@endif
    
