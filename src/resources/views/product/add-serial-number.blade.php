@extends('layouts.main')
@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded">
        <h1 class="text-2xl mb-2 text-center">Add serial number</h1>

        <form action="{{route('product.store-serial-number')}}" method="POST" class="flex flex-col gap-2">
            @csrf
            <select name="product_id" id="">
                @foreach($products as $p)
                    <option value="{{$p->_id}}">{{$p->name}}</option>
                @endforeach
            </select>
            <input type="text" name="serial_number" id="" placeholder="Serial number">
            <input type="text" name="warehouse_id" id="" placeholder="Warehouse ID">
            <button class="rounded bg-emerald-400 text-white py-2 px-3">Save</button>
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
