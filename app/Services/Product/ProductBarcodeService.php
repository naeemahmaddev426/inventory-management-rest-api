<?php

namespace App\Services\Product;

use Milon\Barcode\DNS1D;

class ProductBarcodeService
{
    /**
     * Generate a 1D barcode PNG (base64-encoded image) for the given code.
     * Requires the 'php-gd' extension.
     *
     * @param string $code
     * @return string Base64-encoded PNG (data URI without prefix)
     */
    public function generatePng(string $code): string
    {
        $dns = new DNS1D();
        // For example, Code39:
        return 'data:image/png;base64,' . $dns->getBarcodePNG($code, 'C39+');
    }
}
