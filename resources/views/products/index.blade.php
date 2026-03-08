<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PHONE2GO - @if(app()->getLocale() === 'ar') متجرك الموثوق @else Ihr vertrauenswürdiger Shop @endif</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand:     #7C3AED;
            --brand-mid: #6D28D9;
            --brand-dk:  #4C1D95;
            --accent:    #10B981;
            --surface:   #F8F7FF;
            --text-main: #1A1033;
            --text-muted:#6B7280;
        }

        /* ── Typography ── */
        body       { font-family:'DM Sans',sans-serif; color:var(--text-main); background:var(--surface); }
        [dir="rtl"]{ font-family:'Cairo',sans-serif; }
        .font-display { font-family:'Syne',sans-serif; }

        /* ── Nav underline ── */
        .nav-link { position:relative; }
        .nav-link::after {
            content:''; position:absolute; bottom:-4px; left:0; width:0; height:2px;
            background:var(--brand); border-radius:99px;
            transition:width .25s ease;
        }
        .nav-link:hover::after { width:100%; }
        [dir="rtl"] .nav-link::after { left:auto; right:0; }

        /* ── Mobile menu slide ── */
        #mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease, opacity .25s ease;
            opacity: 0;
        }
        #mobile-menu.open {
            max-height: 400px;
            opacity: 1;
        }

        /* ── Hero mesh background ── */
        .hero-bg {
            background-color: #4C1D95;
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 50%, rgba(124,58,237,.55) 0%, transparent 70%),
                radial-gradient(ellipse 60% 80% at 80% 20%, rgba(109,40,217,.4) 0%, transparent 65%),
                radial-gradient(ellipse 50% 50% at 60% 80%, rgba(16,185,129,.18) 0%, transparent 60%);
        }

        /* ── Product card ── */
        .product-card {
            transition: box-shadow .25s ease, transform .25s ease;
            will-change: transform;
        }
        @media(hover:hover){
            .product-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 40px -8px rgba(124,58,237,.18);
            }
        }

        /* ── Service card ── */
        .service-card { transition: box-shadow .25s ease, transform .25s ease; }
        @media(hover:hover){
            .service-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 16px 32px -6px rgba(0,0,0,.12);
            }
        }

        /* ── WhatsApp button ── */
        .wa-btn {
            background: #25D366;
            transition: background .2s, transform .15s, box-shadow .2s;
        }
        @media(hover:hover){
            .wa-btn:hover {
                background: #1da851;
                box-shadow: 0 8px 24px -4px rgba(37,211,102,.5);
            }
        }
        .wa-btn:active { transform: scale(.97); }

        /* ── Floating phone (desktop only) ── */
        @media(min-width:1024px){
            @keyframes float {
                0%,100%{ transform:translateY(0) rotate(-4deg); }
                50%    { transform:translateY(-18px) rotate(-4deg); }
            }
            .hero-phone { animation: float 4s ease-in-out infinite; }
        }

        /* ── Pulse badge ── */
        @keyframes pulse-ring {
            0%  { box-shadow:0 0 0 0 rgba(124,58,237,.4); }
            70% { box-shadow:0 0 0 10px rgba(124,58,237,0); }
            100%{ box-shadow:0 0 0 0 rgba(124,58,237,0); }
        }
        .pulse-badge { animation:pulse-ring 2.5s ease infinite; }

        /* ── Bottom-sheet modal on mobile ── */
        @media(max-width:767px){
            #product-modal-inner {
                border-radius: 1.5rem 1.5rem 0 0 !important;
                max-height: 92dvh;
                overflow-y: auto;
                align-self: flex-end;
                width: 100%;
            }
        }

        /* ── Scrollbar thin ── */
        .scrollbar-thin::-webkit-scrollbar { width:4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background:transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:99px; }

        /* ── Chip pills ── */
        .chip-active { background:var(--brand); color:#fff; border-color:var(--brand); }
        .chip { border-color:#E5E7EB; color:var(--text-muted); background:#fff; transition:all .2s; }
        .chip:hover { border-color:var(--brand); color:var(--brand); }

        /* ── Section divider wave ── */
        .wave-divider { line-height:0; }
        .wave-divider svg { display:block; }
    </style>
</head>

<body class="antialiased">

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- NAV                                                      --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-18">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-md"
                     style="background:linear-gradient(135deg,#7C3AED,#4C1D95)">
                    <i class="fas fa-mobile-alt text-white text-base"></i>
                </div>
                <div class="leading-none">
                    <span class="font-display text-xl font-extrabold" style="color:var(--brand-dk)">PHONE2GO</span>
                    <p class="text-[10px] text-gray-400 hidden sm:block">
                        @if(app()->getLocale() === 'ar') متجرك الموثوق @else Ihr vertrauenswürdiger Shop @endif
                    </p>
                </div>
            </a>

            {{-- Desktop links --}}
            <div class="hidden md:flex items-center gap-7 text-sm font-semibold text-gray-600">
                <a href="#home"     class="nav-link hover:text-purple-700 transition-colors">@if(app()->getLocale() === 'ar') الرئيسية @else Startseite @endif</a>
                <a href="#about"    class="nav-link hover:text-purple-700 transition-colors">@if(app()->getLocale() === 'ar') من نحن @else Über uns @endif</a>
                <a href="#services" class="nav-link hover:text-purple-700 transition-colors">@if(app()->getLocale() === 'ar') خدماتنا @else Leistungen @endif</a>
                <a href="#products" class="nav-link hover:text-purple-700 transition-colors">@if(app()->getLocale() === 'ar') المنتجات @else Produkte @endif</a>
                <a href="#kontakt"  class="nav-link hover:text-purple-700 transition-colors">@if(app()->getLocale() === 'ar') تواصل معنا @else Kontakt @endif</a>
            </div>

            {{-- Right controls --}}
            <div class="flex items-center gap-2">
                {{-- Language switcher --}}
                <div class="flex bg-gray-100 rounded-full p-0.5 text-xs font-bold">
                    <a href="{{ route('language.switch', 'de') }}"
                       class="px-3 py-1.5 rounded-full transition
                              @if(app()->getLocale() === 'de') bg-purple-700 text-white shadow @else text-gray-500 hover:text-gray-800 @endif">
                        DE
                    </a>
                    <a href="{{ route('language.switch', 'ar') }}"
                       class="px-3 py-1.5 rounded-full transition
                              @if(app()->getLocale() === 'ar') bg-purple-700 text-white shadow @else text-gray-500 hover:text-gray-800 @endif">
                        AR
                    </a>
                </div>

                {{-- WhatsApp CTA (desktop) --}}
                <a href="https://wa.me/491633617202" target="_blank"
                   class="hidden md:flex items-center gap-1.5 wa-btn text-white text-sm font-semibold px-4 py-2 rounded-full shadow-sm">
                    <i class="fab fa-whatsapp text-base"></i>
                    <span>WhatsApp</span>
                </a>

                {{-- Hamburger --}}
                <button id="mobile-menu-btn" class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 transition text-gray-600"
                        aria-label="Menu" aria-expanded="false">
                    <i id="hamburger-icon" class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" role="menu">
            <div class="pb-4 pt-1 flex flex-col gap-0.5">
                @php $mobileLinks = [
                    ['#home',     app()->getLocale()==='ar' ? 'الرئيسية'  : 'Startseite', 'fa-home'],
                    ['#about',    app()->getLocale()==='ar' ? 'من نحن'    : 'Über uns',   'fa-info-circle'],
                    ['#services', app()->getLocale()==='ar' ? 'خدماتنا'   : 'Leistungen', 'fa-tools'],
                    ['#products', app()->getLocale()==='ar' ? 'المنتجات'  : 'Produkte',   'fa-box'],
                    ['#kontakt',  app()->getLocale()==='ar' ? 'تواصل معنا': 'Kontakt',    'fa-map-marker-alt'],
                ]; @endphp
                @foreach($mobileLinks as [$href,$label,$icon])
                    <a href="{{ $href }}"
                       class="mobile-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 text-sm font-medium hover:bg-purple-50 hover:text-purple-700 transition">
                        <i class="fas {{ $icon }} w-4 text-center text-purple-400"></i>
                        {{ $label }}
                    </a>
                @endforeach
                <a href="https://wa.me/491633617202" target="_blank"
                   class="mt-2 flex items-center justify-center gap-2 wa-btn text-white text-sm font-bold py-3 rounded-xl shadow">
                    <i class="fab fa-whatsapp text-lg"></i>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</nav>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- HERO                                                     --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section id="home" class="hero-bg text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 lg:py-28">
        <div class="flex flex-col lg:flex-row items-center gap-10 lg:gap-16">

            <div class="w-full lg:w-1/2 text-center lg:text-{{ app()->getLocale()==='ar'?'right':'left' }} order-2 lg:order-1">
                <span class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-purple-200 text-xs font-semibold px-3 py-1.5 rounded-full mb-5 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full pulse-badge inline-block"></span>
                    @if(app()->getLocale()==='ar') متجر موثوق في كيل @else Vertrauenswürdig in Kiel @endif
                </span>

                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight mb-5">
                    @if(app()->getLocale()==='ar')
                        متجرك الأول<br>
                        <span class="text-emerald-400">للهواتف الذكية</span>
                    @else
                        Ihr Handy-Shop<br>
                        <span class="text-emerald-400">in Kiel</span>
                    @endif
                </h1>

                <p class="text-white/70 text-base sm:text-lg leading-relaxed mb-8 max-w-md mx-auto lg:mx-0">
                    @if(app()->getLocale()==='ar')
                        بيع، شراء، إصلاح، وخدمات متكاملة للهواتف الذكية في قلب ألمانيا
                    @else
                        Kauf, Verkauf, Reparatur und komplette Smartphone-Services im Herzen Deutschlands
                    @endif
                </p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                    <a href="#products"
                       class="flex items-center justify-center gap-2 bg-white text-purple-700 font-bold px-6 py-3.5 rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition text-sm sm:text-base">
                        <i class="fas fa-shopping-bag"></i>
                        @if(app()->getLocale()==='ar') تصفح المنتجات @else Produkte ansehen @endif
                    </a>
                    <a href="https://wa.me/491633617202" target="_blank"
                       class="flex items-center justify-center gap-2 wa-btn font-bold px-6 py-3.5 rounded-2xl shadow-lg text-sm sm:text-base">
                        <i class="fab fa-whatsapp text-lg"></i>
                        @if(app()->getLocale()==='ar') تواصل عبر واتساب @else WhatsApp schreiben @endif
                    </a>
                </div>

                {{-- Stats row --}}
                <div class="grid grid-cols-3 gap-4 mt-10 pt-8 border-t border-white/15">
                    @foreach([['500+', app()->getLocale()==='ar'?'منتج':'Produkte'],['1K+', app()->getLocale()==='ar'?'عميل':'Kunden'],['24/7', app()->getLocale()==='ar'?'دعم':'Support']] as [$num,$label])
                        <div class="text-center">
                            <div class="font-display text-3xl sm:text-4xl font-extrabold text-white">{{ $num }}</div>
                            <div class="text-white/50 text-xs sm:text-sm mt-1">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Visual (hidden on mobile to keep hero compact) --}}
            <div class="w-full lg:w-1/2 flex justify-center order-1 lg:order-2 hidden lg:flex">
                <div class="hero-phone relative">
                    <div class="w-52 h-96 bg-white/10 border border-white/20 rounded-[3rem] backdrop-blur-sm flex items-center justify-center shadow-2xl">
                        <i class="fas fa-mobile-screen-button text-white/25" style="font-size:8rem"></i>
                    </div>
                    <div class="absolute -top-4 -right-6 bg-emerald-400 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">NEU</div>
                    <div class="absolute -bottom-3 -left-6 bg-white text-purple-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-lg">GEBRAUCHT</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave divider --}}
    <div class="wave-divider">
        <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0 48 C360 0 1080 0 1440 48 L1440 48 L0 48Z" fill="#F8F7FF"/>
        </svg>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- ABOUT                                                    --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section id="about" class="py-16 sm:py-20 bg-[#F8F7FF]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-purple-500 mb-2 block">
                @if(app()->getLocale()==='ar') من نحن @else Über uns @endif
            </span>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-gray-900">
                @if(app()->getLocale()==='ar') متجر يمكنك الوثوق به @else Ein Shop, dem Sie vertrauen können @endif
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php $aboutCards = [
                ['icon'=>'fa-star',         'color'=>'bg-purple-600', 'light'=>'bg-purple-50',
                 'title_ar'=>'جودة عالية',     'title_de'=>'Hohe Qualität',
                 'body_ar' =>'منتجات أصلية ومضمونة بأفضل المعايير',
                 'body_de' =>'Originale, garantierte Produkte nach höchsten Standards'],
                ['icon'=>'fa-headset',       'color'=>'bg-emerald-600','light'=>'bg-emerald-50',
                 'title_ar'=>'دعم مستمر',      'title_de'=>'24/7 Support',
                 'body_ar' =>'فريق الدعم جاهز دائماً لخدمتك',
                 'body_de' =>'Unser Team ist immer für Sie da'],
                ['icon'=>'fa-shield-halved', 'color'=>'bg-blue-600',   'light'=>'bg-blue-50',
                 'title_ar'=>'ضمان شامل',       'title_de'=>'Volle Garantie',
                 'body_ar' =>'ضمان على جميع خدماتنا ومنتجاتنا',
                 'body_de' =>'Garantie auf alle Produkte und Leistungen'],
            ]; @endphp

            @foreach($aboutCards as $c)
                <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 flex flex-col gap-4">
                    <div class="w-12 h-12 {{ $c['color'] }} rounded-xl flex items-center justify-center shadow">
                        <i class="fas {{ $c['icon'] }} text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 mb-1">
                            @if(app()->getLocale()==='ar') {{ $c['title_ar'] }} @else {{ $c['title_de'] }} @endif
                        </h3>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            @if(app()->getLocale()==='ar') {{ $c['body_ar'] }} @else {{ $c['body_de'] }} @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- SERVICES                                                 --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section id="services" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-purple-500 mb-2 block">
                @if(app()->getLocale()==='ar') ما نقدمه @else Was wir bieten @endif
            </span>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-gray-900">
                @if(app()->getLocale()==='ar') خدماتنا المتميزة @else Unsere Leistungen @endif
            </h2>
            <p class="text-gray-500 mt-3 text-sm sm:text-base max-w-xl mx-auto">
                @if(app()->getLocale()==='ar')
                    مجموعة شاملة من الخدمات الاحترافية لجميع احتياجاتك
                @else
                    Alles aus einer Hand – professionell und zuverlässig
                @endif
            </p>
        </div>

        @php
            $services = [
                ['icon'=>'fa-exchange-alt',         'bg'=>'bg-purple-600',
                 'title_ar'=>'بيع وشراء الجوالات',    'title_de'=>'Kauf & Verkauf',
                 'body_ar' =>'نشتري ونبيع الهواتف الجديدة والمستعملة بأفضل الأسعار',
                 'body_de' =>'Neue & gebrauchte Smartphones zu Top-Preisen'],
                ['icon'=>'fa-mobile-screen',        'bg'=>'bg-emerald-600',
                 'title_ar'=>'تصليح الشاشات',         'title_de'=>'Display-Reparatur',
                 'body_ar' =>'تبديل شاشات بجودة عالية وضمان شامل',
                 'body_de' =>'Hochwertige Displayreparatur mit Garantie'],
                ['icon'=>'fa-battery-three-quarters','bg'=>'bg-orange-500',
                 'title_ar'=>'تبديل البطاريات',        'title_de'=>'Akkuwechsel',
                 'body_ar' =>'بطاريات أصلية لجميع أنواع الهواتف',
                 'body_de' =>'Originalakkus für alle Handy-Modelle'],
                ['icon'=>'fa-code',                 'bg'=>'bg-blue-600',
                 'title_ar'=>'خدمات السوفت وير',       'title_de'=>'Software-Service',
                 'body_ar' =>'تحديث وإصلاح البرمجيات وحل مشاكل النظام',
                 'body_de' =>'Updates, Fehlerbehebung & Systemlösungen'],
                ['icon'=>'fa-shield-alt',           'bg'=>'bg-indigo-600',
                 'title_ar'=>'خدمة الضمان',             'title_de'=>'Garantie-Service',
                 'body_ar' =>'ضمان شامل على جميع خدماتنا ومنتجاتنا',
                 'body_de' =>'Vollständige Garantie auf alle Produkte & Leistungen'],
                ['icon'=>'fa-money-bill-transfer',  'bg'=>'bg-amber-500',
                 'title_ar'=>'تحويل الأموال',           'title_de'=>'Geldtransfer',
                 'body_ar' =>'خدمة تحويل الأموال عبر Western Union & Ria',
                 'body_de' =>'Geldtransfer via Western Union & Ria'],
                ['icon'=>'fa-box',                  'bg'=>'bg-rose-500',
                 'title_ar'=>'استلام وإرسال الطرود',   'title_de'=>'Paketservice',
                 'body_ar' =>'خدمة استلام وإرسال الطرود DPD & GLS',
                 'body_de' =>'Paketannahme & -versand über DPD & GLS'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($services as $s)
                <div class="service-card bg-gray-50 hover:bg-white rounded-2xl p-6 border border-gray-100 hover:border-gray-200 hover:shadow-lg cursor-default">
                    <div class="w-11 h-11 {{ $s['bg'] }} rounded-xl flex items-center justify-center mb-4 shadow-sm">
                        <i class="fas {{ $s['icon'] }} text-white"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1.5 text-base">
                        @if(app()->getLocale()==='ar') {{ $s['title_ar'] }} @else {{ $s['title_de'] }} @endif
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        @if(app()->getLocale()==='ar') {{ $s['body_ar'] }} @else {{ $s['body_de'] }} @endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- FEATURED / BESTSELLERS (Blade include — untouched)       --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@include('sections.featured-bestsellers-section')

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PRODUCTS — filter + search + grid                        --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section id="products" class="bg-[#F8F7FF] pt-14 pb-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <span class="text-xs font-bold uppercase tracking-widest text-purple-500 mb-2 block">
                @if(app()->getLocale()==='ar') تصفح @else Stöbern @endif
            </span>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-gray-900">
                @if(app()->getLocale()==='ar') منتجاتنا @else Unsere Produkte @endif
            </h2>
        </div>

        {{-- Category chips --}}
        <div class="flex flex-wrap gap-2 justify-center mb-6">
            <a href="{{ route('products.index') }}"
               class="chip chip-active px-4 py-2 rounded-full text-sm font-semibold border-2 transition
                      @if(!request('category')) chip-active @else chip @endif">
                <i class="fas fa-th-large me-1 text-xs"></i>
                @if(app()->getLocale()==='ar') الكل @else Alle @endif
            </a>
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->id]) }}#products-list"
                   class="px-4 py-2 rounded-full text-sm font-semibold border-2 transition
                      @if(request('category') == $category->id) chip-active @else chip @endif">
                    <i class="fas {{ $category->icon }} me-1 text-xs"></i>
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- Search bar --}}
        <form method="GET" action="{{ route('products.index') }}#products-list" class="max-w-xl mx-auto mb-10">
            <div class="flex gap-2">
                <label class="sr-only" for="search-input">
                    @if(app()->getLocale()==='ar') بحث @else Suche @endif
                </label>
                <div class="relative flex-1">
                    <i class="fas fa-search absolute {{ app()->getLocale()==='ar'?'right-4':'left-4' }} top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none"></i>
                    <input id="search-input" type="text" name="search" value="{{ request('search') }}"
                           placeholder="@if(app()->getLocale()==='ar') ابحث عن منتجك... @else Produkte suchen... @endif"
                           class="w-full {{ app()->getLocale()==='ar'?'pr-10 pl-4':'pl-10 pr-4' }} py-3.5 rounded-2xl border-2 border-gray-200 bg-white focus:border-purple-500 focus:outline-none text-sm transition">
                </div>
                <button type="submit"
                        class="px-5 py-3.5 rounded-2xl text-white font-bold text-sm shadow transition hover:opacity-90 active:scale-95"
                        style="background:linear-gradient(135deg,#7C3AED,#4C1D95)">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</section>

{{-- Products grid --}}
<section id="products-list" class="bg-[#F8F7FF] pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            @forelse($products as $product)
                <div class="product-card bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

                    {{-- Image area --}}
                    <div class="relative bg-gray-50 flex items-center justify-center aspect-square p-5">
                        @php
                            $imagePath = null;
                            foreach(['jpg','JPG','jpeg','png','webp'] as $ext){
                                if(file_exists(public_path("images/{$product->code}.{$ext}"))){
                                    $imagePath = "images/{$product->code}.{$ext}"; break;
                                }
                            }
                        @endphp
                        <img src="{{ $imagePath ? asset($imagePath) : asset('images/default.jpg') }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-contain" loading="lazy">

                        {{-- Condition badge --}}
                        <span class="absolute top-2.5 {{ app()->getLocale()==='ar'?'right-2.5':'left-2.5' }}
                                 text-[10px] font-bold px-2 py-0.5 rounded-full
                                 {{ $product->condition=='new' ? 'bg-emerald-500 text-white' : 'bg-orange-400 text-white' }}">
                        @if(app()->getLocale()==='ar')
                                {{ $product->condition=='new'?'جديد':'مستعمل' }}
                            @else
                                {{ $product->condition=='new'?'NEU':'GEBR.' }}
                            @endif
                    </span>
                    </div>

                    {{-- Info --}}
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 leading-snug mb-2">
                            {{ $product->name }}
                        </h3>

                        {{-- Price --}}
                        <div class="flex items-baseline gap-2 mb-3">
                            @if($product->old_price)
                                <span class="text-xs text-gray-400 line-through">{{ number_format($product->old_price,2) }}€</span>
                            @endif
                            <span class="text-lg font-extrabold" style="color:var(--brand)">
                            {{ number_format($product->price,2) }}€
                        </span>
                        </div>

                        {{-- Actions --}}
                        <div class="flex gap-2">
                            {{-- View details --}}
                            <a href="{{ request()->fullUrlWithQuery(['show_id'=>$product->id]) }}#products-list"
                               class="flex-1 flex items-center justify-center gap-1.5 text-xs font-bold py-2.5 rounded-xl border-2 border-purple-600 text-purple-600 hover:bg-purple-600 hover:text-white transition">
                                <i class="fas fa-eye text-xs"></i>
                                @if(app()->getLocale()==='ar') عرض @else Ansehen @endif
                            </a>

                            {{-- WhatsApp --}}
                            <a href="{{ $product->whatsapp_link }}" target="_blank"
                               class="wa-btn flex items-center justify-center w-10 h-10 rounded-xl text-white shadow-sm shrink-0">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-3xl text-gray-300"></i>
                    </div>
                    <p class="font-semibold text-gray-500 text-lg">
                        @if(app()->getLocale()==='ar') لا توجد منتجات @else Keine Produkte gefunden @endif
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- CONTACT / MAP                                            --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section id="kontakt" class="py-16 sm:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-purple-500 mb-2 block">
                @if(app()->getLocale()==='ar') زورونا @else Besuchen Sie uns @endif
            </span>
            <h2 class="font-display text-3xl sm:text-4xl font-extrabold text-gray-900">
                @if(app()->getLocale()==='ar') موقعنا @else Unser Standort @endif
            </h2>
            <p class="text-gray-500 mt-2 text-sm sm:text-base">
                @if(app()->getLocale()==='ar') قم بزيارتنا في متجرنا في كيل @else Besuchen Sie uns in unserem Geschäft in Kiel @endif
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 items-start">

            {{-- Info card --}}
            <div class="bg-[#F8F7FF] rounded-2xl p-7 space-y-6 border border-gray-100">
                @php $contactRows = [
                    ['icon'=>'fa-map-marker-alt','bg'=>'bg-purple-100','ic'=>'text-purple-600',
                     'title_ar'=>'العنوان','title_de'=>'Adresse',
                     'lines'=>['Julius-Fürst-Weg 8','24159 Kiel','Deutschland']],
                    ['icon'=>'fa-clock','bg'=>'bg-blue-100','ic'=>'text-blue-600',
                     'title_ar'=>'ساعات العمل','title_de'=>'Öffnungszeiten',
                     'lines'=>[app()->getLocale()==='ar'?'الإثنين - الجمعة: 9:00 - 18:00':'Montag - Freitag: 9:00 - 18:00',
                               app()->getLocale()==='ar'?'السبت: 10:00 - 14:00':'Samstag: 10:00 - 14:00']],
                    ['icon'=>'fa-phone','bg'=>'bg-emerald-100','ic'=>'text-emerald-600',
                     'title_ar'=>'اتصل بنا','title_de'=>'Kontakt',
                     'lines'   =>['+49 163 361 7202','info@phone2go.de']],
                ]; @endphp

                @foreach($contactRows as $row)
                    <div class="flex items-start gap-4">
                        <div class="{{ $row['bg'] }} w-11 h-11 rounded-xl flex items-center justify-center shrink-0">
                            <i class="fas {{ $row['icon'] }} {{ $row['ic'] }}"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1 text-sm">
                                @if(app()->getLocale()==='ar') {{ $row['title_ar'] }} @else {{ $row['title_de'] }} @endif
                            </h3>
                            @foreach($row['lines'] as $line)
                                <p class="text-gray-500 text-sm">{{ $line }}</p>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <a href="https://www.google.com/maps/dir/?api=1&destination=Julius-Fürst-Weg+8,+24159+Kiel,+Deutschland"
                   target="_blank"
                   class="flex items-center justify-center gap-2 text-white text-sm font-bold py-3.5 rounded-2xl shadow transition hover:opacity-90 active:scale-[.98] w-full"
                   style="background:linear-gradient(135deg,#7C3AED,#4C1D95)">
                    <i class="fas fa-directions"></i>
                    @if(app()->getLocale()==='ar') احصل على الاتجاهات @else Route anzeigen @endif
                </a>
            </div>

            {{-- Map --}}
            <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2318.4!2d10.1394!3d54.3233!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTTCsDE5JzI0LjAiTiAxMMKwMDgnMjEuOCJF!5e0!3m2!1sen!2sde!4v1234567890"
                    width="100%" height="380"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-[380px]">
                </iframe>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PRODUCT MODAL (bottom-sheet on mobile)                   --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@if(request()->has('show_id'))
    @php $popupProduct = \App\Models\Product::find(request('show_id')); @endphp
    @if($popupProduct)
        <div class="fixed inset-0 z-[100] flex items-end md:items-center justify-center bg-black/60 backdrop-blur-sm"
             id="product-modal-overlay">
            <div id="product-modal-inner"
                 class="bg-white w-full max-w-3xl md:rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row">

                {{-- Close --}}
                <a href="{{ request()->fullUrlWithQuery(['show_id'=>null]) }}#products-list"
                   class="absolute top-3 {{ app()->getLocale()==='ar'?'left-3':'right-3' }} z-10
                      w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center transition"
                   aria-label="Schließen">
                    <i class="fas fa-times text-gray-600 text-sm"></i>
                </a>

                {{-- Image --}}
                <div class="md:w-1/2 bg-gray-50 flex items-center justify-center p-8 min-h-[220px] md:min-h-[340px]">
                    <img src="{{ asset('images/'.$popupProduct->code.'.jpg') }}"
                         class="max-h-64 md:max-h-80 object-contain drop-shadow-lg"
                         onerror="this.src='{{ asset('images/default.jpg') }}'">
                </div>

                {{-- Details --}}
                <div class="md:w-1/2 p-6 md:p-8 flex flex-col justify-center scrollbar-thin"
                     dir="{{ app()->getLocale()==='ar'?'rtl':'ltr' }}">

                <span class="inline-block text-xs font-bold px-2.5 py-1 rounded-full mb-3 w-fit
                             {{ $popupProduct->condition=='new'?'bg-emerald-100 text-emerald-700':'bg-orange-100 text-orange-700' }}">
                    @if(app()->getLocale()==='ar')
                        {{ $popupProduct->condition=='new'?'جديد':'مستعمل' }}
                    @else
                        {{ $popupProduct->condition=='new'?'NEU':'GEBRAUCHT' }}
                    @endif
                </span>

                    <h2 class="font-display text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 leading-tight">
                        {{ $popupProduct->name }}
                    </h2>

                    <div class="flex items-baseline gap-3 mb-4">
                    <span class="text-3xl font-extrabold" style="color:var(--brand)">
                        {{ number_format($popupProduct->price,2) }}€
                    </span>
                        @if($popupProduct->old_price)
                            <span class="text-gray-400 line-through text-base">
                        {{ number_format($popupProduct->old_price,2) }}€
                    </span>
                        @endif
                    </div>

                    <p class="text-gray-500 text-sm leading-relaxed mb-6 max-h-32 overflow-y-auto scrollbar-thin">
                        {{ $popupProduct->description }}
                    </p>

                    <a href="{{ $popupProduct->whatsapp_link }}" target="_blank"
                       class="wa-btn flex items-center justify-center gap-2 text-white font-bold py-4 rounded-2xl text-base shadow-lg w-full">
                        <i class="fab fa-whatsapp text-xl"></i>
                        @if(app()->getLocale()==='ar') اطلب عبر واتساب @else Jetzt bestellen @endif
                    </a>
                </div>
            </div>
        </div>
    @endif
@endif

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- FOOTER                                                   --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<footer class="bg-gray-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-10">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow"
                         style="background:linear-gradient(135deg,#7C3AED,#4C1D95)">
                        <i class="fas fa-mobile-alt text-white text-base"></i>
                    </div>
                    <span class="font-display font-extrabold text-xl">PHONE2GO</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    @if(app()->getLocale()==='ar')
                        متجركم الموثوق للهواتف الذكية والإكسسوارات في كيل
                    @else
                        Ihr vertrauenswürdiger Shop für Smartphones & Zubehör in Kiel
                    @endif
                </p>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-bold text-sm text-gray-300 uppercase tracking-wider mb-4">
                    @if(app()->getLocale()==='ar') تواصل معنا @else Kontakt @endif
                </h4>
                <div class="space-y-2.5 text-gray-400 text-sm">
                    <a href="tel:+491633617202" class="flex items-center gap-2 hover:text-white transition">
                        <i class="fas fa-phone w-4 text-center text-purple-400"></i> +49 163 361 7202
                    </a>
                    <p class="flex items-center gap-2">
                        <i class="fas fa-envelope w-4 text-center text-purple-400"></i> info@phone2go.de
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt w-4 text-center text-purple-400"></i> Julius-Fürst-Weg 8, Kiel
                    </p>
                </div>
            </div>

            {{-- Social --}}
            <div>
                <h4 class="font-bold text-sm text-gray-300 uppercase tracking-wider mb-4">
                    @if(app()->getLocale()==='ar') تابعنا @else Folgen Sie uns @endif
                </h4>
                <div class="flex gap-3">
                    <a href="#" aria-label="Facebook"
                       class="w-10 h-10 bg-gray-800 hover:bg-blue-600 rounded-xl flex items-center justify-center transition">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" aria-label="Instagram"
                       class="w-10 h-10 bg-gray-800 hover:bg-pink-600 rounded-xl flex items-center justify-center transition">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="https://wa.me/491633617202" target="_blank" aria-label="WhatsApp"
                       class="w-10 h-10 bg-gray-800 hover:bg-green-600 rounded-xl flex items-center justify-center transition">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-6 text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} PHONE2GO.
            @if(app()->getLocale()==='ar') جميع الحقوق محفوظة @else Alle Rechte vorbehalten @endif
        </div>
    </div>
</footer>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- SCRIPTS                                                  --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<script>
    (function(){
        /* ── Mobile menu toggle ── */
        const btn  = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('hamburger-icon');

        btn.addEventListener('click', () => {
            const open = menu.classList.toggle('open');
            icon.className = open ? 'fas fa-times text-lg' : 'fas fa-bars text-lg';
            btn.setAttribute('aria-expanded', open);
        });

        /* Close menu when a link is tapped */
        document.querySelectorAll('.mobile-link').forEach(a => {
            a.addEventListener('click', () => {
                menu.classList.remove('open');
                icon.className = 'fas fa-bars text-lg';
                btn.setAttribute('aria-expanded', 'false');
            });
        });

        /* ── Smooth scroll ── */
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e){
                const id = this.getAttribute('href').split('?')[0];
                if(id === '#') return;
                const target = document.querySelector(id);
                if(target){
                    e.preventDefault();
                    target.scrollIntoView({ behavior:'smooth', block:'start' });
                }
            });
        });

        /* ── Close modal on overlay click ── */
        const overlay = document.getElementById('product-modal-overlay');
        const inner   = document.getElementById('product-modal-inner');
        if(overlay && inner){
            overlay.addEventListener('click', e => {
                if(!inner.contains(e.target)){
                    window.location.href = window.location.href.replace(/[?&]show_id=[^&]*/,'') + '#products-list';
                }
            });
        }

        /* ── Active nav on scroll (Intersection Observer) ── */
        const sections = document.querySelectorAll('section[id]');
        const navLinks  = document.querySelectorAll('.nav-link');
        const observer  = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    navLinks.forEach(l => {
                        l.classList.toggle('text-purple-700', l.getAttribute('href') === '#' + entry.target.id);
                    });
                }
            });
        }, { threshold: 0.3 });
        sections.forEach(s => observer.observe(s));
    })();
</script>

</body>
</html>
