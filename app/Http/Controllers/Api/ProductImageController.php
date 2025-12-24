<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductImageRequest;
use App\Http\Resources\MediaResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class ProductImageController
{
    /**
     * Store a newly uploaded image for the product.
     */
    public function store(ProductImageRequest $request, Product $product): JsonResponse
    {
        $media = $product->addMedia($request->file('image'))
            ->toMediaCollection('product_images');

        return response()->json(MediaResource::make($media), Response::HTTP_CREATED);
    }

    /**
     * Remove the specified image from the product.
     */
    public function destroy(Product $product, Media $media): JsonResponse|Response
    {
        if ($media->model_id !== $product->id || $media->model_type !== Product::class) {
            return response()->json([
                'message' => 'Image not found for this product.',
            ], Response::HTTP_NOT_FOUND);
        }

        $media->delete();

        return response()->noContent();
    }
}
