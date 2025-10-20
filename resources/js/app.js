import './bootstrap';

import Alpine from 'alpinejs';
import {renderSecuredPdf} from "./pdf-viewers.js"

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // Ambil elemen container PDF dan URL dari data attribute
    const pdfContainer = document.getElementById('pdf-viewer-container');
    const pdfUrl = pdfContainer?.dataset.pdfUrl;

    if (pdfContainer && pdfUrl) {
        // Panggil fungsi rendering
        renderSecuredPdf(pdfUrl, 'pdf-viewer-container');
    }
});
