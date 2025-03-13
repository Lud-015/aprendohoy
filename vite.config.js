import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
<<<<<<< HEAD

        laravel(
            {
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }
        ),
        tailwindcss(),
=======
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
>>>>>>> cb8fa77f0ef74b746ba20ffad46948ba09d39ee0
    ],
    optimizeDeps: {
        include: [
            'flatpickr'
        ]
    }

});
