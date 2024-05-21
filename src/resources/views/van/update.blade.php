@extends('layouts.main')

@section('content')

    <section class="flex flex-col justify-start gap-4 p-2 max-w-5xl m-auto">

        {{-- EDIT FORM--}}
        <div class="mr-auto bg-white p-4 w-fit rounded">
            <form action="{{route("van.update.action")}}" class="flex flex-col gap-2 mb-4" method="POST">
                <h1 class="text-2xl text-left">Edit van</h1>
                @csrf
                <input type="text" name="van_id" value="{{$van->id}}" hidden>
                <label for="name" class="default-label">License plate</label>
                <input class="default-input" type="text" name="license_plate" value="{{$van->licenceplate}}"
                       placeholder="License plate" required>
                <button class="default-button w-fit !px-4">Update</button>

                @if(session()->has('success'))
                    <p class="p-2 text-emerald-500">{{ session('success') }}</p>
                @endif

                @foreach ($errors->all() as $error)
                    <p class="p-2 text-rose-500">{{ $error }}</p>
                @endforeach
            </form>
        </div>

        <!-- Table -->
        <div class="mx-auto w-full rounded-sm border border-gray-200 bg-white shadow-lg">
            <header class="border-b border-gray-100 px-5 py-4 flex flex-col">
                <div class="flex w-full justify-between items-center">
                    <div class="font-semibold text-gray-800">Products in van</div>
                    <button id="relate-products-btn"
                            class="default-button !m-0 !bg-emerald-500 hover:!bg-emerald-600 flex gap-2 items-center">
                        Allocate products to van
                        <x-heroicon-o-plus class="w-5"/>
                    </button>

                </div>

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
                    @foreach($relatedProducts as $relatedProduct)
                        @if(isset($relatedProduct->serial_numbers))
                            @foreach($relatedProduct->serial_numbers as $serialNumber)
                                <tr>
                                    <td class="p-2">
                                        <input type="checkbox" class="h-5 w-5" value="id-1"
                                               @click="toggleCheckbox($el, 2890.66)"/>
                                    </td>
                                    <td class="p-2">
                                        <a href="{{route('view.serial-number', ['product_id' => $relatedProduct->_id, 'serial_number' => $serialNumber['serial_number']])}}">
                                            <div
                                                class="font-medium text-gray-800 hover:text-[#88327D] ease-in-out duration-200">{{$serialNumber['serial_number']}}</div>
                                        </a>
                                    </td>
                                    <td class="p-2">
                                        <div class="font-medium text-gray-800">{{$relatedProduct->name}}</div>
                                    </td>
                                    <td class="p-2">
                                        <div
                                            class="font-medium text-gray-800">{{$relatedProduct->getWarehouseName($serialNumber['warehouse_id'])}}</div>
                                    </td>
                                    <td class="p-2">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{route('view.serial-number', ['product_id' => $relatedProduct->_id, 'serial_number' => $serialNumber['serial_number']])}}">
                                                <x-heroicon-o-pencil-square class="w-6 h-6 text-gray-500 hover:text-indigo-500 duration-200 ease-in-out"/>
                                            </a>
                                            <!-- Delete button with data-id attribute -->
                                            <button class="delete-button" onclick="showPopup('{{$relatedProduct->_id}}', '{{$serialNumber['serial_number']}}')">
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
    </section>

    <x-popup.form key="relate-products">
        <x-slot:heading>
            Allocate products to van
        </x-slot:heading>

        <x-slot:form>
            <form id="add-products-to-van-form" action="{{route('van.allocate.products', ['van' => $van->_id])}}" method="POST">
                @csrf
            </form>


            {{--TABLE--}}
            <div class="overflow-x-auto max-h-[300px] w-full">
                <table class="w-full table-auto">
                        <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-400 sticky top-0">
                    <tr class="text-[#88327D]">
                        <th></th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Serial-number</div>
                        </th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Product</div>
                        </th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Warehouse</div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm">
                    <!-- record 1 -->
                    @foreach($products as $product)
                        @foreach($product->serial_numbers as $serialNumber)
                        <tr>
                            <td class="p-2">
                                <input
                                    data-id ="#s-{{$product->_id}}-{{$serialNumber['serial_number']}}"
                                    form="add-products-to-van-form"
                                    type="checkbox"
                                    class="selection h-5 w-5"
                                    name="selection[product_id][]"
                                    value="{{$product->_id}}"
                                />
                                <input
                                    id="s-{{$product->_id}}-{{$serialNumber['serial_number']}}"
                                    form="add-products-to-van-form"
                                    type="checkbox"
                                    class="h-5 w-5 hidden"
                                    name="selection[serial_number][]"
                                    value="{{$serialNumber['serial_number']}}"
                                />
                            </td>
                            <td class="p-2">
                                <div class="font-medium text-gray-800">
                                    {{$serialNumber['serial_number']}}
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="font-medium text-gray-800">
                                    {{$product->name}}
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="font-medium text-gray-800">
                                    {{$product->getWarehouseName($serialNumber['warehouse_id'])}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
            <button form="add-products-to-van-form" class="default-button w-fit">Save</button>
        </x-slot:form>
    </x-popup.form>

    <script>
        $('#relate-products-btn').click(function () {
            $('.popup-relate-products').show();
        });

        $('.selection').click(function(){
            const id = $(this).data('id');
            const isChecked = $(this).is(":checked");
            $(id).prop( "checked", isChecked );
        })
    </script>
@stop
