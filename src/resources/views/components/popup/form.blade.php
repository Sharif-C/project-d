@props(['key', 'heading', 'form'])
@php
$overlay = "popup-$key";
$closeButton = "close-$key";
@endphp

{{--style="display: none;"--}}
<div @class(["fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center w-full h-full $overlay"]) style="display: none">
    <div class="bg-white p-8 rounded-lg shadow-md relative">
        <x-heroicon-o-x-mark @class(['w-5 text-gray-500 absolute top-2 right-2 hover:cursor-pointer', $closeButton])/>
        <h2 class="text-xl mb-2">{{$heading ?? "Heading"}}</h2>
        {{$form ?? "Form content"}}
    </div>

    <script>
        $(".{{$closeButton}}").click(function () {
            $(".{{$overlay}}").hide();

        });
    </script>
</div>
