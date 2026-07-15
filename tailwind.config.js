/**
 * MeForYou Design System   Tailwind + DaisyUI theme reference.
 *
 * Tailwind CSS v4 + DaisyUI 5 configure themes in resources/css/app.css.
 * This file documents the meforyou theme extracted from landing-page.blade.php.
 */
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    daisyui: {
        themes: [
            {
                meforyou: {
                    primary: '#b87f3a',
                    'primary-content': '#ffffff',
                    secondary: '#8a6e22',
                    'secondary-content': '#ffffff',
                    accent: '#d49d6a',
                    'accent-content': '#1a1714',
                    neutral: '#1a1714',
                    'neutral-content': '#f5f0e8',
                    'base-100': '#ffffff',
                    'base-200': '#f5f0e8',
                    'base-300': '#ede7d8',
                    'base-content': '#1a1714',
                    info: '#3b82f6',
                    'info-content': '#ffffff',
                    success: '#22c55e',
                    'success-content': '#ffffff',
                    warning: '#f59e0b',
                    'warning-content': '#1a1714',
                    error: '#ef4444',
                    'error-content': '#ffffff',
                    '--rounded-box': '0.75rem',
                    '--rounded-btn': '0.375rem',
                    '--rounded-badge': '0.375rem',
                    '--animation-btn': '0.2s',
                    '--animation-input': '0.2s',
                    '--btn-focus-scale': '0.98',
                    '--border-btn': '1px',
                    '--tab-border': '1px',
                    '--tab-radius': '0.375rem',
                },
            },
        ],
    },
};
