@php
    /* ── Logic unchanged ── */
    $discountPercent = 0;
    if ($product->old_price > 0 && $product->old_price > $product->price) {
        $discountPercent = round((($product->old_price - $product->price) / $product->old_price) * 100);
    }
    $badge = $badge ?? null;

    /* ── Image path resolution (same logic as index) ── */
    $cardImagePath = null;
    foreach (['jpg','JPG','jpeg','png','webp'] as $ext) {
        if (file_exists(public_path("images/{$product->code}.{$ext}"))) {
            $cardImagePath = "images/{$product->code}.{$ext}";
            break;
        }
    }

    /* ── RTL helpers ── */
    $isAr   = app()->getLocale() === 'ar';
    $badgePos = $isAr ? 'right-2.5' : 'left-2.5';
    $condPos  = $isAr ? 'left-2.5'  : 'right-2.5';
@endphp

{{--
    Design tokens (inherits from parent page via CSS variables):
        --brand      #7C3AED
        --brand-dk   #4C1D95
        --accent     #10B981
--}}

<div class="group relative bg-white rounded-2xl border border-gray-100 overflow-hidden
            shadow-sm hover:shadow-xl hover:border-gray-200
            transition-all duration-300 ease-out
            hover:-translate-y-1.5 will-change-transform flex flex-col">

    {{-- ── IMAGE AREA ─────────────────────────────────── --}}
    <div class="relative bg-gray-50 overflow-hidden aspect-square flex items-center justify-center p-5 shrink-0">

        @if($cardImagePath)
            <img src="{{ asset($cardImagePath) }}"
                 alt="{{ $product->name }}"
                 loading="lazy"
                 class="w-full h-full object-contain
                        group-hover:scale-105 transition-transform duration-500 ease-out">
        @else
            <i class="fas fa-mobile-alt text-6xl text-gray-200"></i>
        @endif

        {{-- Top badge: featured / bestseller / discount --}}
        @if($badge === 'featured')
            <div class="absolute top-2.5 {{ $badgePos }}">
                <span class="inline-flex items-center gap-1 bg-amber-400 text-white
                             text-[10px] font-extrabold px-2.5 py-1 rounded-full shadow-md tracking-wide">
                    <i class="fas fa-crown text-[9px]"></i>
                    @if($isAr) مميز @else Featured @endif
                </span>
            </div>

        @elseif($badge === 'bestseller')
            <div class="absolute top-2.5 {{ $badgePos }}">
                <span class="inline-flex items-center gap-1 bg-rose-500 text-white
                             text-[10px] font-extrabold px-2.5 py-1 rounded-full shadow-md tracking-wide">
                    <i class="fas fa-fire text-[9px]"></i>
                    @if($isAr) الأكثر مبيعاً @else Bestseller @endif
                </span>
            </div>

        @elseif($badge === 'discount' && $discountPercent > 0)
            <div class="absolute top-2.5 {{ $badgePos }}">
                <div class="w-12 h-12 bg-red-500 text-white rounded-full flex flex-col items-center justify-center shadow-lg leading-none">
                    <span class="text-xs font-black">-{{ $discountPercent }}</span>
                    <span class="text-[9px] font-bold">%</span>
                </div>
            </div>
        @endif

        {{-- Bottom-right: condition badge --}}
        @if($product->condition === 'new')
            <span class="absolute bottom-2.5 {{ $condPos }}
                         bg-emerald-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow">
                @if($isAr) جديد @else NEU @endif
            </span>
        @elseif($product->condition === 'used')
            <span class="absolute bottom-2.5 {{ $condPos }}
                         bg-orange-400 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow">
                @if($isAr) مستعمل @else GEBR. @endif
            </span>
        @endif
    </div>

    {{-- ── PRODUCT INFO ─────────────────────────────────── --}}
    <div class="flex flex-col flex-1 p-4 gap-3">

        {{-- Category chip --}}
        <div class="flex items-center gap-1.5">
            <i class="fas {{ $product->category->icon ?? 'fa-mobile-alt' }} text-purple-500 text-xs"></i>
            <span class="text-[11px] text-gray-400 font-semibold uppercase tracking-wide truncate">
                {{ $product->category->name ?? '' }}
            </span>
        </div>

        {{-- Product name --}}
        <h3 class="text-sm font-bold text-gray-800 leading-snug line-clamp-2
                   group-hover:text-purple-700 transition-colors duration-200 flex-1"
            style="-webkit-line-clamp:2; display:-webkit-box; -webkit-box-orient:vertical; overflow:hidden;">
            {{ $product->name }}
        </h3>

        {{-- Price row --}}
        <div class="flex items-baseline gap-2">
            @if($product->old_price && $product->old_price > $product->price)
                <span class="text-lg font-extrabold text-red-600">
                    {{ number_format($product->price, 2) }}€
                </span>
                <span class="text-xs text-gray-400 line-through">
                    {{ number_format($product->old_price, 2) }}€
                </span>
            @else
                <span class="text-lg font-extrabold" style="color:#7C3AED">
                    {{ number_format($product->price, 2) }}€
                </span>
            @endif
        </div>

        {{-- Stock indicator --}}
        <div class="flex items-center gap-1.5">
            @if($product->stock > 0)
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                <span class="text-[11px] text-emerald-600 font-semibold">
                    @if($isAr) متوفر في المخزون @else Auf Lager @endif
                </span>
            @else
                <span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block"></span>
                <span class="text-[11px] text-red-500 font-semibold">
                    @if($isAr) غير متوفر @else Nicht verfügbar @endif
                </span>
            @endif
        </div>

        {{-- Action buttons --}}
        <div class="flex gap-2 pt-1 mt-auto">
            {{-- View --}}
            <a href="{{ request()->fullUrlWithQuery(['show_id' => $product->id]) }}#products-list"
               class="flex-1 flex items-center justify-center gap-1.5
                      border-2 border-purple-600 text-purple-600 text-xs font-bold py-2.5 rounded-xl
                      hover:bg-purple-600 hover:text-white active:scale-95
                      transition-all duration-200">
                <i class="fas fa-eye text-xs"></i>
                @if($isAr) عرض @else Ansehen @endif
            </a>

            {{-- WhatsApp --}}
            <a href="{{ $product->whatsapp_link }}"
               target="_blank"
               aria-label="WhatsApp"
               class="flex items-center justify-center w-10 h-10 rounded-xl text-white shadow-sm shrink-0
                      active:scale-95 transition-all duration-200"
               style="background:#25D366">
                <i class="fab fa-whatsapp text-lg"></i>
            </a>
        </div>
    </div>
</div>
