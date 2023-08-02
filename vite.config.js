import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

// andre madarang setup
const setup = [laravel(['resources/js/app.js']), react()];

export default defineConfig({
    plugins: [
        // laravel(
        //     [
        //         'resources/css/app.css',
        //         'resources/js/app.js',
        //     ],
        // ),
        // laravel({
        //     input: [
        //         // 'resources/css/app.css',
        //         'resources/js/app.js'
        //     ],
        //     refresh: false,
        // }),
        ...setup,
    ],
    resolve: {
        alias: {
            "@/": path.resolve(__dirname, "./resources/js/client")
        }
    }
});
