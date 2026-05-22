<!-- FEATURED PRODUCTS -->
 @extends('layouts.app')

@section('content')
<section class="section" id="featured">
    <div class="container">
        <p class="section-sub" style="color:var(--accent);font-weight:700;letter-spacing:2px;text-transform:uppercase;margin-bottom:8px;">
            Featured Drops
        </p>

        <h2 class="section-title" style="color:var(--white);">
            This Season's Heat
        </h2>

        <div class="divider"></div>

        <div class="products-grid">
            @forelse ($featured as $p)
                <div class="product-card">

                    <div class="product-img">
                        <div class="product-img-placeholder">👕</div>
                        <span class="product-badge">Featured</span>
                    </div>

                    <div class="product-info">
                        <div class="product-cat">
                            {{ $p->category->category_name }}
                        </div>

                        <div class="product-name">
                            {{ $p->product_name }}
                        </div>

                        <div class="product-footer">
                            <div class="product-price">
                                RM <span>{{ number_format($p->base_price, 2) }}</span>
                            </div>

                            <a href="{{ route('products.show', $p->product_id) }}"
                               class="quick-add">
                                View →
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <p style="color:var(--grey);grid-column:1/-1;text-align:center;">
                    No products yet. Check back soon!
                </p>
            @endforelse
        </div>

        <div style="text-align:center;margin-top:48px;">
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                View All Products →
            </a>
        </div>
    </div>
</section>
@endsection