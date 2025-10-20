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
            'pdfUrl' => route('ebooks.stream', $ebook),
        ]);
    }

    public function stream(Ebook $ebook): StreamedResponse
    {

        $path = 'ebooks/' . $ebook->filepath;

        if (!Storage::disk('local')->exists($path)) {

            abort(404, "File PDF tidak ditemukan di lokasi: " . $path);
        }

        return new StreamedResponse(function () use ($path) {
            $stream = Storage::disk('local')->readStream($path);
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [

            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $ebook->title . '.pdf"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    // create new book
    public function create()
    {
        return view('ebooks.create');
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ], [
            'pdf_file.required' => 'File PDF wajib diunggah.',
            'pdf_file.mimes' => 'File harus berformat PDF.',
            'pdf_file.max' => 'Ukuran file PDF maksimal adalah 10 MB.',
        ]);

        $file = $req->file('pdf_file');

        $filePath = Storage::disk('local')->putFile('ebooks', $file);
        $fileName = basename($filePath);

        auth()->user()->ebooks()->create([
            'title' => $validated['title'],
            'author' => $validated['author'] ?? 'Anonim',
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? 0.00,
            'filepath' => $fileName, // Simpan nama file unik
        ]);
        return redirect()->route('ebooks.index')->with('status', 'Ebook baru berhasil ditambahkan dan disimpan secara aman!');
    }

    public function destroy(Ebook $ebook)
    {

        try {
            // Hapus file dari storage
            $path = 'ebooks/' . $ebook->filepath;
            if (Storage::disk('local')->exists($path)) {
                Storage::disk('local')->delete($path);
            }

            // Hapus record dari database
            $ebook->delete();

            // Redirect kembali ke dashboard
            return redirect()->route('ebooks.index')->with('status', 'Ebook berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('ebooks.index')->with('error', 'Gagal menghapus Ebook: ' . $e->getMessage());
        }
    }
}
