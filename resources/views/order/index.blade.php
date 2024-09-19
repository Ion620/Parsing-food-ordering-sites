<x-app-layout>
    <x-slot name="header">
        Orders
    </x-slot>

    <div class="max-w-7xl mt-8 text-2xl p-8">
        <x-splade-table :for="$orders">
            @cell('created_at', $order)
               {{ $order->created_at->format('j F Y') }}
            @endcell
            @cell('total_Price', $order)
                {{$order->totalPrice()}}
            @endcell
            @cell('review', $order)
                <x-splade-form>
                    <x-splade-submit label="Review" />
                </x-splade-form>
            @endcell
            @cell('change_status', $order)
            <x-splade-form action="{{route('order.change', ['order' => $order])}}">
                @if($order->status == \App\Models\Enums\OrderStatus::OPEN->value)
                    <x-splade-submit label="In process"/>
                @elseif ($order->status == \App\Models\Enums\OrderStatus::IN_PROCESS->value)
                    <x-splade-submit label="Completed"/>
                @else
                    <x-splade-submit label="Completed" disabled/>
                @endif
            </x-splade-form>
            @endcell
        </x-splade-table>
    </div>
</x-app-layout>
