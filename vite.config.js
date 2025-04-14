import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/css/app.css',
            publicDirectory: 'resources/dist',
            buildDirectory: 'vendor/mixpost-auth',
            refresh: true
        }),
        tailwindcss(),
    ]
});
