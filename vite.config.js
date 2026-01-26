import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '10.0.0.219',
        port: 5173,
        cors: {
            origin: 'http://10.0.0.219:8000',
        },
        hmr: {
            host: '10.0.0.219',
        },
    },
});
