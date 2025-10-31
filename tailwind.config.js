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
            // GetCooked Styleguide - Warm & Gezellig (Karamel & Toffee)
            colors: {
                primary: {
                    50: '#F9F6F2',
                    100: '#F0EAE1',
                    400: '#C09970',
                    500: '#A67C52',
                    600: '#8B6644',
                    700: '#75563A',
                },
                secondary: {
                    400: '#E3C19A',
                    500: '#D4A574',
                    600: '#B8895F',
                    700: '#9D7350',
                },
                gray: {
                    50: '#FAF7F4',
                    100: '#F5F2EF',
                    200: '#E8E3DD',
                    300: '#D4CEC5',
                    400: '#A39B8F',
                    500: '#7A7267',
                    600: '#5C5449',
                    700: '#3E3830',
                    800: '#2A2520',
                    900: '#1A1714',
                },
                success: '#52B788',
                warning: '#F59E0B',
                error: '#DC2626',
                info: '#3B82F6',
            },
            fontFamily: {
                primary: ['Lora', 'Georgia', 'serif'],
                body: ['Lato', 'system-ui', '-apple-system', 'sans-serif'],
                sans: ['Lato', 'system-ui', '-apple-system', ...defaultTheme.fontFamily.sans],
                serif: ['Lora', 'Georgia', ...defaultTheme.fontFamily.serif],
            },
            borderRadius: {
                'md': '8px',
                'lg': '12px',
                'xl': '16px',
                '2xl': '24px',
            },
            boxShadow: {
                'sm': '0 1px 2px rgba(0, 0, 0, 0.05)',
                'DEFAULT': '0 4px 6px rgba(0, 0, 0, 0.1)',
                'md': '0 4px 6px rgba(0, 0, 0, 0.1)',
                'lg': '0 10px 15px rgba(0, 0, 0, 0.1)',
                'xl': '0 20px 25px rgba(0, 0, 0, 0.15)',
                '2xl': '0 25px 50px rgba(0, 0, 0, 0.25)',
            },
            transitionDuration: {
                'fast': '150ms',
                'base': '200ms',
                'slow': '300ms',
                'slower': '500ms',
            },
            transitionTimingFunction: {
                'spring': 'cubic-bezier(0.34, 1.56, 0.64, 1)',
            },
        },
    },

    plugins: [forms],
};
