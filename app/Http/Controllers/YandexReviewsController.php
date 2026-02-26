<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexYandexReviewsRequest;
use App\Http\Resources\YandexReviewsResource;
use App\Services\UrlExtractorService;
use App\Services\YandexMapService;
use Illuminate\Http\JsonResponse;

class YandexReviewsController extends Controller
{
    public function __construct(
        private readonly YandexMapService $yandexReviewsService,
        private readonly UrlExtractorService $urlExtractorService,
    ) {}

    public function index(IndexYandexReviewsRequest $request): YandexReviewsResource|JsonResponse
    {
        $url = auth()->user()->settings->url_organization;
        $organizationId = $this->urlExtractorService->tryExtractOrganizationId($url);
        if ($organizationId === null) {
            return response()->json([
                'errors' => 'Не удалось получить url организации',
            ]);
        }

        ['page' => $page, 'page_size' => $pageSize] = $request->validated();

        $reviews = $this->yandexReviewsService->getReviews($organizationId, $page, $pageSize, 3600);
        $info = $this->yandexReviewsService->getOrganizationInfo($organizationId, 3600);

        return new YandexReviewsResource(array_merge($reviews, $info));
    }
}