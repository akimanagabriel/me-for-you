@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<section class="bg-neutral text-neutral-content pt-32 pb-16 px-6">
    <div class="max-w-[1200px] mx-auto">
        <p class="section-label !text-accent">Contact</p>
        <h1 class="font-display text-4xl sm:text-5xl font-semibold">Let's talk</h1>
        <p class="text-neutral-content/70 max-w-[540px] mt-3">Reach out for housing, transport, or event enquiries — we usually respond within a day.</p>
    </div>
</section>

<section class="py-16 px-6">
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">
        <x-ui.card>
            <form method="POST" action="{{ route('contact') }}" class="space-y-4">
                @csrf
                <x-ui.input label="Full Name" name="name" required />
                <x-ui.input label="Email Address" name="email" type="email" required />
                <x-ui.input label="Phone Number" name="phone" type="tel" />
                <div class="form-control w-full">
                    <label class="label"><span class="label-text font-medium">Message</span></label>
                    <textarea name="message" rows="5" class="textarea textarea-bordered w-full" required></textarea>
                </div>
                <x-ui.button type="submit" class="w-full">Send Message</x-ui.button>
            </form>
        </x-ui.card>

        <div class="space-y-6">
            <x-ui.card>
                <h3 class="font-display text-xl font-semibold mb-2">Office</h3>
                <p class="text-sm text-base-content/70">Kigali, Rwanda</p>
            </x-ui.card>
            <x-ui.card>
                <h3 class="font-display text-xl font-semibold mb-2">Email</h3>
                <p class="text-sm text-base-content/70">info@me-for-you.org</p>
            </x-ui.card>
            <x-ui.card>
                <h3 class="font-display text-xl font-semibold mb-2">Phone</h3>
                <p class="text-sm text-base-content/70">+250 7XX XXX XXX</p>
            </x-ui.card>
        </div>
    </div>
</section>
@endsection
