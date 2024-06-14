

<x-app>
    <product-cart
    :cart-items='@json($cartItems)'
    :total-quantity='{{ $totalQuantity }}'
    :total-price='{{ $totalPrice }}'>

</product-cart>


</x-app>
