<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => $this->getUrl(),
            'name' => $this->file_name,
            'size' => $this->size,
            'created_at' => $this->created_at->format('Y-m-d h:i:s A'),
            'updated_at' => $this->updated_at->format('Y-m-d h:i:s A'),
        ];
    }
}
