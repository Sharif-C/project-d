@extends('layouts.main')
@section('content')

    <section class="flex flex-col justify-start gap-4 p-2 max-w-5xl m-auto">

        <form action="{{route("product.store")}}" method="POST"
              class="bg-white p-6 rounded flex flex-col gap-2 w-fit shadow-lg">
            <h2 class="font-semibold text-gray-800">Add product</h2>
            @csrf
            <input type="text" name="name" placeholder="Name" class="default-input" required>
            <input class="default-input" type="text" name="description" placeholder="Description">
            <button class="default-button w-fit">Save</button>

            @if(session()->has('success'))
                <p class="p-2 text-emeralds-500">{{session('success')}}</p>
            @endif
        </form>


        <!-- Table -->
        <div class="mx-auto w-full rounded-sm border border-gray-200 bg-white shadow-lg">
            <header class="border-b border-gray-100 px-5 py-4">
                <div class="font-semibold text-gray-800">Products</div>

                @if(session()->has('success_delete'))
                    <p class="p-2 text-emerald-500">{{session('success_delete')}}</p>
                @endif
            </header>

            <div class="overflow-x-auto p-3">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-400">
                    <tr class="text-[#88327D]">
                        <th></th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Name</div>
                        </th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Description</div>
                        </th>
                        <th class="p-2">
                            <div class="text-center font-semibold">Action</div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm">
                    <!-- record 1 -->
                    @foreach($products as $product)
                        <tr>
                            <td class="p-2">
                                <input type="checkbox" class="h-5 w-5" value="id-1"/>
                            </td>
                            <td class="p-2">
                                <a href="{{ route('product.edit', $product->id) }}">
                                    <div class="font-medium text-gray-800 trademark-color-hover">
                                        {{ $product->name }}
                                    </div>
                                </a>
                            </td>
                            <td class="p-2">
                                <div class="font-medium text-gray-800">
                                    {{$product->description}}
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('product.edit', $product->id) }}">
                                        <x-heroicon-o-pencil-square class="w-6 h-6 text-gray-500 hover:text-indigo-500 duration-200 ease-in-out cursor-pointer"/>
                                    </a>
                                    <!-- Delete button with data-id attribute -->
                                    <button class="delete-button" onclick="deleteProduct('{{$product->id}}')">
                                        <x-heroicon-o-trash class="w-6 h-6 text-gray-500 hover:text-rose-500 duration-200 ease-in-out"/>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>

    <!-- Single form for deleting Product -->
    <form id="deleteForm" action="{{ route('product.delete') }}" method="POST" hidden>
       @csrf
        <input type="text" name="product_id" id="product_id">
    </form>

    <script type="text/javascript">
        function deleteProduct(id) {
            let productId = document.getElementById('product_id');
            productId.setAttribute('value', id);
            document.getElementById("deleteForm").submit();
        }
    </script>

@stop
