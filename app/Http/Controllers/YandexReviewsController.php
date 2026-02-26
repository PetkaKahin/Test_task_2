<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexYandexReviewsRequest;
use App\Http\Resources\YandexReviewsResource;
use App\Services\YandexReviewsService;
use Illuminate\Http\JsonResponse;

class YandexReviewsController extends Controller
{
    public function __construct(
        private readonly YandexReviewsService $yandexReviewsService
    ) {}

    public function index(IndexYandexReviewsRequest $request): YandexReviewsResource|JsonResponse
    {
        $organizationId = $this->resolveOrganizationId();
        if ($organizationId instanceof JsonResponse) {
            return $organizationId;
        }

        ['page' => $page, 'page_size' => $pageSize] = $request->validated();

        $reviews = $this->yandexReviewsService->getReviews($organizationId, $page, $pageSize, 3600);
        $info = $this->yandexReviewsService->getOrganizationInfo($organizationId, 3600);

        return new YandexReviewsResource(array_merge($reviews, $info));
    }

    private function resolveOrganizationId(): string|JsonResponse
    {
        $url = auth()->user()->settings?->url_organization;
        if ($url === null) {
            return response()->json(['error' => 'URL организации не указан'], 422);
        }

        $organizationId = $this->yandexReviewsService->extractOrganizationId($url);
        if ($organizationId === null) {
            return response()->json(['error' => 'Не удалось извлечь ID организации из URL'], 422);
        }

        return $organizationId;
    }
}