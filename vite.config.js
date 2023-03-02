import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    publicDir: 'vendor/mixpost-auth',
    plugins: [
        laravel({
            input: 'resources/css/app.css',
            publicDirectory: 'resources',
            buildDirectory: 'dist',
            refresh: true
        })
    ]
});
