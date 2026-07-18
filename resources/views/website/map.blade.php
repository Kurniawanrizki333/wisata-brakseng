<x-website-layout title="Peta Wisata">
    <section class="py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-heading title="Peta Wisata" description="Lihat posisi destinasi wisata di Desa Sumberbrantas." />
            @if ($googleMapsEmbed)
                <iframe class="mt-10 h-[420px] w-full rounded-lg border border-stone-200" src="{{ $googleMapsEmbed }}" loading="lazy"></iframe>
            @endif
            <div class="mt-10 grid gap-4 md:grid-cols-3">
                @foreach ($destinations as $destination)
                    <a href="{{ route('destinasi.show', $destination) }}" class="rounded-lg border border-stone-200 bg-white p-5 hover:shadow-md">
                        <h2 class="font-bold">{{ $destination->name }}</h2>
                        <p class="mt-2 text-sm text-stone-600">{{ $destination->address }}</p>
                        <p class="mt-3 text-xs text-stone-500">{{ $destination->latitude }}, {{ $destination->longitude }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</x-website-layout>
