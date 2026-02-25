<?php

namespace App\Http\Controllers;

use App\Services\YandexReviewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class YandexReviewsController extends Controller
{
    public function __construct(
        private readonly YandexReviewsService $reviewsService
    ) {}


    public function index(Request $request): JsonResponse
    {

    }
}