@extends('layouts.main')
@section('content')

{{--    Form for deletion--}}
    <x-popup.form key="delete">
        <x-slot:heading>
            Are you certain you want to delete this van?
        </x-slot:heading>

        <x-slot:form>
            <form id="deleteForm" action="{{ route('van.delete') }}" method="POST">
                @csrf
                <input type="text" name="van_id" id="van_id" readonly required hidden>
                <button class="cancel-btn">Delete</button>
            </form>
        </x-slot:form>
    </x-popup.form>

    <section class="flex flex-col justify-start gap-4 p-2 max-w-5xl m-auto">

        <form action="{{route("van.store")}}" method="POST" class="bg-white p-6 rounded flex flex-col gap-2 w-fit shadow-lg">
            <h2 class="font-semibold text-gray-800">Add van</h2>

            @csrf
            <input class="rounded" type="text" name="licenceplate" placeholder="Licence plate" required>
            <button class="default-button">Save</button>

            @if(session()->has('success_van'))
                <p class="p-2 text-emerald-500">{{session('success_van')}}</p>
            @endif
        </form>


        <!-- Table -->
        <div class="mx-auto w-full rounded-sm border border-gray-200 bg-white shadow-lg">
            <header class="border-b border-gray-100 px-5 py-4">
                <div class="font-semibold text-gray-800">Vans</div>
                @foreach($errors->all() as $e)
                    <p class="p-2 text-rose-500">{{$e}}</p>
                @endforeach                @if(session()->has('success_delete'))
                    <p class="p-2 text-emerald-500">{{session('success_delete')}}</p>
                @endif
            </header>

            <div class="overflow-x-auto p-3">
                <table class="w-full table-auto">
                    <thead class="bg-gray-50 text-xs font-semibold uppercase text-gray-400">
                    <tr class="text-[#88327D]">
                        <th></th>
                        <th class="p-2">
                            <div class="text-left font-semibold">Licence-plate</div>
                        </th>
                        <th class="p-2">
                            <div class="text-center font-semibold">Actions</div>
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm">
                    <!-- record 1 -->
                    @foreach($vans as $van)
                        <tr>
                            <td class="p-2">
                                <input type="checkbox" class="h-5 w-5" value="id-1"
                                       @click="toggleCheckbox($el, 2890.66)"/>
                            </td>
                            <td class="p-2">
                                <a href="{{ route('van.edit.view', $van->id) }}">
                                    <div class="font-medium text-gray-800 trademark-color-hover">
                                        {{ $van->licenceplate }}
                                    </div>
                                </a>
                            </td>
                            <td class="p-2">
                                <div class="flex justify-center">
                                    <!-- Delete button with data-id attribute -->
                                    <button class="delete-button" onclick="deleteVan('{{$van->id}}')">
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


{{--    javascript Function DELETE button--}}
    <script type="text/javascript">
        function deleteVan(id) {
            $('.popup-delete').show();
            $("#van_id").val(id);
        }
    </script>
@stop
