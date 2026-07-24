<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

/**
 * Thin read client for the Strapi CMS `fxnseo-post` content type.
 *
 * Talks to Strapi over the internal address (STRAPI_URL, e.g. http://127.0.0.1:8888).
 * Media URLs returned by Strapi are host-relative (/uploads/...); mediaUrl()
 * rewrites them to an absolute, browser-reachable URL using STRAPI_PUBLIC_URL
 * (falling back to STRAPI_URL when no public host is configured).
 */
class StrapiClient
{
    protected string $base;
    protected string $publicBase;
    protected ?string $token;

    public function __construct()
    {
        $this->base       = rtrim((string) env('STRAPI_URL', 'http://127.0.0.1:8888'), '/');
        $this->publicBase = rtrim((string) (env('STRAPI_PUBLIC_URL') ?: env('STRAPI_URL', '')), '/');
        $this->token      = env('STRAPI_TOKEN') ?: null;
    }

    protected function request()
    {
        $req = Http::timeout(8)->acceptJson();

        return $this->token ? $req->withToken($this->token) : $req;
    }

    /** Paginated list of published posts, newest first. Returns Strapi's {data, meta}. */
    public function posts(int $page = 1, int $pageSize = 12): array
    {
        try {
            $res = $this->request()->get($this->base . '/api/fxnseo-posts', [
                'sort'                  => 'publishedAt:desc',
                'pagination[page]'      => $page,
                'pagination[pageSize]'  => $pageSize,
                'populate'              => 'coverImage',
            ]);

            if ($res->ok()) {
                return $res->json() ?: ['data' => [], 'meta' => []];
            }
        } catch (\Throwable $e) {
            // fall through to empty set — the page still renders
        }

        return ['data' => [], 'meta' => ['pagination' => ['page' => 1, 'pageCount' => 0, 'total' => 0]]];
    }

    /** A single published post by slug, or null if not found. */
    public function post(string $slug): ?array
    {
        try {
            $res = $this->request()->get($this->base . '/api/fxnseo-posts', [
                'filters[slug][$eq]'   => $slug,
                'populate'             => 'coverImage',
                'pagination[pageSize]' => 1,
            ]);

            if ($res->ok()) {
                $data = $res->json('data');

                return $data[0] ?? null;
            }
        } catch (\Throwable $e) {
            // fall through
        }

        return null;
    }

    /** Absolute, browser-reachable URL for a Strapi media object (flattened v5 shape). */
    public function mediaUrl($media): ?string
    {
        if (empty($media) || empty($media['url'])) {
            return null;
        }

        $url = $media['url'];

        // Already absolute
        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        return $this->publicBase . '/' . ltrim($url, '/');
    }
}
