<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsUpdateRequest;
use App\Models\Settings;
use Inertia\Inertia;

class SettingsController extends Controller
{
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
