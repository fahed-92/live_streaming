import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { nodeResolve } from '@rollup/plugin-node-resolve';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        nodeResolve(),
    ],

    resolve: {
        alias: {
            '@': '/resources/js',
            'fabric': 'fabric/dist/fabric.min.js'
        },
    },
    build: {
        rollupOptions: {
        },
    },
});
