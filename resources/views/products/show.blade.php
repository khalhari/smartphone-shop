<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name_de }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        @if($product->images && $product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="w-full rounded-lg shadow-md" alt="{{ $product->name_de }}">
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-lg">
                                <span class="text-gray-500">Kein Bild verfügbar</span>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h1 class="text-3xl font-bold mb-4">{{ $product->name_de }}</h1>
                        <p class="text-gray-600 mb-6 text-lg">{{ $product->description_de }}</p>
                        <div class="text-2xl font-semibold text-indigo-600 mb-8">
                            {{ number_format($product->price, 2) }} €
                        </div>

                        <hr class="my-6">

                        @php
                            $whatsappNumber = config('settings.whatsapp_number') ?? env('WHATSAPP_NUMBER', '491633617202');
                            $currentUrl = request()->fullUrl();
                            $germanMessage = "Hallo, ich interessiere mich für dieses Produkt: " . $product->name_de . ". Hier ist der Link: " . $currentUrl;
                            $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($germanMessage);
                        @endphp


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
