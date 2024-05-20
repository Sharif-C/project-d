@extends('layouts.main')
@section('content')

    <x-popup-modal/>

    <section class="flex flex-col justify-start gap-4 p-2 max-w-5xl m-auto">

        <form action="{{route("warehouse.store")}}" method="POST" class="bg-white p-6 rounded flex flex-col gap-2 w-fit shadow-lg">
            <h2 class="default-h2">Add warehouse</h2>

            @csrf
            <input type="text" name="name" placeholder="Name" class="default-input" required>
            <div class="flex gap-2">
                <input class="default-input !w-[220px]" type="text" name="street" placeholder="Street" required>
                <input class="default-input !w-[180px]" type="text" name="house_number" placeholder="House nr." required>
            </div>
            <input class="default-input" type="text" name="zip_code" placeholder="Zipcode" required>
            <input class="default-input" type="text" name="city" placeholder="City" required>
            <input class="default-input" type="text" name="country" placeholder="Country" required>


            <button class="default-button w-fit">Save</button>

            @if(session()->has('success_add'))
                <p class="p-2 text-emerald-500">{{session('success_add')}}</p>
            @endif
        </form>


        <!-- Table -->
        <div class="mx-auto w-full rounded-sm border border-gray-200 bg-white shadow-lg">
            <header class="border-b border-gray-100 px-5 py-4">
                <div class="font-semibold text-gray-800">Warehouses</div>
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
                            <div class="text-left font-semibold">Address</div>
                        </th>
                        <th class="p-2">
                            <div class="text-center font-semibold">Delete</div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm">
                    <!-- record 1 -->
                    @foreach($warehouses as $warehouse)
                        <tr>
                            <td class="p-2">
                                <input type="checkbox" class="h-5 w-5" value="id-1"
                                       @click="toggleCheckbox($el, 2890.66)"/>
                            </td>
                            <td class="p-2">
                                <a href="{{ route('warehouse.edit.view', $warehouse->id) }}">
                                    <div class="font-medium text-gray-800 trademark-color-hover">{{$warehouse->name}}</div>
                                </a>
                            </td>
                            <td class="p-2">
                                <div class="font-medium text-gray-800">
                                    {{$warehouse->GetAddress()}}
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="flex justify-center">
                                    <!-- Delete button with data-id attribute -->
                                    <button class="delete-button" onclick="deleteWarehouse('{{$warehouse->id}}')">
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

    <!-- Single form for deleting warehouses -->
    <form id="deleteForm" action="{{ route('warehouse.delete') }}" method="POST" hidden>
        @csrf
        <input type="text" name="warehouse_id" id="warehouse_id">
    </form>

    <script type="text/javascript">
        function deleteWarehouse(id) {
            $(".popup-overlay").toggle();
            $("#warehouse_id").val(id);
        }
    </script>

@stop
