@php
    $selected_serial_number = request('serial_number');
    $status = strtoupper($product?->serial_numbers[0]['status']);
@endphp

@extends('layouts.main')
@section('content')
    <div class="m-auto bg-white p-4 w-fit rounded min-w-[80%]">
        <div class="mb-2 flex justify-between items-center">
            <div class="flex gap-2 items-center">
                <h1 class="text-2xl text-left">Product: {{$product->name}}</h1>
                <div @class([\App\Utils\Product\Enums\Status::labelColor($status), "!text-sm w-fit h-fit text-gray-800 flex justify-center rounded px-[4px] py-[2px] text-white" ])>{{$status}}</div>
            </div>
            <button id="logs-btn" class="default-button !text-sm !bg-slate-500 hover:!bg-orange-700 !flex !gap-2">Logs <x-heroicon-o-document-text class="w-4"/></button>
        </div>

        <form action="{{route('update.serial-number')}}" method="POST" class="flex flex-col gap-2 mb-4">
            @csrf
            <input type="text" name="product_id" value="{{request('product_id')}}" readonly hidden>
            <input type="text" name="old_serial_number" value="{{$selected_serial_number}}" readonly hidden>

            <label for="new_serial_number" class="default-label">Serial number</label>
            <input type="text" name="new_serial_number" value="{{$selected_serial_number}}" readonly disabled class="default-input">

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

    <div class="m-12 mx-auto mb-0 h-[540px] w-[80%] rounded">
        <form action="{{ route('product.comments.add', $product->id) }}" method="POST" class="flex flex-col gap-2 mb-4">
            @csrf
            <textarea name="text" cols="30" rows="2" class="default-input" placeholder="Write a comment..."></textarea>
            <input name="serial_number" type="text" value="{{$selected_serial_number}}" hidden readonly required>
            <button type="submit" class="default-button w-fit !mt-1">Save</button>

            @if(session()->has('success_comment_add'))
                <p class="mt-2 text-sm text-emerald-400">{{session('success_comment_add')}}</p>
            @endif
        </form>

        <!--existing comments -->
        <section class="comment-section flex flex-col gap-3 border-t-2 border-gray-300 pt-3 pr-5 overflow-auto h-[390px]">
            @if(session()->has('success_comment'))
                <p class="mt-2 text-emerald-400">{{session('success_comment')}}</p>
            @endif

            @foreach($product->serial_numbers ?? [] as $serialNumber)
                @if(!empty($serialNumber['comments']))
                    @foreach($serialNumber['comments'] as $i => $comment)
                        <div>
                            <h3 class="font-semibold text-gray-800 flex flex-col text-sm ml-0.5 mb-[3px] w-full">{{$comment['user'] . " - " . $comment['role']}}</h3>
                            <div class="comment-item">
                                <!--text -->
                                <p class="comment-box relative">{!! nl2br(e($comment['text'])) !!}
                                    <x-heroicon-s-trash data-id="{{$comment['id']}}" class="delete-comment-btn absolute top-2 right-2 w-4 h-4 text-rose-400 hover-fx hover:text-rose-600"/>
                                </p>
                                <p class="font-light text-[11px] ml-0.5 mt-[3px]">{{ $comment['created_at']?->toDateTime()?->format('d-m-Y H:i:s') }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
        </section>
    </div>

    <x-popup.form key="delete-comment" heading="Are you sure to delete this comment?">
        <x-slot:form>
            <form action="{{route('product.comment.delete')}}" method="POST">
                @csrf
                <input type="text" name="product_id" value="{{$product->id}}" required readonly hidden>
                <input type="text" name="serial_number" value="{{$selected_serial_number}}" required readonly hidden>
                <input type="text" id="delete-comment-id" name="comment_id" required readonly hidden>
                <button class="cancel-btn flex gap-2 items-center">Delete <x-heroicon-o-trash class="w-5"/></button>
            </form>
        </x-slot:form>
    </x-popup.form>


    <x-popup.form key="serial-number-history" heading="History logs">
        <x-slot:form>
            <section class="comment-section flex flex-col gap-4 pt-3 pr-5 overflow-auto h-[390px]">
                @foreach($product->serial_numbers ?? [] as $serialNumber)
                    @if(!empty($serialNumber['history']))
                        @foreach( array_reverse($serialNumber['history'])  as $i => $log)
                            <div>
                                <div @class(["log bg-gray-100 p-3 rounded", "!bg-[#88327D]/[0.1]" => $i==0 ])>
                                    <p class="">{!! nl2br(e($log['text'])) !!}</p>
                                    <p class="font-light text-[11px] mt-[3px]">{{ $log['created_at']?->toDateTime()?->format('d-m-Y H:i:s') }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </section>
        </x-slot:form>
    </x-popup.form>

    <script type="text/javascript">
        $(".delete-comment-btn").click(function(){
            let commentId = $(this).data('id');
            $('#delete-comment-id').val(commentId);
            $('.popup-delete-comment').show();
            showPopup(commentId);
        });


        $("#logs-btn").click(function (){
            $('.popup-serial-number-history').show();
        });
    </script>
@stop
