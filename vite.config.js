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
    // Keep font/image URLs inside the built CSS relative, so the app also works
    // from a sub-folder (e.g. http://localhost/ndcitinv/public).
    experimental: {
        renderBuiltUrl(filename, { hostType }) {
            return hostType === 'css' ? { relative: true } : undefined;
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
