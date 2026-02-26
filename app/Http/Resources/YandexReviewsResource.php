<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YandexReviewsResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $data = $this->resource['data'] ?? $this->resource;

        return [
            'reviews' => $data['reviews'] ?? [],
            'count_reviews' => $data['params']['count'] ?? 0,
            'rating' => $this->resource['rating'] ?? null,
            'name' => $this->resource['name'] ?? null,
            'pagination' => [
                'current_page' => $data['params']['page'] ?? 1,
                'total_pages' => $data['params']['totalPages'] ?? 1,
            ],
        ];
    }
}
