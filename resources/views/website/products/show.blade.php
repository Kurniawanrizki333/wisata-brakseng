<x-website-layout :title="$product->name">
    <article class="py-10">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-[420px] w-full rounded-lg object-cover">
            <div>
                <h1 class="text-4xl font-bold">{{ $product->name }}</h1>
                <p class="mt-4 text-3xl font-bold text-emerald-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="mt-3 text-stone-600">Stok tersedia: {{ $product->stock }}</p>
                <p class="mt-8 whitespace-pre-line leading-8 text-stone-700">{{ $product->description }}</p>
                @if ($product->whatsapp_url)
                    <a href="{{ $product->whatsapp_url }}" target="_blank" class="mt-8 inline-flex rounded-md bg-emerald-700 px-5 py-3 font-semibold text-white hover:bg-emerald-800">Pesan via WhatsApp</a>
                @endif
            </div>
        </div>
    </article>
</x-website-layout>
