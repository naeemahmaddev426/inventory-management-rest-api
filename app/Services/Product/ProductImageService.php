<?php

namespace App\Services\Product;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductImageService
{
    /**
     * Store the uploaded product image on the 'public' disk (storage/app/public/products).
     * Returns the relative path, e.g. "products/abc123.jpg", or null if no file.
     */
    public function upload(?UploadedFile $image): ?string
    {
        if (!$image) {
            return null;
        }
        // Store in 'products' directory on public disk (storage/app/public/products)
        return $image->store('products', 'public');
    }

    /**
     * Delete a previously stored image file.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
