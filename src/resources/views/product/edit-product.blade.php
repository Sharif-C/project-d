@extends('layouts.main')

@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded min-w-[80%]">
        <form action="{{ route('product.update', $product->id) }}" class="flex flex-col gap-2 mb-4" method="POST">
            <h1 class="text-2xl text-left">Edit product</h1>
            @csrf
            @method('PUT')
            <label for="name" class="default-label">Name</label>
            <input class="default-input" type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Name" required>
            <label for="description" class="default-label">Description</label>
            <input class="default-input" type="text" name="description" value="{{ old('description', $product->description) }}" placeholder="Description">
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
