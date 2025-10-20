<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Viewing: {{ $ebook->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.addEventListener('selectstart', event => event.preventDefault()); // Mencegah pemilihan teks
    </script>

    <script>
        document.addEventListener("visibilitychange", function() {
            if (document.visibilityState === 'hidden') {
                // Saat user pindah tab atau minimize
                alert("!! PERINGATAN !! Anda tidak diizinkan meninggalkan tab ini saat membaca Ebook.");
                // Opsi: Anda bisa menambahkan logic untuk logout paksa atau pause
                // window.focus(); // Ini mungkin tidak didukung di semua browser/versi
            }
        });

        // Coba blokir beberapa shortcut keyboard yang umum (mis: Ctrl+P, Ctrl+S)
        document.onkeydown = function(e) {
            if (e.ctrlKey && (e.key === 'p' || e.key === 's' || e.key === 'u')) {
                alert("Aksi ini diblokir.");
                e.preventDefault();
            }
            // Blokir F12 (Developer Tools)
            if (e.keyCode == 123) {
                alert("Developer Tools diblokir.");
                return false;
            }
        };
    </script>

</head>
<body class="bg-gray-100">

<div class="min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">{{ $ebook->title }} - Secure Viewer</h1>
        <a href="{{ route('ebooks.index') }}" class="text-blue-500 hover:text-blue-700">Kembali ke Dashboard</a>
    </header>

    <main class="flex-grow">
        <iframe
            src="{{ $pdfUrl }}"
            class="w-full h-full border-none"
            style="min-height: calc(100vh - 64px); /* Sesuaikan dengan tinggi header */"
            title="Ebook Viewer - {{ $ebook->title }}"
        >
            <p>Browser Anda tidak mendukung iframe.</p>
        </iframe>
    </main>
</div>

</body>
</html>
