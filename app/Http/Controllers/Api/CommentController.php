<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class CommentController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Product $product): JsonResponse
    {
        $comment = $product->comments()->create([
            'user_id' => Auth::user()->id,
            'content' => $request->validated('content'),
        ]);

        return response()->json(
            CommentResource::make($comment),
            Response::HTTP_CREATED
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Product $product, Comment $comment): JsonResponse
    {
        $comment->update([
            'content' => $request->validated('content'),
        ]);

        return response()->json(CommentResource::make($comment));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, Comment $comment): JsonResponse|Response
    {
        if ($comment->user_id !== Auth::user()->id) {
            return response()->json([
                'message' => 'Unauthorized to delete this comment',
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($comment->product_id !== $product->id) {
            return response()->json([
                'message' => 'Comment does not belong to this product',
            ], Response::HTTP_NOT_FOUND);
        }

        $comment->delete();

        return response()->noContent();
    }
}
