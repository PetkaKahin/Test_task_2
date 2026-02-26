<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YandexReviewsService
{
    public function getReviews(string $organizationId, int $pageNumber, int $pageSize, int $cacheTime): array
    {
        $reviews = $this->getReviewsInMaps($organizationId, $pageNumber, $pageSize, $cacheTime);

        if (empty($reviews['data']['reviews'] ?? null)) {
            $reviews = $this->getReviewsInBusiness($organizationId, $pageNumber, $pageSize, $cacheTime);
        }

        return $reviews;
    }

    public function getReviewsInMaps(string $organizationId, int $pageNumber, int $pageSize, int $cacheTime): array
    {
        return $this->fetchReviews('Maps', 'yandex.com', 'yandex_reviews', $organizationId, $pageNumber, $pageSize, $cacheTime);
    }

    public function getReviewsInBusiness(string $organizationId, int $pageNumber, int $pageSize, int $cacheTime): array
    {
        return $this->fetchReviews('Business', 'yandex.ru', 'yandex_reviews_biz', $organizationId, $pageNumber, $pageSize, $cacheTime);
    }

    public function getOrganizationInfo(int $organizationId, int $cacheTime): array
    {
        return Cache::remember("yandex_org_info_{$organizationId}", $cacheTime, function () use ($organizationId) {
            $name = null;
            $rating = null;

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ])->get("https://yandex.ru/maps-reviews-widget/{$organizationId}?comments");

            if ($response->successful()) {
                $doc = new DOMDocument();
                @$doc->loadHTML(mb_convert_encoding($response->body(), 'HTML-ENTITIES', 'UTF-8'));
                $xpath = new DOMXPath($doc);

                $nameNode = $xpath->query('//a[contains(@class, "mini-badge__org-name")]')->item(0);
                if ($nameNode) {
                    $name = trim($nameNode->textContent);
                }

                $ratingNode = $xpath->query('//p[contains(@class, "mini-badge__stars-count")]')->item(0);
                if ($ratingNode) {
                    $rating = (float)str_replace(',', '.', trim($ratingNode->textContent));
                }
            }

            return [
                'name'   => $name,
                'rating' => $rating,
            ];
        });
    }

    public function extractOrganizationId(string $url): ?string
    {
        if (preg_match('/\/org\/[^\/]+\/(\d+)/', $url, $m)) {
            return $m[1];
        }

        return null;
    }

    private function fetchReviews(
        string $source,
        string $domain,
        string $cacheKeyPrefix,
        string $organizationId,
        int $pageNumber,
        int $pageSize,
        int $cacheTime
    ): array {
        $cacheKey = "{$cacheKeyPrefix}_{$organizationId}_{$pageNumber}";
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $auth = $this->getAuth($organizationId, $domain);
        if (!$auth) return [];

        $cookieJar = new CookieJar(false, $auth['cookies']);
        $params = $this->buildParams($organizationId, $pageNumber, $pageSize, $auth['csrf']);

        $response = Http::withOptions(['cookies' => $cookieJar])
            ->withHeaders($this->headers($domain, $organizationId))
            ->get("https://{$domain}/maps/api/business/fetchReviews", $params);

        $json = $response->json() ?? [];

        if (isset($json['error'])) return [];

        if (!empty($json['data']['reviews'])) {
            Cache::put($cacheKey, $json, $cacheTime);
        }

        return $json;
    }

    // Кэшируем CSRF + куки на 15 минут, чтобы не улететь в бан
    private function getAuth(string $organizationId, string $domain): ?array
    {
        $cacheKey = "yandex_auth_{$domain}_{$organizationId}";

        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $cookieJar = new CookieJar();

        $response = Http::withOptions(['cookies' => $cookieJar])
            ->withHeaders($this->headers($domain, $organizationId))
            ->get("https://{$domain}/maps/org/{$organizationId}/reviews/");

        preg_match('/"csrfToken":"([^"]+)"/', $response->body(), $matches);
        $csrfToken = $matches[1] ?? null;

        if (!$csrfToken) return null; // не кэшируем провал

        $auth = [
            'csrf'    => $csrfToken,
            'cookies' => $cookieJar->toArray(),
        ];

        Cache::put($cacheKey, $auth, 900); // 15 минут

        return $auth;
    }

    private function headers(string $domain, string $organizationId): array
    {
        return [
            'User-Agent'      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36',
            'Referer'         => "https://{$domain}/maps/org/{$organizationId}/reviews/",
            'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
            'Accept-Language' => 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection'      => 'keep-alive',
            'Sec-Fetch-Dest'  => 'document',
            'Sec-Fetch-Mode'  => 'navigate',
            'Sec-Fetch-Site'  => 'none',
            'Sec-Fetch-User'  => '?1',
        ];
    }

    private function buildParams(string $organizationId, int $pageNumber, int $pageSize, string $csrfToken): array
    {
        $timestamp = (int)(microtime(true) * 1000);

        $params = [
            'ajax'       => 1,
            'businessId' => $organizationId,
            'csrfToken'  => $csrfToken,
            'locale'     => 'ru_RU',
            'page'       => $pageNumber,
            'pageSize'   => $pageSize,
            'ranking'    => 'by_time',
            'reqId'      => $timestamp . '-' . mt_rand(100000000, 999999999) . '-addrs-upper',
            'sessionId'  => $timestamp . '-' . mt_rand(1000000000000000, 9999999999999999) . '-balancer',
        ];

        $params['s'] = $this->hashFunction(http_build_query($params));

        return $params;
    }

    private function hashFunction(string $e): int
    {
        $n = 5381;

        for ($r = 0; $r < strlen($e); $r++) {
            $n = $this->toInt32(33 * $n) ^ ord($e[$r]);
        }

        return $n < 0 ? $n + 4294967296 : $n;
    }

    private function toInt32(int $n): int
    {
        $n &= 0xFFFFFFFF;

        return $n >= 2147483648 ? $n - 4294967296 : $n;
    }
}
