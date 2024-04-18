<nav class="bg-[#88327D] w-[300px] flex flex-col items-center p-6">
    <h1 class="font-bold text-2xl p-2 uppercase text-white text-left w-full">Inventory Connect</h1>

    <ul class="flex flex-col w-full mt-8">
        <li class="flex flex-col text-xl gap-6">
            <a class="nav-button" href="{{route('manage.products')}}">
                <div class="flex gap-3 items-center">
                    <x-heroicon-s-archive-box class="w-6"/>
                    <p>Products</p>
                </div>
            </a>
            <a class="nav-button" href="{{route('manage.serial-numbers')}}">
                <div class="flex gap-3 items-center">
                    <x-heroicon-s-inbox-stack class="w-6"/>
                    <p>Serial numbers</p>
                </div>
            </a>
            <a class="nav-button" href="{{route('manage.warehouses')}}">
                <div class="flex gap-3 items-center">
                    <x-heroicon-s-squares-2x2 class="w-6"/>
                    <p>Warehouses</p>
                </div>
            </a>
        </li>
    </ul>
</nav>
