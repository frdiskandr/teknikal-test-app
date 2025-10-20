<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::orderBy('title')->get();
        return view('ebooks.index', [
            'ebooks' => $ebooks
        ]);
    }

    public function show(Ebook $ebook)
    {
        // Mengirim data Ebook ke view viewer
        return view('ebooks.viewer', [
            'ebook' => $ebook,
            // URL yang aman untuk streaming PDF (route ebooks.stream akan dibuat di Lngkh B2)
            'pdfUrl' => route('ebooks.stream', $ebook),
        ]);
    }

    public function stream(Ebook $ebook): StreamedResponse
    {
        // Mendefinisikan lokasi file PDF di storage (Misalnya: storage/app/ebooks/nama_file.pdf)
        $path = 'ebooks/' . $ebook->filepath;

        if (!Storage::disk('local')->exists($path)) {
            // Periksa di disk 'local' (storage/app)
            abort(404, "File PDF tidak ditemukan di lokasi: " . $path);
        }

        return new StreamedResponse(function () use ($path) {
            $stream = Storage::disk('local')->readStream($path);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            // Content-Disposition 'inline' memaksa browser untuk menampilkan, bukan mengunduh.
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $ebook->title . '.pdf"',
            // Lapisan keamanan tambahan
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function destroy(Ebook $ebook)
    {
        // Opsional: Cek apakah user yang login punya hak untuk menghapus Ebook ini (Authorization)
        // if (auth()->id() !== $ebook->user_id) {
        //     abort(403, 'Anda tidak memiliki hak untuk menghapus ebook ini.');
        // }

        try {
            // Hapus file fisik dari storage
            $path = 'ebooks/' . $ebook->filepath;
            if (Storage::disk('local')->exists($path)) {
                Storage::disk('local')->delete($path);
            }

            // Hapus record dari database
            $ebook->delete();

            // Redirect kembali ke dashboard dengan pesan sukses
            return redirect()->route('ebooks.index')->with('status', 'Ebook berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('ebooks.index')->with('error', 'Gagal menghapus Ebook: ' . $e->getMessage());
        }
    }
}
