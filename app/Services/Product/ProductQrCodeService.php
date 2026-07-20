<?php

namespace App\Services\Product;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductQrCodeService
{
    /**
     * Generate a QR code PNG image (base64 data URI) for the given text.
     *
     * @param string $text
     * @return string Base64-encoded PNG URI
     */
    public function generatePng(string $text): string
    {
        // e.g. size 200x200, error correction M
        return QrCode::format('png')->size(200)->errorCorrection('M')->generate($text);
    }
}
