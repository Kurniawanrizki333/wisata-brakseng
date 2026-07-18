@props(['eyebrow' => null, 'title', 'description' => null])

<div class="mx-auto max-w-3xl text-center">
    @if ($eyebrow)
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">{{ $eyebrow }}</p>
    @endif
    <h2 class="mt-2 text-3xl font-bold text-stone-950 sm:text-4xl">{{ $title }}</h2>
    @if ($description)
        <p class="mt-4 leading-7 text-stone-600">{{ $description }}</p>
    @endif
</div>
