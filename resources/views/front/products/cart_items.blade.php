<?php use App\Models\Product; ?>
<!-- Products-List-Wrapper -->
<div class="table-wrapper u-s-m-b-60">
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix d'achat</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Action(s)</th>
            </tr>
        </thead>
        <tbody>
            @php $total_price = 0 @endphp
            @foreach($getCartItems as $item)
            <?php $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['size']);
            ?>
            <tr>
                <td>
                    <div class="cart-anchor-image">
                        <a href="{{ url('product/'.$item['product_id'])}}">
                            <img src="{{ asset('front/images/product_images/small/'.$item['product']['product_image']) }}" alt="article">
                            <h6><strong>
                                {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }}) - {{ $item['size'] }}</strong><br>
                                Couleur: <strong>{{ $item['product']['product_color'] }}</strong><br>
                            </h6>

                        </a>
                    </div>
                </td>
                <td>
                    <div class="cart-price">
                    @if($getDiscountAttributePrice['discount']>0)
                        <div class="price-template">
                            <div class="item-new-price">
                                {{$getDiscountAttributePrice['final_price']}}  F-CFA
                            </div>
                            <div class="item-old-price" style="margin-left:-40px;">
                                {{$getDiscountAttributePrice['product_price']}}  F-CFA
                            </div>
                        </div>
                        @else
                        <div class="price-template">
                            <div class="item-new-price">
                            {{ $getDiscountAttributePrice['final_price'] }}  F-CFA
                            </div>
                        </div>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="cart-quantity">
                        <div class="quantity">
                            <input type="text" class="quantity-text-field" value="{{ $item['quantity']}}">
                            <a class="plus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}"
                             data-max="1000">&#43;</a>
                            <a class="minus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}"
                             data-min="1">&#45;</a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cart-price">
                    {{ $getDiscountAttributePrice['final_price']*$item['quantity'] }}  F-CFA
                    </div>
                </td>
                <td>
                    <div class="action-wrapper">
                        <!-- <button class="button button-outline-secondary fas fa-sync"></button> -->
                        <button class="button button-outline-secondary fas fa-trash deleteCartitem" data-cartId="{{ $item['id'] }}"></button>
                    </div>
                </td>
            </tr>
            @php $total_price = $total_price + ($getDiscountAttributePrice['final_price']*$item['quantity'])  @endphp
            @endforeach
        </tbody>
    </table>
</div>
<!-- Products-List-Wrapper /- -->

<!-- Billing -->
<div class="calculation u-s-m-b-60">
    <div class="table-wrapper-2">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Totaux du panier</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Sous-Total</h3>
                    </td>
                    <td>
                        <span class="calc-text">{{$total_price}}  F-CFA</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Coupon de réduction</h3>
                    </td>
                    <td>
                        <span class="calc-text couponAmount" >@if(Session::has('couponAmount')) {{ Session::get('couponAmount') }} F-CFA
                                                              @else 0 F-CFA
                                                              @endif</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Grand Total</h3>
                    </td>
                    <td>
                        <span class="calc-text grand_total">{{$total_price - Session::get('couponAmount')}}  F-CFA</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Billing /- -->
