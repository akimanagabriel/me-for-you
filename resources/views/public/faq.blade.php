@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<section class="bg-neutral text-neutral-content pt-32 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <p class="section-label !text-accent">FAQ</p>
        <h1 class="font-display text-4xl sm:text-5xl font-semibold">Frequently asked questions</h1>
    </div>
</section>

<section class="py-16 px-6">
    <div class="max-w-[800px] mx-auto space-y-3">
        @foreach ($faqs as $faq)
            <div class="collapse collapse-plus bg-base-100 border border-base-300 rounded-box">
                <input type="radio" name="faq-accordion" {{ $loop->first ? 'checked' : '' }} />
                <div class="collapse-title font-display text-lg font-semibold">{{ $faq['question'] }}</div>
                <div class="collapse-content text-sm text-base-content/70">
                    <p>{{ $faq['answer'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
