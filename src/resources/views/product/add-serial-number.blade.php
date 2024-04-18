@extends('layouts.main')
@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded">
        <h1 class="text-2xl mb-2 text-center">Add serial number</h1>

        <form action="{{route('product.store-serial-number')}}" method="POST" class="flex flex-col gap-2">
            @csrf
            <div class="flex flex-col">
                <label for="product_id">Product</label>
                <select name="product_id" id="">
                    @foreach($products as $w)
                        <option value="{{$w->_id}}">{{$w->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label for="serial_number">Serial number</label>
                <input type="text" name="serial_number" id="" placeholder="Serial number">
            </div>

            <div class="flex flex-col">
                <label for="warehouse_id">Warehouse</label>
                <select name="warehouse_id" id="">
                    @foreach($warehouses as $w)
                        <option value="{{$w->_id}}">{{$w->name}}</option>
                    @endforeach
                </select>
            </div>
            <button class="rounded bg-emerald-400 text-white py-2 px-3">Save</button>
        </form>

        @if(session()->has('success'))
            <p class="mt-2 text-emerald-400">{{session('success')}}</p>
        @endif

        @if($errors->any())
            @foreach($errors->all() as $e) @endforeach
            <p class="mt-2 text-rose-400">{{$e}}</p>
        @endif

        <!-- Table -->
        <div class="mx-auto w-full rounded-sm border border-gray-200 bg-white shadow-lg">
            <header class="border-b border-gray-100 px-5 py-4">
                <div class="font-semibold text-gray-800">Product serial numbers</div>

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
                            <div class="text-left font-semibold">Serial number</div>
                        </th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Product</div>
                        </th>
                        <th class="p-2">
                            <div class="text-center font-semibold">Delete</div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm">
                    <!-- record 1 -->
                    @foreach($products as $product)
                        @if(isset($product->serial_numbers))
                            @foreach($product->serial_numbers as $serialNumber)
                                <tr>
                                    <td class="p-2">
                                        <input type="checkbox" class="h-5 w-5" value="id-1" @click="toggleCheckbox($el, 2890.66)"/>
                                    </td>
                                    <td class="p-2">
                                        <div class="font-medium text-gray-800">{{$serialNumber['serial_number']}}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="font-medium text-gray-800">{{$product->name}}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="flex justify-center">
                                            <!-- Delete button with data-id attribute -->
                                            <button class="delete-button">
                                                <x-heroicon-o-trash class="w-6 h-6 text-gray-500 hover:text-rose-500 duration-200 ease-in-out"/>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Single form for deleting warehouses -->
{{--    <form id="deleteForm" method="POST">--}}
{{--        @csrf--}}
{{--        <input type="text" name="serial_number" id="serial_number" placeholder="Fill a serial number to delete ">--}}
{{--    </form>--}}

    <script type="text/javascript">
        function deleteSerialNumber(id) {
            // $("#warehouse_id").val(id);
        }
    </script>

@stop
