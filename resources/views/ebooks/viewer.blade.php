<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Viewer: {{ $ebook->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .pdf-page-canvas {
            /* Mencegah pemilihan teks secara umum pada Canvas */
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
    </style>

    <script>
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.addEventListener('selectstart', event => event.preventDefault());

        document.onkeydown = function(e) {
            if (e.ctrlKey && (e.key === 'p' || e.key === 's' || e.key === 'u')) {
                alert("Aksi ini diblokir untuk menjaga kerahasiaan konten.");
                e.preventDefault();
            }
            if (e.keyCode === 123) {
                alert("Akses Developer Tools diblokir.");
                return false;
            }
        };
    </script>

    <script>
        document.addEventListener("visibilitychange", function() {
            if (document.visibilityState === 'hidden') {
                alert("!! PERINGATAN !! Anda tidak diizinkan meninggalkan tab ini saat membaca Ebook. Fokus harus dipertahankan.");
            }
        });
    </script>
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">{{ $ebook->title }} - Secure Viewer</h1>
        <a href="{{ route('ebooks.index') }}" class="text-blue-500 hover:text-blue-700">Kembali ke Dashboard</a>
    </header>

    <main class="flex-grow p-4 md:p-8 flex justify-center items-start">
        <div id="pdf-viewer-container"
             data-pdf-url="{{ $pdfUrl }}"
             class="w-full max-w-4xl bg-white shadow-xl flex flex-col items-center p-4"
             style="min-height: 80vh;"
        >
            </div>
    </main>
</div>
</body>
</html>
