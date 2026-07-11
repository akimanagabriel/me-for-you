@props(['variant' => 'public'])

@if ($variant === 'admin')
    <footer class="footer footer-center bg-base-200 text-base-content/60 p-4 border-t border-base-300 text-xs">
        <aside>
            <p>© {{ date('Y') }} ME FOR YOU Advisory. All rights reserved.</p>
        </aside>
    </footer>
@else
    <footer class="bg-neutral text-neutral-content/60 py-16 px-6 mt-15">
        <div class="max-w-[1200px] mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 pb-12 border-b border-white/10 mb-8">
                <div class="lg:col-span-1">
                    <div class="font-display text-2xl font-semibold text-neutral-content mb-3">
                        ME <span class="text-primary">FOR</span> YOU
                    </div>
                    <p class="text-sm leading-relaxed max-w-xs mb-6">
                        Your professional companion for housing, events, and transport services in Kigali, Rwanda.
                    </p>
                    <div class="flex gap-3">
                        <a href="https://www.instagram.com/meforyou_rw/" target="_blank" rel="noopener"
                           class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center hover:bg-primary transition-colors"
                           aria-label="Instagram">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5" />
                                <circle cx="12" cy="12" r="4" />
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-neutral-content mb-5">Services</p>
                    <a href="{{ route('houses.index') }}"
                       class="block text-sm py-1 hover:text-primary transition-colors">Housing</a>
                    <a href="{{ route('events.index') }}"
                       class="block text-sm py-1 hover:text-primary transition-colors">Event Management</a>
                    <a href="{{ route('cars.index') }}"
                       class="block text-sm py-1 hover:text-primary transition-colors">Transport</a>
                    <a href="{{ route('contact') }}"
                       class="block text-sm py-1 hover:text-primary transition-colors">Corporate Packages</a>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-neutral-content mb-5">Company</p>
                    <a href="{{ route('about') }}" class="block text-sm py-1 hover:text-primary transition-colors">About
                        Us</a>
                    <a href="{{ route('gallery') }}" class="block text-sm py-1 hover:text-primary transition-colors">Our
                        Work</a>
                    <a href="{{ url('/#testimonials') }}"
                       class="block text-sm py-1 hover:text-primary transition-colors">Reviews</a>
                    <a href="{{ route('contact') }}"
                       class="block text-sm py-1 hover:text-primary transition-colors">Contact</a>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-neutral-content mb-5">Contact</p>
                    <a href="https://www.instagram.com/meforyou_rw/" target="_blank" rel="noopener"
                       class="block text-sm py-1 hover:text-primary transition-colors">@meforyou_rw</a>
                    <a href="mailto:info@me-for-you.org"
                       class="block text-sm py-1 hover:text-primary transition-colors">info@me-for-you.org</a>
                    <span class="block text-sm py-1">Kigali, Rwanda</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 text-sm">
                <span>© {{ date('Y') }} ME FOR YOU. All rights reserved.</span>
                <span>Empowering Rwanda, one service at a time.</span>
            </div>
        </div>
    </footer>
@endif