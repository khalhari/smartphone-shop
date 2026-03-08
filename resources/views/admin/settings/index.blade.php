<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 tracking-tight">⚙️ إعدادات النظام</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto py-12">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-r-4 border-green-500 text-green-700 rounded-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white border border-gray-100 shadow-2xl shadow-gray-200/50 rounded-3xl overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="space-y-8">

                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <span class="bg-indigo-100 p-2 rounded-lg mr-3">📱</span>
                                    قنوات التواصل
                                </h3>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-600 mb-2">رقم الواتساب (الصيغة الدولية)</label>
                                        <input type="text" name="whatsapp_number"
                                               value="{{ $settings['whatsapp_number'] ?? '' }}"
                                               placeholder="491633617202"
                                               class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-200 transition-all shadow-sm">
                                        <p class="mt-2 text-xs text-gray-400">هذا الرقم سيظهر للزبائن عند الضغط على زر "Auf WhatsApp anfragen".</p>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-50">

                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    حفظ كافة التغييرات
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
