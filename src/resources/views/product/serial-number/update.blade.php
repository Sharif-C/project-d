@extends('layouts.main')
@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded min-w-[80%]">
        <div class="mb-2">
            <h1 class="text-2xl text-left">Product: {{$product->name}}</h1>
            <h2 class="text-xl text-left">Serial number: {{request('serial_number')}}</h2>
        </div>

        <form action="{{route('update.serial-number')}}" method="POST" class="flex flex-col gap-2 mb-4">
        @csrf
            <input type="text" name="product_id" value="{{request('product_id')}}" readonly>
            <input type="text" name="serial_number" value="{{request('serial_number')}}" readonly>
            <label for="warehouse_id">Warehouse</label>
            <select name="warehouse_id" id="">
                @foreach($warehouses as $w)
                    <option value="{{$w->_id}}" @selected($w->_id === $product->warehouse()?->_id)>{{$w?->name}}</option>
                @endforeach
            </select>
            <button class="default-button w-fit !px-4">Save</button>
        </form>
    </div>
@stop


{{--TODO: add nice error and success messages --}}
