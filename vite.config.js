import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/scroll-animations.css',
                'resources/js/app.js',
                'resources/js/scroll-animations.js'
            ],
            refresh: true,
        }),
    ],
});
