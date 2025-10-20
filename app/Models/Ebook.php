<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',          // <--- PASTIKAN INI ADA
        'author',
        'description',
        'price',
        'filepath',       // <--- PATH FILE YANG DISIMPAN
        'user_id',        // <--- ID USER (Walaupun diisi oleh relasi, ini penting)
    ];

    protected $casts = [
        'price' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
