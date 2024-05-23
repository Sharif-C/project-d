@extends('layouts.main')
@section('content')

    <x-popup.form key="delete">
        <x-slot:heading>
            Are you certain you want to delete this serial number?
        </x-slot:heading>

        <x-slot:form>
            <form action="{{route('product.delete-serial-number')}}" METHOD="POST" enctype="multipart/form-data">
                @csrf
                <input id="delete-serial-number" name="serial_number" type="text" required readonly hidden>
                <input id="delete-product-id" name="product_id" type="text" required readonly hidden/>
                <button class="cancel-btn">Delete</button>
            </form>
        </x-slot:form>
    </x-popup.form>

    <div class="m-auto bg-white p-4 w-fit rounded min-w-[80%]">
        <h1 class="text-2xl mb-2 text-center">Manage serial number</h1>

        <form action="{{route('product.store-serial-number')}}" method="POST" class="flex flex-col gap-2 mb-4">
            @csrf
            <div class="flex flex-col">
                <label for="product_id" class="default-label">Product</label>
                <select name="product_id" class="default-input">
                    @foreach($products as $w)
                        <option value="{{$w->_id}}">{{$w->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label for="serial_number" class="default-label">Serial number</label>
                <input type="text" name="serial_number" id="" placeholder="Serial number" class="default-input" required>
            </div>

            <div class="flex flex-col">
                <label for="warehouse_id" class="default-label">Warehouse</label>
                <select name="warehouse_id" class="default-input">
                    @foreach($warehouses as $w)
                        <option value="{{$w->_id}}">{{$w->name}}</option>
                    @endforeach
                </select>
            </div>
            <button class="default-button w-fit">Save</button>
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
                <div class="font-semibold text-emerald-800">Product serial numbers</div>

                @if(session()->has('success_delete'))
                    <p class="p-2 text-emerald-500">{{session('success_delete')}}</p>
                @endif
            </header>

            <div class="overflow-x-auto p-3">
                <table class="w-full table-auto w-[940px]">
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
                            <div class="text-left font-semibold">Warehouse</div>
                        </th>
                        <th class="p-2">
                            <div class="text-center font-semibold">Actions</div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm">
                    <!-- record 1 -->
                        @foreach($products as $product)
                            @if(isset($product->serial_numbers))
                                @foreach($product->serial_numbers as $serialNumber)

                                    @if(isset($serialNumber['van_id']))
                                        @continue
                                    @endif

                                    <tr>
                                        <td class="p-2">
                                            <input type="checkbox" class="h-5 w-5" value="id-1" @click="toggleCheckbox($el, 2890.66)"/>
                                        </td>
                                        <td class="p-2">
                                            <a href="{{route('view.serial-number', ['product_id' => $product->_id, 'serial_number' => $serialNumber['serial_number']])}}">
                                                <div class="font-medium text-gray-800 hover:text-[#88327D] ease-in-out duration-200">{{$serialNumber['serial_number']}}</div>
                                            </a>
                                        </td>
                                        <td class="p-2">
                                            <div class="font-medium text-gray-800">{{$product->name}}</div>
                                        </td>
                                        <td class="p-2">
                                            <div class="font-medium text-gray-800">{{$product->getWarehouseName($serialNumber['warehouse_id'])}}</div>
                                        </td>
                                        <td class="p-2">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{route('view.serial-number', ['product_id' => $product->_id, 'serial_number' => $serialNumber['serial_number']])}}">
                                                    <x-heroicon-o-pencil-square class="w-6 h-6 text-gray-500 hover:text-indigo-500 duration-200 ease-in-out"/>
                                                </a>
                                                <!-- Delete button with data-id attribute -->
                                                <button class="delete-button" onclick="showPopup('{{$product->_id}}', '{{$serialNumber['serial_number']}}')">
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

    <script type="text/javascript">
        function showPopup(productId, serialNumber) {
            $('#delete-serial-number').val(serialNumber);
            $('#delete-product-id').val(productId);
            $('.popup-delete').show();
        }
    </script>

@stop
