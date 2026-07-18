<x-website-layout title="Produk UMKM">
    <section class="py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading title="Produk UMKM / Oleh-oleh" description="Produk lokal dari warga Desa Sumberbrantas." />
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($products as $product)
                    <a href="{{ route('produk.show', $product) }}" class="overflow-hidden rounded-lg border border-stone-200 bg-white hover:shadow-md">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                        <div class="p-5">
                            <h2 class="font-bold">{{ $product->name }}</h2>
                            <p class="mt-2 text-sm text-stone-600">Stok {{ $product->stock }}</p>
                            <p class="mt-3 font-semibold text-emerald-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-10">{{ $products->links() }}</div>
        </div>
    </section>
</x-website-layout>
