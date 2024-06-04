@extends('layouts.main')
@section('content')

    <section id="selection-box" class="grid grid-cols-2 gap-8 w-[80%] mt-[40px] mx-auto p-4 text-3xl text-white font-bold">

        <a href="{{route('manage.products')}}">
            <div
                class="h-[300px] bg-[#88327D]/[.9] rounded text-center flex flex-col justify-center items-center py-8 hover-fx hover:scale-[0.98]">
                <x-heroicon-s-archive-box class="w-24"/>
                <p>Products</p>
            </div>
        </a>

        <a href="{{route('manage.serial-numbers')}}">
            <div
                class="h-[300px] bg-[#88327D]/[.9] rounded text-center flex flex-col justify-center items-center py-8 hover-fx hover:scale-[0.98]">
                <x-heroicon-s-inbox-stack class="w-24"/>
                <p>Serial numbers</p>
            </div>
        </a>

        <a href="{{route('manage.warehouses')}}">
            <div
                class="h-[300px] bg-[#88327D]/[.9] rounded text-center flex flex-col justify-center items-center py-8 hover-fx hover:scale-[0.98]">
                <x-heroicon-s-squares-2x2 class="w-24"/>
                <p>Warehouses</p>
            </div>
        </a>

        <a href="{{route('manage.vans')}}">
            <div
                class="h-[300px] bg-[#88327D]/[.9] rounded text-center flex flex-col justify-center items-center py-8 hover-fx hover:scale-[0.98]">
                <x-heroicon-s-truck class="w-24"/>
                <p>Vans</p>
            </div>
        </a>
    </section>
@stop
