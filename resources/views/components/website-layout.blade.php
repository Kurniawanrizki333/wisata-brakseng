@props(['title' => 'Desa Wisata Sumberbrantas'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-stone-50 text-stone-900 antialiased">
    <header class="sticky top-0 z-40 border-b border-stone-200 bg-white/95 backdrop-blur">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="font-bold tracking-wide text-emerald-800">Sumberbrantas</a>
            <div class="hidden items-center gap-5 text-sm font-medium text-stone-700 md:flex">
                <a class="hover:text-emerald-700" href="{{ route('destinasi.index') }}">Destinasi</a>
                <a class="hover:text-emerald-700" href="{{ route('paket-wisata.index') }}">Paket</a>
                <a class="hover:text-emerald-700" href="{{ route('reservations.create') }}">Reservasi</a>
                <a class="hover:text-emerald-700" href="{{ route('map') }}">Peta</a>
                <a class="hover:text-emerald-700" href="{{ route('produk.index') }}">UMKM</a>
                <a class="hover:text-emerald-700" href="{{ route('event.index') }}">Event</a>
                <a class="hover:text-emerald-700" href="{{ route('galeri.index') }}">Galeri</a>
                <a class="hover:text-emerald-700" href="{{ route('contact.index') }}">Kontak</a>
            </div>
            <a href="{{ route('reservations.create') }}" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Reservasi</a>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="border-t border-stone-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <p class="font-bold text-emerald-800">Desa Wisata Sumberbrantas</p>
                <p class="mt-3 text-sm leading-6 text-stone-600">Wisata alam, edukasi pertanian, event desa, dan produk UMKM lokal di kawasan hulu Brantas.</p>
            </div>
            <div class="text-sm text-stone-600">
                <p class="font-semibold text-stone-900">Navigasi</p>
                <div class="mt-3 grid gap-2">
                    <a href="{{ route('destinasi.index') }}">Destinasi Wisata</a>
                    <a href="{{ route('paket-wisata.index') }}">Paket Wisata</a>
                    <a href="{{ route('produk.index') }}">Produk UMKM</a>
                    <a href="{{ route('contact.index') }}">Kontak</a>
                </div>
            </div>
            <div class="text-sm text-stone-600">
                <p class="font-semibold text-stone-900">Admin</p>
                <a class="mt-3 inline-block hover:text-emerald-700" href="/admin">Masuk Admin Panel</a>
            </div>
        </div>
    </footer>
</body>
</html>
