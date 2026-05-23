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
                    font-size:0.75rem;
                    letter-spacing:2px;
                    text-transform:uppercase;
                    color:var(--accent);
                    margin-bottom:12px;
                    font-weight:700;
                ">
                    {{ $product->category->category_name }}
                </div>

                <h1 style="
                    font-size:2.5rem;
                    text-transform:uppercase;
                    margin-bottom:12px;
                    color:var(--white);
                ">
                    {{ $product->product_name }}
                </h1>

                <div style="
                    font-size:2rem;
                    font-weight:700;
                    color:var(--accent);
                    margin-bottom:24px;
                ">
                    RM {{ number_format($product->base_price, 2) }}
                </div>

                <p style="
                    color:var(--grey);
                    line-height:1.8;
                    margin-bottom:32px;
                ">
                    {{ $product->description }}
                </p>

                <div class="detail-stock">
                    ✅ Available
                </div>

                <div style="margin-top:32px;">
                    <a href="{{ route('products.index') }}"
                       class="btn btn-primary">
                        ← Back To Shop
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>

@endsection