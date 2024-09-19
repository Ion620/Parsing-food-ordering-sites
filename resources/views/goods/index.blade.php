<x-app-layout>
    <x-slot name="header">
        <Link href="{{route('goods.create')}}" class="bg-orange-400 px-3 py-4 rounded-md">Create goods</Link>
    </x-slot>

    <div class="max-w-7xl mt-8 text-2xl p-8">
        <x-splade-table :for="$goods">
            @cell('image', $good)
            <img src="{{$good->image}}" alt="">
            @endcell
            @cell('delete', $good)
            <Link href="{{route('goods.destroy', $good->id)}}"
                  class="text-red-400"
                  confirm="Delete goods"
                  confirm-text="Are you sure?"
                  confirm-button="Yes"
                  cancel-button="Cancel"
                  method="DELETE">
                Delete
            </Link>
            @endcell
            @cell('update', $good)
            <Link href="{{route('goods.edit', $good->id)}}" class="text-blue-400">Update</Link>
            @endcell
            @cell('cart', $good)
            @php
                $quantity = $good->cart()->value('quantity');
            @endphp
            <div class="cart">
                <x-splade-form action="{{ route('goods.minus', ['id' => $good->id])}}">
                    <button type="submit" class="btn" {!! $quantity <= 0 ? "disabled" : "" !!}>-</button>
                </x-splade-form>
                <input type="text" readonly name="quantity" class="quantity" value="{{$quantity ?: 0}}">
                <x-splade-form action="{{ route('goods.plus', ['id' => $good->id]) }}">
                    <button type="submit" class="btn">+</button>
                </x-splade-form>
                    @if(!isset($quantity))
                    <x-splade-form action="{{route('goods.addToCart', ['id' => $good->id])}}">
                        <x-splade-submit label="Add" class="btn_cart"/>
                    </x-splade-form>
                    @else
                    <x-splade-form action="{{ route('goods.deleteFromCart', ['id' => $good->id]) }}">
                        <button type="submit" class="btn_cart cart_delete">Delete</button>
                    </x-splade-form>
                    @endif
            </div>
            @endcell
        </x-splade-table>
    </div>
</x-app-layout>
