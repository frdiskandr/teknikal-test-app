import * as pdfjsLib from 'pdfjs-dist';
// Import file worker PDF.js langsung dari node_modules sebagai URL.
// Vite akan menyalin file ini ke folder public/build/ dan memberikan URL yang benar.
import PdfWorker from 'pdfjs-dist/build/pdf.worker.mjs?url'; // <-- KUNCI PERBAIKAN

// Set workerSrc menggunakan URL yang sudah diperbaiki oleh Vite
pdfjsLib.GlobalWorkerOptions.workerSrc = PdfWorker;

/**
 * Merender PDF dari URL stream ke elemen canvas di halaman.
 * @param {string} pdfUrl - URL aman dari Laravel Controller (route('ebooks.stream')).
 * @param {string} containerId - ID elemen div container.
 */
export async function renderSecuredPdf(pdfUrl, containerId) {
    const container = document.getElementById(containerId);
    if (!container) {
        console.error('PDF container element not found.');
        return;
    }

    // ... (Sisa fungsi renderSecuredPdf tetap sama) ...

    // Tampilkan pesan loading
    container.innerHTML = `<p class="text-gray-600 mb-4">Memuat Ebook, mohon tunggu...</p>`;


    try {
        // 1. Ambil dokumen PDF (fetch) menggunakan URL stream aman
        const pdfData = await fetch(pdfUrl);
        const pdfArrayBuffer = await pdfData.arrayBuffer();

        // 2. Load PDF dari ArrayBuffer
        const loadingTask = pdfjsLib.getDocument({ data: pdfArrayBuffer });
        const pdf = await loadingTask.promise;

        // 3. Render setiap halaman sebagai Canvas
        const numPages = pdf.numPages;
        container.innerHTML = '';

        for (let pageNum = 1; pageNum <= numPages; pageNum++) {
            const page = await pdf.getPage(pageNum);

            const scale = 1.5;
            const viewport = page.getViewport({ scale: scale });

            const canvas = document.createElement('canvas');
            canvas.className = 'pdf-page-canvas mb-4 shadow-xl border border-gray-300';

            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };

            await page.render(renderContext).promise;

            container.appendChild(canvas);
        }

    } catch (error) {
        console.error('Error during PDF rendering:', error);
        container.innerHTML = `<p class="text-red-500 p-4">Gagal memuat PDF. Pastikan file tersedia dan format benar. Error: ${error.message}</p>`;
    }
}
