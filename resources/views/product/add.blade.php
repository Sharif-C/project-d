@extends('layouts.main')
@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded">
        <h1 class="text-2xl mb-2 text-center">Add product</h1>

        <form action="{{route('product.store')}}" method="POST" class="flex flex-col gap-2 mb-5">
            @csrf
            <input type="text" name="name" id="" placeholder="Name" value="{{old('name')}}">
            <input type="text" name="description" id="" placeholder="Description" value="{{old('description')}}">
            <button class="rounded bg-emerald-400 text-white py-2 px-3">Save</button>
        </form>

        @if(session()->has('success'))
            <p class="mt-2 text-emerald-400">{{session('success')}}</p>
        @endif

        @if($errors->any())
            @foreach($errors->all() as $e) @endforeach
            <p class="mt-2 text-rose-400">{{$e}}</p>
        @endif

        <x-bladewind.table hover_effect="false">
            <x-slot name="header">
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created at</th>
                <th>Updated at</th>
            </x-slot>

            @foreach($products as $p)
                <tr>
                    <td>{{$p->_id}}</td>
                    <td>{{$p->name}}</td>
                    <td>{{$p->description}}</td>
                    <td>{{$p->created_at}}</td>
                    <td>{{$p->updated_at}}</td>
                </tr>
            @endforeach
        </x-bladewind.table>
    </div>
@stop
