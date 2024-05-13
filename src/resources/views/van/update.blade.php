@extends('layouts.main')

@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded min-w-[80%]">
        <form action="{{route("van.update.action")}}" class="flex flex-col gap-2 mb-4" method="POST">
            <h1 class="text-2xl text-left">Edit van</h1>
            @csrf
            <input type="text" name="van_id" value="{{$van->id}}" hidden>
            <label for="name" class="default-label">License plate</label>
            <input class="default-input" type="text" name="license_plate" value="{{$van->licenceplate}}" placeholder="License plate" required>
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
