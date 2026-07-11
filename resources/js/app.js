import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('confirmDialog', () => ({
    open: false,
    message: '',
    callback: null,
    show(message, callback) {
        this.message = message;
        this.callback = callback;
        this.open = true;
    },
    confirm() {
        if (this.callback) this.callback();
        this.open = false;
    },
    cancel() {
        this.open = false;
    },
}));

Alpine.data('toast', () => ({
    toasts: [],
    add(message, type = 'info') {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        setTimeout(() => this.remove(id), 4000);
    },
    remove(id) {
        this.toasts = this.toasts.filter((t) => t.id !== id);
    },
}));

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const revealObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
    );

    document.querySelectorAll('.reveal').forEach((el) => revealObserver.observe(el));
});
