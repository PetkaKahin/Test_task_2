<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use App\Models\Settings;
use App\Services\UrlExtractorService;
use App\Services\YandexMapService;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function __construct(
        private readonly UrlExtractorService $urlExtractorService,
        private readonly YandexMapService $yandexMapService,
    ) {}

    public function show() {
        $settings = Settings::query()->where('user_id', auth()->user()->id)->first();

        return Inertia::render('Settings', [
            'url' => $settings->url_organization ?? null,
        ]);
    }

    public function update(SettingsUpdateRequest $request)
    {
        $userId = auth()->user()->id;
        $settings = Settings::query()->where('user_id', $userId)->first();

        $organizationId = $this->urlExtractorService->tryExtractOrganizationId(
            $request->validated()['url_organization']
        );
        $organization = $this->yandexMapService->getOrganizationInfo($organizationId, 3600);

        if ($organization['name'] === null) {
            return response()->json([
                'errors' => 'Такой организации нет',
            ]);
        }

        if (!$settings) {
            Settings::query()->create([
                'user_id' => $userId,
                ...$request->validated(),
            ]);
        } else {
            $settings->update($request->validated());
        }

        return redirect(route('settings.show'));
    }
}
