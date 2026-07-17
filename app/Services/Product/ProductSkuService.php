<?php

namespace app\Services\Product;

use app\Models\Product;

class ProductSkuService
{
    /**
     * Generate the next SKU in sequence, e.g. PRD-000001, PRD-000002, etc.
     */
    public function generate(): string
    {
        // Get last product ID (with trashed or without? include trashed for continuity)
        $last = Product::withTrashed()->latest('id')->first();
        $nextId = $last ? $last->id + 1 : 1;
        return 'PRD-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
}
