<x-website-layout title="Kontak">
    <section class="py-14">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[420px_1fr] lg:px-8">
            <div>
                <x-section-heading title="Kontak" description="Hubungi pengelola Desa Wisata Sumberbrantas." />
                <dl class="mt-8 grid gap-5 rounded-lg border border-stone-200 bg-white p-6 text-sm">
                    <div>
                        <dt class="font-semibold">Alamat</dt>
                        <dd class="mt-1 text-stone-600">{{ $address }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold">Nomor Telepon</dt>
                        <dd class="mt-1 text-stone-600">{{ $phone }}</dd>
                    </div>
                    <div>
                        <dt class="font-semibold">Email</dt>
                        <dd class="mt-1 text-stone-600">{{ $email }}</dd>
                    </div>
                </dl>
                @if ($googleMapsEmbed)
                    <iframe class="mt-6 aspect-video w-full rounded-lg border border-stone-200" src="{{ $googleMapsEmbed }}" loading="lazy"></iframe>
                @endif
            </div>
            <div>
                @if (session('success'))
                    <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">{{ session('success') }}</div>
                @endif
                <form method="POST" action="{{ route('contact.store') }}" class="grid gap-5 rounded-lg border border-stone-200 bg-white p-6">
                    @csrf
                    <div class="grid gap-5 md:grid-cols-2">
                        <label class="grid gap-2">
                            <span class="text-sm font-semibold">Nama</span>
                            <input name="name" value="{{ old('name') }}" class="rounded-md border-stone-300" required>
                            @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </label>
                        <label class="grid gap-2">
                            <span class="text-sm font-semibold">Email</span>
                            <input type="email" name="email" value="{{ old('email') }}" class="rounded-md border-stone-300">
                            @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </label>
                    </div>
                    <label class="grid gap-2">
                        <span class="text-sm font-semibold">Telepon</span>
                        <input name="phone" value="{{ old('phone') }}" class="rounded-md border-stone-300">
                        @error('phone') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>
                    <label class="grid gap-2">
                        <span class="text-sm font-semibold">Subjek</span>
                        <input name="subject" value="{{ old('subject') }}" class="rounded-md border-stone-300">
                        @error('subject') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>
                    <label class="grid gap-2">
                        <span class="text-sm font-semibold">Kritik dan Saran</span>
                        <textarea name="message" rows="7" class="rounded-md border-stone-300" required>{{ old('message') }}</textarea>
                        @error('message') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    </label>
                    <button class="rounded-md bg-emerald-700 px-5 py-3 font-semibold text-white hover:bg-emerald-800">Kirim</button>
                </form>
            </div>
        </div>
    </section>
</x-website-layout>
