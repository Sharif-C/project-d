@extends('layouts.main')

@section('content')
    <section class="flex flex-col justify-start gap-4 p-2 max-w-5xl m-auto">
        <form action="{{ route('product.update', $product->id) }}" method="POST"
              class="bg-white p-6 rounded flex flex-col gap-2 w-fit shadow-lg">
            <h2 class="font-semibold text-gray-800">Edit product</h2>
            @csrf
            @method('PUT')

            <input class="rounded" type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="Name" required>
            <input class="rounded" type="text" name="description" value="{{ old('description', $product->description) }}" placeholder="Description">
            <button class="default-button">Update</button>

            @if(session()->has('success'))
                <p class="p-2 text-emerald-500">{{ session('success') }}</p>
            @endif
        </form>
    </section>
@stop