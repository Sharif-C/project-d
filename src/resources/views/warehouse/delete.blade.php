@extends('layouts.main')
@section('content')
    <form action="{{ route('warehouse.delete') }}" method="POST" class="bg-indigo-500 p-2 rounded m-auto">
        @csrf
        <input type="text" name="name" placeholder="Warehouse name" required>
        <button class="p-2 bg-emerald-500 text-white rounded">Save</button>
    </form>
@stop
