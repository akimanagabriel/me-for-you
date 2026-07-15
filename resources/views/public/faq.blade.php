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
            <p class="text-[#b87f3a] text-sm font-semibold uppercase tracking-[0.2em] mb-4">FAQ</p>
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-semibold leading-[1.1] mb-4">
                Frequently Asked <br /><span class="text-[#d49d6a]">Questions</span>
            </h1>
            <p class="text-lg text-white/60 max-w-2xl leading-relaxed">
                Find answers to the most common questions about our housing, event management, and transport services.
            </p>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Search Bar -->
            <div class="mb-10">
                <div class="relative">
                    <input 
                        type="text" 
                        id="faqSearch" 
                        placeholder="Search for answers..." 
                        class="w-full px-5 py-3 pl-12 bg-[#f5f0e8] border border-[#ede7d8] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#b87f3a]/20 focus:border-[#b87f3a] transition-colors text-[#1a1714] placeholder:text-[#7a7268]/60"
                    >
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-[#7a7268]"></i>
                    <button id="clearSearch" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#7a7268] hover:text-[#b87f3a] transition-colors hidden">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <p class="text-xs text-[#7a7268] mt-2">
                    <span id="resultCount">{{ count($faqs) }}</span> questions available
                </p>
            </div>

            <!-- FAQ Accordion -->
            <div class="space-y-3" id="faqContainer">
                @foreach ($faqs as $index => $faq)
                    <div class="faq-item bg-[#f5f0e8] rounded-xl border border-[#ede7d8] overflow-hidden transition-all duration-300 hover:border-[#b87f3a]/50" data-question="{{ strtolower($faq['question']) }}" data-answer="{{ strtolower($faq['answer']) }}">
                        <button 
                            class="w-full px-6 py-4 text-left flex items-center justify-between group focus:outline-none"
                            onclick="toggleFaq(this)"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        >
                            <span class="font-display text-lg font-semibold text-[#1a1714] group-hover:text-[#b87f3a] transition-colors">
                                {{ $faq['question'] }}
                            </span>
                            <span class="flex-shrink-0 ml-4 text-[#b87f3a] transition-transform duration-300 {{ $loop->first ? 'rotate-180' : '' }}">
                                <i class="fas fa-chevron-down"></i>
                            </span>
                        </button>
                        <div class="faq-answer px-6 overflow-hidden transition-all duration-300 ease-in-out" style="max-height: {{ $loop->first ? '200px' : '0' }}; padding-bottom: {{ $loop->first ? '20px' : '0' }};">
                            <p class="text-[#7a7268] leading-relaxed border-t border-[#ede7d8] pt-4">
                                {{ $faq['answer'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="hidden text-center py-12">
                <div class="w-20 h-20 bg-[#f5f0e8] rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-3xl text-[#b87f3a]/40"></i>
                </div>
                <h3 class="font-display text-xl font-semibold text-[#1a1714] mb-2">No results found</h3>
                <p class="text-[#7a7268]">Try adjusting your search term or browse the questions above.</p>
                <button onclick="clearSearch()" class="mt-4 text-[#b87f3a] font-semibold hover:underline">Clear search</button>
            </div>
        </div>
    </div>
</section>

<!-- Still Have Questions? -->
<section class="py-20 bg-[#f5f0e8]">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-2xl mx-auto">
            <div class="w-16 h-16 bg-[#b87f3a]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-comment-dots text-[#b87f3a] text-2xl"></i>
            </div>
            <h2 class="font-display text-3xl md:text-4xl font-semibold text-[#1a1714] mb-4">Still Have Questions?</h2>
            <p class="text-[#7a7268] leading-relaxed mb-8">
                Can't find the answer you're looking for? We're here to help. Contact our team and we'll get back to you within 24 hours.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-[#b87f3a] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#8a6e22] transition-colors">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
                <a href="https://wa.me/+250788202209" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#1da851] transition-colors">
                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Toggle FAQ accordion
    function toggleFaq(button) {
        const item = button.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const icon = button.querySelector('.fa-chevron-down');
        const isOpen = answer.style.maxHeight !== '0px' && answer.style.maxHeight !== '0';
        
        // Close all other open FAQs
        document.querySelectorAll('.faq-item').forEach(otherItem => {
            if (otherItem !== item) {
                const otherAnswer = otherItem.querySelector('.faq-answer');
                const otherIcon = otherItem.querySelector('.fa-chevron-down');
                otherAnswer.style.maxHeight = '0';
                otherAnswer.style.paddingBottom = '0';
                otherIcon.classList.remove('rotate-180');
                otherItem.querySelector('button').setAttribute('aria-expanded', 'false');
            }
        });
        
        // Toggle current FAQ
        if (isOpen) {
            answer.style.maxHeight = '0';
            answer.style.paddingBottom = '0';
            icon.classList.remove('rotate-180');
            button.setAttribute('aria-expanded', 'false');
        } else {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            answer.style.paddingBottom = '20px';
            icon.classList.add('rotate-180');
            button.setAttribute('aria-expanded', 'true');
        }
    }

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('faqSearch');
        const clearBtn = document.getElementById('clearSearch');
        const faqItems = document.querySelectorAll('.faq-item');
        const noResults = document.getElementById('noResults');
        const resultCount = document.getElementById('resultCount');
        
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            let visibleCount = 0;
            
            faqItems.forEach(item => {
                const question = item.getAttribute('data-question');
                const answer = item.getAttribute('data-answer');
                const isVisible = question.includes(query) || answer.includes(query);
                
                if (query === '') {
                    item.style.display = 'block';
                    visibleCount++;
                } else if (isVisible) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide clear button
            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
            
            // Update result count
            resultCount.textContent = visibleCount;
            
            // Show/hide no results message
            if (visibleCount === 0 && query.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        });
        
        // Clear search
        clearBtn.addEventListener('click', clearSearch);
    });
    
    function clearSearch() {
        const searchInput = document.getElementById('faqSearch');
        const clearBtn = document.getElementById('clearSearch');
        const noResults = document.getElementById('noResults');
        const faqItems = document.querySelectorAll('.faq-item');
        const resultCount = document.getElementById('resultCount');
        
        searchInput.value = '';
        clearBtn.classList.add('hidden');
        noResults.classList.add('hidden');
        
        faqItems.forEach(item => {
            item.style.display = 'block';
        });
        
        resultCount.textContent = faqItems.length;
    }
</script>
@endpush
@endsection