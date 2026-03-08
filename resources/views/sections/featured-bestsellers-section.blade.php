@php
    /* ── Queries unchanged ── */
    $featuredProducts = \App\Models\Product::where('is_featured', true)
        ->where('is_active', true)
        ->with(['category', 'primaryImage'])
        ->inRandomOrder()
        ->take(4)
        ->get();

    $bestSellers = \App\Models\Product::where('is_active', true)
        ->where('stock', '>', 0)
        ->with(['category', 'primaryImage'])
        ->latest()
        ->take(4)
        ->get();

    $discountedProducts = \App\Models\Product::where('is_active', true)
        ->whereNotNull('old_price')
        ->whereColumn('old_price', '>', 'price')
        ->with(['category', 'primaryImage'])
        ->take(4)
        ->get();

    $isAr = app()->getLocale() === 'ar';

    /* ── Tab config ── */
    $tabs = [
        ['id' => 'featured',    'icon' => 'fa-crown',
         'label_ar' => 'مميزة',         'label_de' => 'Featured',
         'badge'    => 'featured',       'products'  => $featuredProducts,
         'empty_ar' => 'لا توجد منتجات مميزة حالياً',
         'empty_de' => 'Keine Featured-Produkte verfügbar'],
        ['id' => 'bestsellers', 'icon' => 'fa-fire',
         'label_ar' => 'الأكثر مبيعاً', 'label_de' => 'Bestseller',
         'badge'    => 'bestseller',     'products'  => $bestSellers,
         'empty_ar' => 'لا توجد منتجات حالياً',
         'empty_de' => 'Keine Produkte verfügbar'],
        ['id' => 'discounts',   'icon' => 'fa-tags',
         'label_ar' => 'خصومات',         'label_de' => 'Rabatte',
         'badge'    => 'discount',       'products'  => $discountedProducts,
         'empty_ar' => 'لا توجد خصومات حالياً',
         'empty_de' => 'Keine Rabatte verfügbar'],
    ];
@endphp

<section class="py-16 sm:py-20 bg-[#F8F7FF]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── HEADER ─────────────────────────────────── --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-10">

            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-purple-500 mb-1 block">
                    @if($isAr) اختيارات خاصة @else Unsere Highlights @endif
                </span>
                <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-gray-900">
                    @if($isAr)
                        <i class="fas fa-star text-amber-400 me-2 text-2xl"></i>منتجاتنا المميزة
                    @else
                        <i class="fas fa-star text-amber-400 me-2 text-2xl"></i>Unsere Top-Angebote
                    @endif
                </h2>
            </div>

            {{-- Tab switcher --}}
            <div class="flex bg-white border border-gray-200 rounded-2xl p-1 gap-1 shadow-sm w-full sm:w-auto">
                @foreach($tabs as $tab)
                    <button
                        onclick="switchTab('{{ $tab['id'] }}')"
                        id="tab-{{ $tab['id'] }}"
                        data-tab="{{ $tab['id'] }}"
                        class="tab-btn flex-1 sm:flex-none flex items-center justify-center gap-1.5
                           px-4 py-2.5 rounded-xl text-xs font-bold transition-all duration-200
                           text-gray-500 hover:text-gray-800 hover:bg-gray-50">
                        <i class="fas {{ $tab['icon'] }} text-[11px]"></i>
                        <span class="hidden sm:inline">@if($isAr) {{ $tab['label_ar'] }} @else {{ $tab['label_de'] }} @endif</span>
                        <span class="sm:hidden">@if($isAr) {{ $tab['label_ar'] }} @else {{ $tab['label_de'] }} @endif</span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- ── TAB CONTENTS ────────────────────────────── --}}
        @foreach($tabs as $tab)
            <div id="content-{{ $tab['id'] }}"
                 class="tab-content @if(!$loop->first) hidden @endif">

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5">
                    @forelse($tab['products'] as $product)
                        @include('partials.product-card', [
                            'product' => $product,
                            'badge'   => $tab['badge'],
                        ])
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-inbox text-2xl text-gray-300"></i>
                            </div>
                            <p class="text-gray-400 font-semibold text-base">
                                @if($isAr) {{ $tab['empty_ar'] }} @else {{ $tab['empty_de'] }} @endif
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach

    </div>
</section>

{{-- ── STYLES ─────────────────────────────────────────── --}}
<style>
    /* Active tab pill */
    .tab-btn.is-active {
        background: linear-gradient(135deg, #7C3AED, #4C1D95);
        color: #fff !important;
        box-shadow: 0 4px 14px -2px rgba(124, 58, 237, .35);
    }

    /* Fade-in animation for tab content */
    .tab-content {
        animation: tabFadeIn .3s ease-out both;
    }

    @keyframes tabFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0);   }
    }

    /* font-display fallback if Syne not loaded yet */
    .font-display { font-family: 'Syne', 'Cairo', sans-serif; }
</style>

{{-- ── SCRIPT ──────────────────────────────────────────── --}}
<script>
    (function () {
        /* Activate first tab on load */
        const firstTab = document.querySelector('.tab-btn');
        if (firstTab) firstTab.classList.add('is-active');

        window.switchTab = function (tabName) {
            /* Hide all content panels */
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.add('hidden');
            });

            /* Deactivate all tab buttons */
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('is-active');
            });

            /* Show chosen panel and activate its button */
            const panel = document.getElementById('content-' + tabName);
            const btn   = document.getElementById('tab-'     + tabName);

            if (panel) {
                panel.classList.remove('hidden');
                /* Re-trigger animation by cloning */
                panel.style.animation = 'none';
                panel.offsetHeight;                   /* reflow */
                panel.style.animation = '';
            }
            if (btn) btn.classList.add('is-active');
        };
    })();
</script>
