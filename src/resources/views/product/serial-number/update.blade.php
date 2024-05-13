@extends('layouts.main')
@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded min-w-[80%]">
        <div class="mb-2">
            <h1 class="text-2xl text-left">Product: {{$product->name}}</h1>
        </div>

        <form action="{{route('update.serial-number')}}" method="POST" class="flex flex-col gap-2 mb-4">
        @csrf
            <input type="text" name="product_id" value="{{request('product_id')}}" readonly hidden>
            <input type="text" name="old_serial_number" value="{{request('serial_number')}}" readonly hidden>

            <label for="new_serial_number" class="default-label">Serial number</label>
            <input type="text" name="new_serial_number" value="{{request('serial_number')}}" class="default-input">

            <label for="warehouse_id" class="default-label">Warehouse</label>
            <select name="warehouse_id" class="default-input">
                @foreach($warehouses as $w)
                    <option value="{{$w->_id}}" @selected($w->_id === $product->warehouse()?->_id)>{{$w?->name}}</option>
                @endforeach
            </select>
            <button class="default-button w-fit !px-4">Save</button>
        </form>

        @if(session()->has('success'))
            <p class="mt-2 text-emerald-400">{{session('success')}}</p>
        @endif

        @foreach($errors->all() as $e)
            <p class="mt-2 text-rose-400">{{$e}}</p>
        @endforeach
    </div>
@stop
