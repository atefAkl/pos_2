import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Listen on all network interfaces
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'www.pos-new.local', // Use your custom domain for HMR
            protocol: 'http',
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        cors: {
            origin: 'http://www.pos-new.local',
            credentials: true,
        },
    },
});
