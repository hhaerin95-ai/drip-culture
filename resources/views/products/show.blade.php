@extends('layouts.app')

@php
    $pageTitle = $product->product_name;
@endphp

@section('content')

<div class="page-header">
    <div class="container">

        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('products.index') }}">Shop</a>
            <span>/</span>
            {{ $product->product_name }}
        </div>

    </div>
</div>

<section class="section">

    <div class="container">

        <div class="product-detail-grid">

            <!-- IMAGE -->
            <div>

                <div style="
                    background:var(--darker);
                    border:1px solid var(--border);
                    border-radius:4px;
                    aspect-ratio:1/1;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:6rem;
                ">
                    👕
                </div>

            </div>

            <!-- INFO -->
            <div>

                <div style="
                    font-size:.75rem;
                    letter-spacing:2px;
                    text-transform:uppercase;
                    color:var(--accent);
                    margin-bottom:12px;
                    font-weight:700;
                ">
                    {{ $product->category->category_name }}
                </div>

                <h1 style="
                    font-size:4rem;
                    text-transform:uppercase;
                    line-height:1;
                    margin-bottom:16px;
                    color:var(--white);
                ">
                    {{ $product->product_name }}
                </h1>

                <div class="detail-price">
                    RM {{ number_format($product->base_price, 2) }}
                </div>

                <p style="
                    color:var(--grey);
                    line-height:1.8;
                    margin-bottom:28px;
                    max-width:500px;
                ">
                    {{ $product->description }}
                </p>

                <div class="stock-badge">
                    ✅ In Stock
                </div>

                <!-- SIZE -->
                <div style="margin-top:36px;">

                    <div class="detail-label">
                        Select Size
                    </div>

                    <div class="size-grid">

                        @forelse($product->variants as $variant)

                            <button class="size-btn">
                                {{ $variant->size }}
                            </button>

                        @empty

                            <div style="color:var(--grey)">
                                No sizes available
                            </div>

                        @endforelse

                    </div>

                </div>

                <!-- QUANTITY -->
                <div>

                    <div class="detail-label">
                        Quantity
                    </div>

                    <div class="qty-wrap">

                        <button class="qty-btn minus-btn">-</button>

<input type="number"
       class="qty-input"
       value="1"
       min="1">

<button class="qty-btn plus-btn">+</button>

                    </div>

                </div>

                <!-- ACTIONS -->
                <div class="detail-actions">

                    <button class="btn btn-primary">
                        Add To Cart
                    </button>

                    <button class="btn btn-dark">
                        Buy Now
                    </button>

                </div>

                <div style="margin-top:24px;">

                    <a href="{{ route('products.index') }}"
                       class="btn btn-dark">

                        ← Back To Shop

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
<script>
document.addEventListener('DOMContentLoaded', () => {

    // SIZE SELECT
    const sizeButtons = document.querySelectorAll('.size-btn');

    sizeButtons.forEach(btn => {
        btn.addEventListener('click', () => {

            sizeButtons.forEach(b => b.classList.remove('active'));

            btn.classList.add('active');

        });
    });

    // QUANTITY
    const minusBtn = document.querySelector('.minus-btn');
const plusBtn = document.querySelector('.plus-btn');
    const qtyInput = document.querySelector('.qty-input');

    minusBtn.addEventListener('click', () => {

        let qty = parseInt(qtyInput.value);

        if(qty > 1){
            qtyInput.value = qty - 1;
        }

    });

    plusBtn.addEventListener('click', () => {

        let qty = parseInt(qtyInput.value);

        qtyInput.value = qty + 1;

    });

});
</script>