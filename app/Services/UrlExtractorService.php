<?php

namespace App\Services;

class UrlExtractorService
{
    public function tryExtractOrganizationId(string $url): ?string
    {
        if (preg_match('/\/org\/[^\/]+\/(\d+)/', $url, $m)) {
            return $m[1];
        }

        return null;
    }
}