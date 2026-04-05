import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'gold-light': '#F4E7B3',
                'gold': '#D4AF37',
                'gold-dark': '#B8860B',
                'gold-premium': '#C5A028',
                'gold-soft': '#FDFCF0',
                'royal-navy': '#0F172A',
                'royal-blue': '#1E293B',
                'royal-gold': '#EAB308',
                'premium-white': '#F8FAFC',
                'premium-pearl': '#FFFFFF',
                'premium-silk': '#F1F5F9',
                'silk': '#F8FAFC',
            },
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
                jakarta: ['"Plus Jakarta Sans"', 'Inter', ...defaultTheme.fontFamily.sans],
                playfair: ['"Playfair Display"', 'serif'],
            },
            animation: {
                'fade-in': 'fadeIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards',
            },
        },
    },

    plugins: [forms],
};
