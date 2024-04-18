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
            <button class="default-button">Save</button>
        </form>

        @if(session()->has('success'))
            <p class="mt-2 text-emerald-400">{{session('success')}}</p>
        @endif

        @if($errors->any())
            @foreach($errors->all() as $e) @endforeach
            <p class="mt-2 text-rose-400">{{$e}}</p>
        @endif

    </div>
@stop
