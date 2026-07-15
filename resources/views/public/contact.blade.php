@extends('layouts.public')

@section('title', $pageTitle . ' | ME FOR YOU')

@section('content')
<!-- Hero Section -->
<section class="relative bg-[#1a1714] text-white py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#b87f3a] rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#b87f3a] rounded-full blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-4">Contact</p>
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-semibold leading-[1.1] mb-4">
                Let's Talk
            </h1>
            <p class="text-lg text-white/60 max-w-2xl leading-relaxed">
                Reach out for housing, transport, or event enquiries   we usually respond within a day.
            </p>
        </div>
    </div>
</section>

<!-- Add this after the hero section or before the form -->
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

<!-- Contact Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
            <!-- Contact Form -->
            <div class="bg-[#f5f0e8] rounded-xl p-8 border border-[#ede7d8]">
                <h2 class="font-display text-2xl font-semibold text-[#1a1714] mb-6">Send Us a Message</h2>
                
                <form method="POST" action="{{ route('contact') }}" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-[#1a1714] mb-1.5">Full Name <span class="text-[#b87f3a]">*</span></label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2.5 bg-white border border-[#ede7d8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b87f3a]/20 focus:border-[#b87f3a] transition-colors @error('name') border-red-500 @enderror"
                            placeholder="Your full name"
                            required
                        >
                        @error('name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#1a1714] mb-1.5">Email Address <span class="text-[#b87f3a]">*</span></label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2.5 bg-white border border-[#ede7d8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b87f3a]/20 focus:border-[#b87f3a] transition-colors @error('email') border-red-500 @enderror"
                            placeholder="your@email.com"
                            required
                        >
                        @error('email')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-[#1a1714] mb-1.5">Phone Number <span class="text-[#7a7268] text-xs">(optional)</span></label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}"
                            class="w-full px-4 py-2.5 bg-white border border-[#ede7d8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b87f3a]/20 focus:border-[#b87f3a] transition-colors @error('phone') border-red-500 @enderror"
                            placeholder="+250 788 202 209"
                        >
                        @error('phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-[#1a1714] mb-1.5">Subject <span class="text-[#7a7268] text-xs">(optional)</span></label>
                        <select 
                            id="subject" 
                            name="subject" 
                            class="w-full px-4 py-2.5 bg-white border border-[#ede7d8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b87f3a]/20 focus:border-[#b87f3a] transition-colors @error('subject') border-red-500 @enderror"
                        >
                            <option value="">Select a subject</option>
                            <option value="housing" {{ old('subject') == 'housing' ? 'selected' : '' }}>Housing Enquiry</option>
                            <option value="events" {{ old('subject') == 'events' ? 'selected' : '' }}>Event Management</option>
                            <option value="transport" {{ old('subject') == 'transport' ? 'selected' : '' }}>Transport Services</option>
                            <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Enquiry</option>
                            <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partnership / Collaboration</option>
                        </select>
                        @error('subject')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-[#1a1714] mb-1.5">Message <span class="text-[#b87f3a]">*</span></label>
                        <textarea 
                            id="message" 
                            name="message" 
                            rows="5" 
                            class="w-full px-4 py-2.5 bg-white border border-[#ede7d8] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#b87f3a]/20 focus:border-[#b87f3a] transition-colors @error('message') border-red-500 @enderror"
                            placeholder="Tell us how we can help you..."
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-[#b87f3a] hover:bg-[#8a6e22] text-white font-semibold px-6 py-3 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-6">
                <div>
                    <h2 class="font-display text-2xl font-semibold text-[#1a1714] mb-6">Get in Touch</h2>
                    <p class="text-[#7a7268] leading-relaxed mb-8">
                        We'd love to hear from you. Whether you have a question about our services, 
                        need a quote, or want to discuss a project, we're here to help.
                    </p>
                </div>

                <!-- Contact Cards -->
                <div class="space-y-4">
                    <!-- Office -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8] hover:border-[#b87f3a] transition-colors group">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0 group-hover:bg-[#b87f3a]/20 transition-colors">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-1">Office</h3>
                                <p class="text-[#7a7268]">Kigali, Rwanda</p>
                                <a href="https://www.google.com/maps/search/Kigali+Rwanda" target="_blank" class="text-[#b87f3a] text-sm font-semibold hover:underline inline-flex items-center gap-1 mt-1">
                                    View on Maps <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8] hover:border-[#b87f3a] transition-colors group">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0 group-hover:bg-[#b87f3a]/20 transition-colors">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-1">Email</h3>
                                <a href="mailto:info@me-for-you.org" class="text-[#b87f3a] hover:underline font-medium">info@me-for-you.org</a>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8] hover:border-[#b87f3a] transition-colors group">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-[#b87f3a]/10 rounded-lg flex items-center justify-center text-[#b87f3a] flex-shrink-0 group-hover:bg-[#b87f3a]/20 transition-colors">
                                <i class="fas fa-phone text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-1">Phone</h3>
                                <a href="tel:+250788202209" class="text-[#b87f3a] hover:underline font-medium">+250 788 202 209</a>
                                <p class="text-xs text-[#7a7268] mt-0.5">Available 8:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8] hover:border-[#25D366] transition-colors group">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-[#25D366]/10 rounded-lg flex items-center justify-center text-[#25D366] flex-shrink-0 group-hover:bg-[#25D366]/20 transition-colors">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-1">WhatsApp</h3>
                                <a href="https://wa.me/+250788202209" target="_blank" class="text-[#25D366] hover:underline font-medium">Chat with us</a>
                                <p class="text-xs text-[#7a7268] mt-0.5">Quick responses via WhatsApp</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-[#f5f0e8] rounded-xl p-6 border border-[#ede7d8]">
                    <h3 class="font-display text-lg font-semibold text-[#1a1714] mb-4">Follow Us</h3>
                    <div class="flex gap-3">
                        <a href="https://www.instagram.com/meforyou_rw/" target="_blank" class="w-10 h-10 bg-[#1a1714] text-white rounded-full flex items-center justify-center hover:bg-[#b87f3a] transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-[#1a1714] text-white rounded-full flex items-center justify-center hover:bg-[#b87f3a] transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-[#1a1714] text-white rounded-full flex items-center justify-center hover:bg-[#b87f3a] transition-colors">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="#" target="_blank" class="w-10 h-10 bg-[#1a1714] text-white rounded-full flex items-center justify-center hover:bg-[#b87f3a] transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-0 bg-[#f5f0e8]">
    <div class="container mx-auto px-4">
        <div class="rounded-xl overflow-hidden h-80 border border-[#ede7d8]">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255138.8921732598!2d29.956094349999998!3d-1.95311995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca4258ed8e797%3A0xf33d2d8f4e7c1b3!2sKigali%2C%20Rwanda!5e0!3m2!1sen!2s!4v1700000000000" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                class="hover:opacity-90 transition-opacity"
            ></iframe>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-[#b87f3a]">
    <div class="container mx-auto px-4 text-center text-white">
        <h2 class="font-display text-3xl md:text-4xl font-semibold mb-4">Prefer to Talk in Person?</h2>
        <p class="text-lg text-white/80 mb-8 max-w-2xl mx-auto leading-relaxed">
            We're always happy to meet and discuss how we can help you with your housing, event, or transport needs.
        </p>
        <a href="https://wa.me/+250788202209" target="_blank" class="inline-flex items-center gap-2 bg-white text-[#8a6e22] font-semibold px-8 py-3 rounded-lg hover:bg-[#f5f0e8] transition-colors">
            <i class="fab fa-whatsapp"></i> Chat on WhatsApp
        </a>
    </div>
</section>
@endsection