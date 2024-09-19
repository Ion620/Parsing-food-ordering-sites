<x-app-layout>
    <x-slot name="header">
        <Link href="{{route('goods.create')}}" class="bg-orange-400 px-3 py-4 rounded-md">Create goods</Link>
    </x-slot>

    <div class="max-w-7xl mt-8 text-2xl p-8">
        <x-splade-form :default="$goods" :action="route('goods.update', $goods->id)" class="max-w-md">
            <x-splade-input name="name" label="Goods"/>
            <x-splade-textarea name="description" label="Description" autosize />
            <x-splade-input name="price" label="Price"/>
            <x-splade-select name="status" label="Status">
                <option value="Доступно">Доступно</option>
                <option value="Недоступно">Недоступно</option>
            </x-splade-select>
            <x-splade-input name="category" label="Category"/>
            <x-splade-file  name="image" Label="Image" class="mt-3"/>
            <x-splade-input name="data" label="Data"/>
            <x-splade-submit class="mt-5"/>
        </x-splade-form>
    </div>
</x-app-layout>
