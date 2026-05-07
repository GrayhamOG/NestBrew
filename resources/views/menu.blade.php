@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-center mb-8">Our Menu</h1>

    {{-- Filter buttons --}}
    <div class="flex gap-3 justify-center mb-8 flex-wrap">
        <button class="filter-btn active-btn px-5 py-2 rounded-full border" data-cat="all">All</button>
        <button class="filter-btn px-5 py-2 rounded-full border" data-cat="coffee">Coffee</button>
        <button class="filter-btn px-5 py-2 rounded-full border" data-cat="noncoffee">Non-Coffee</button>
        <button class="filter-btn px-5 py-2 rounded-full border" data-cat="pastry">Pastries</button>
        <button class="filter-btn px-5 py-2 rounded-full border" data-cat="food">Food</button>
    </div>

    {{-- Menu grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="menu-grid">
        @foreach($menuItems as $item)
        <div class="menu-card border rounded-xl p-5" data-category="{{ $item->category }}">
            <span class="text-4xl">{{ $item->emoji }}</span>
            <h3 class="text-lg font-semibold mt-3">{{ $item->name }}</h3>
            <p class="text-sm text-gray-500 mt-1 mb-4">{{ $item->description }}</p>
            <div class="flex justify-between items-center">
                <span class="font-bold text-brown-700">₱{{ $item->price }}</span>
                @auth
                    <button class="add-to-cart bg-brown-800 text-white px-3 py-1 rounded-full text-sm"
                            data-id="{{ $item->id }}"
                            data-name="{{ $item->name }}"
                            data-price="{{ $item->price }}">
                        + Add
                    </button>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-blue-500 underline">Sign in to order</a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>

</div>

{{-- jQuery filter + add to cart --}}
<script>
$(document).ready(function () {

    // Filter by category
    $('.filter-btn').on('click', function () {
        const cat = $(this).data('cat');
        $('.filter-btn').removeClass('active-btn font-bold');
        $(this).addClass('active-btn font-bold');
        if (cat === 'all') {
            $('.menu-card').fadeIn(200);
        } else {
            $('.menu-card').hide();
            $('.menu-card[data-category="' + cat + '"]').fadeIn(200);
        }
    });

    // Add to cart
    $('.add-to-cart').on('click', function () {
        const name  = $(this).data('name');
        const price = $(this).data('price');
        alert(name + ' (₱' + price + ') added to cart!');
        // You will replace this alert with real cart logic later
    });

});
</script>
@endsection