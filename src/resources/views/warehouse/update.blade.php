@extends('layouts.main')

@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded min-w-[80%]">
        <form action="{{ route("warehouse.update.action") }}" class="flex flex-col gap-2 mb-4" method="POST">
            <h1 class="text-2xl text-left">Edit Warehouse</h1>
            @csrf
            <input type="text" name="warehouse_id" value="{{ $warehouse->id }}" hidden>
            <label for="name" class="default-label">Name</label>
            <input class="default-input" type="text" name="name" value="{{ $warehouse->name }}" placeholder="Name" required>
            <label for="country" class="default-label">Country</label>
            <input class="default-input" type="text" name="country" value="{{ $warehouse->country }}" placeholder="Country" required>
            <label for="zip_code" class="default-label">Zip Code</label>
            <input class="default-input" type="text" name="zip_code" value="{{ $warehouse->zip_code }}" placeholder="Zip Code" required>
            <label for="street" class="default-label">Street</label>
            <input class="default-input" type="text" name="street" value="{{ $warehouse->street }}" placeholder="Street" required>
            <label for="house_number" class="default-label">House Number</label>
            <input class="default-input" type="text" name="house_number" value="{{ $warehouse->house_number }}" placeholder="House Number" required>
            <label for="city" class="default-label">City</label>
            <input class="default-input" type="text" name="city" value="{{ $warehouse->city }}" placeholder="City" required>
            <button class="default-button w-fit !px-4">Update</button>

            @if(session()->has('success'))
                <p class="p-2 text-emerald-500">{{ session('success') }}</p>
            @endif

            @foreach ($errors->all() as $error)
                <p class="p-2 text-rose-500">{{ $error }}</p>
            @endforeach
        </form>
    </div>
@stop
