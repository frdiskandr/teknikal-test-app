import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
// import {copy} from 'vite-plugin-copy'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        // copy({
        //     targets: [
        //         {
        //             // Tentukan lokasi file worker PDF.js di node_modules
        //             src: 'node_modules/pdfjs-dist/build/pdf.worker.js',
        //             // Tentukan tujuan penyalinan di direktori public/build
        //             // Ini akan menjadi public/build/assets/pdf.worker.js
        //             dest: 'public/build/assets',
        //             // Ubah nama file menjadi pdf.worker.js (opsional)
        //             rename: 'pdf.worker.js'
        //         },
        //     ],
        //     hook: 'writeBundle' // Jalankan setelah bundling
        // })
    ],
});
