<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\Product\ProductImageService;
use App\Services\Product\ProductSkuService;
use App\Services\Product\ProductBarcodeService;
use App\Services\Product\ProductQrCodeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected ProductImageService $imageService,
        protected ProductSkuService $skuService,
        protected ProductBarcodeService $barcodeService,
        protected ProductQrCodeService $qrService
    ) {}

    public function getProducts(array $filters = []): LengthAwarePaginator
    {
        return $this->productRepository->getAll($filters);
    }

    public function getProduct(int $id): Product
    {
        $product = $this->productRepository->findById($id);
        if (!$product) throw new ModelNotFoundException('Product not found.');
        return $product;
    }

    public function createProduct(array $data): Product
    {
        DB::beginTransaction();
        try {
            // Auto-generate slug and SKU
            $data['slug'] = Str::slug($data['name']);
            if (empty($data['sku'])) {
                $data['sku'] = $this->skuService->generate();
            }
            // Handle image upload (if provided in $data as UploadedFile)
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $this->imageService->upload($data['image']);
            }
            // Create product record
            $product = $this->productRepository->create($data);
            // Optionally, generate barcode and QR (storing their textual code)
            $product->update([
                'barcode' => $product->sku,
                'qr_code' => route('products.show', $product->id), // or any data
            ]);
            DB::commit();
            return $product;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Product Create Failed', ['error' => $ex->getMessage()]);
            throw $ex;
        }
    }

    public function updateProduct(int $id, array $data): Product
    {
        DB::beginTransaction();
        try {
            $product = $this->getProduct($id);
            if (isset($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }
            // If image provided, delete old one first
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $this->imageService->delete($product->image);
                $data['image'] = $this->imageService->upload($data['image']);
            }
            $updated = $this->productRepository->update($product, $data);
            DB::commit();
            return $updated;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Product Update Failed', ['error' => $ex->getMessage()]);
            throw $ex;
        }
    }

    public function deleteProduct(int $id): bool
    {
        DB::beginTransaction();
        try {
            $product = $this->getProduct($id);
            $deleted = $this->productRepository->delete($product);
            DB::commit();
            return $deleted;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error('Product Delete Failed', ['error' => $ex->getMessage()]);
            throw $ex;
        }
    }
}
