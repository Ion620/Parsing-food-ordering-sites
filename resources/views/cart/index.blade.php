<x-app-layout>
    <x-slot name="header">
        Cart
    </x-slot>

    <div class="max-w-7xl mt-8 text-2xl p-8">
        <x-splade-table :for="$cart">
            @cell('customer', $cart)
            {{$cart->customer->name}}
            @endcell
            @cell('establishment', $cart)
            {{isset($cart->establishment->name) ?: ''}}
            @endcell
            @cell('good', $cart)
            {{$cart->good->name}}
            @endcell
            @cell('price', $cart)
            {{$cart->price()}}
            @endcell
            @cell('delete', $cart)
            <div class="cart">
                <x-splade-form action="{{ route('cart.minus', ['id' => $cart->good_id])}}">
                    <button type="submit" class="btn" {!! $cart->quantity <= 0 ? "disabled" : "" !!}>-</button>
                </x-splade-form>
                <input type="text" readonly name="quantity" class="quantity" value="{{$cart->quantity ?: 0}}">
                <x-splade-form action="{{ route('cart.plus', ['id' => $cart->good_id]) }}">
                    <button type="submit" class="btn">+</button>
                </x-splade-form>
                <x-splade-form action="{{ route('cart.delete', ['id' => $cart->good_id]) }}">
                    <button type="submit" class="btn_cart cart_delete">Delete</button>
                </x-splade-form>
            </div>
            @endcell
        </x-splade-table>
        <div>
            <h2>Total sum {{$total_sum}}</h2>
        </div>
        <x-splade-form action="{{ route('cart.addToOrder') }}" method="post">
            <x-splade-submit label="Add to order" />
        </x-splade-form>
    </div>
</x-app-layout>
