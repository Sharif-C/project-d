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

    <div class="m-12 mx-auto mb-0 h-[540px] w-[80%] rounded ">
        {{--TODO: add route for comment handling--}}
        <form action="" class="flex flex-col gap-2 mb-4">
            <textarea name="comment" cols="30" rows="2" class="default-input" placeholder="Write a comment..."></textarea>
            <button class="default-button w-fit !mt-1">Save</button>
        </form>

        <section class="comment-section flex flex-col gap-4 border-t-2 border-gray-300 pt-3 pr-5 overflow-auto h-[390px]">
            @for($i=1; $i<12; $i++)
                <div class="comment-item">
                    <h3 class="font-semibold text-gray-800 flex flex-col text-sm ml-0.5 mb-0.5 w-full">Sharif - Admin</h3>
                    <p class="comment-box relative">
                        lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum

                        <x-heroicon-s-trash class="absolute top-2 right-2 w-4 h-4 text-rose-400 hover-fx hover:text-rose-600"/>
                    </p>
                    <p class="font-light text-[11px] ml-0.5 mt-0.5">22:12:00 12-05-2024</p>
                </div>
            @endfor
        </section>
    </div>
@stop
