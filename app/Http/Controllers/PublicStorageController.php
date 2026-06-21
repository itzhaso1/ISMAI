<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PublicStorageController extends Controller
{
    public function __invoke(string $path): Response
    {
        abort_if(str_contains($path, '..') || ! Storage::disk('public')->exists($path), 404);

        return response(Storage::disk('public')->get($path), 200, [
            'Content-Type' => Storage::disk('public')->mimeType($path) ?: 'application/octet-stream',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }
}
