@extends('layouts.main')
@section('content')
    <form action="{{route("warehouse.store")}}" method="POST" class="bg-indigo-500 p-2 rounded m-auto flex flex-col">
        @csrf
        <input type="text" name="name" placeholder="Add warehouse name" required>
        <input type="text" name="city" placeholder="Enter city" required>
        <input type="text" name="zip_code" placeholder="Enter zip-code" required>
        <input type="text" name="country" placeholder="Enter country" required>
        <input type="text" name="street" placeholder="Enter street" required>
        <input type="text" name="house_number" placeholder="Enter house-number" required>

        <button class="p-2 bg-emerald-500 text-white rounded">Save</button>
        
        @if(session()->has('success_add')) 
            <p class="p-2 text-emerald-500">{{session('success_add')}}</p>
        @endif
    </form>  


    <!-- Table -->
    <div class="mx-auto w-full max-w-2xl rounded-sm border border-gray-200 bg-white shadow-lg">
        <header class="border-b border-gray-100 px-5 py-4">
            <div class="font-semibold text-gray-800">Warehouses</div>
            @if(session()->has('success_delete')) 
            <p class="p-2 text-emerald-500">{{session('success_delete')}}</p>
            @endif
        </header>

        <div class="overflow-x-auto p-3">
            <table class="w-full table-auto">
                <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-400">
                    <tr>
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
                            <input type="checkbox" class="h-5 w-5" value="id-1" @click="toggleCheckbox($el, 2890.66)"/>
                        </td>
                        <td class="p-2">
                            <div class="font-medium text-gray-800">{{$warehouse->name}}</div>
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
                                    <svg class="h-8 w-8 rounded-full p-1 hover:bg-gray-100 hover:text-blue-600"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Single form for deleting warehouses -->
    <form id="deleteForm" action="{{ route('warehouse.delete') }}" method="POST" hidden>
    @csrf
    <input type="text" name="warehouse_id" id="warehouse_id">
    </form>

    <script type="text/javascript">
        function deleteWarehouse(id) {
            let warehouseId = document.getElementById('warehouse_id');
            warehouseId.setAttribute('value', id);
            document.getElementById("deleteForm").submit();
        }
    </script>

    
@stop