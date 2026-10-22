<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Str;

class Page extends Model implements TranslatableContract
{
    use Translatable, HasFactory, Sluggable;

    public $translatedAttributes = ['sitename_status', 'robots_meta', 'page_title', 'title', 'locale', 'subtitle', 'short_description', 'description'];
    protected $fillable          = ['slug', 'target', 'type', 'featured_image'];

    protected $table             = 'pages';
    protected $guarded           = [];

    protected $casts = [
        'post_status' => 'boolean',
        'page_status' => 'boolean',
        'tool_status' => 'boolean',
        'ads_status'  => 'boolean',
        'popular'     => 'boolean'
    ];

    /**
     * Ensure any remote featured image is automatically downloaded and stored locally.
     */
    protected static function booted()
    {
        static::saving(function ($page) {
            if (!empty($page->featured_image)) {
                $page->featured_image = self::localizeFeaturedImage($page->featured_image, $page->slug);
            }
        });
    }

    /**
     * Download external images to local disk and return the local URL.
     */
    public static function localizeFeaturedImage(string $image, ?string $slug = null): string
    {
        $appUrl = rtrim((string) env('APP_URL', 'https://fxnseo.com'), '/');

        // If already local, leave as-is
        if (str_starts_with($image, $appUrl) || str_starts_with($image, '/assets/') || str_starts_with($image, '/photos/')) {
            return $image;
        }

        // If external URL, download and save locally
        if (preg_match('#^https?://#i', $image)) {
            try {
                $targetDir = realpath(base_path('../assets/img/posts')) ?: base_path('../assets/img/posts');
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }

                $filename = basename(parse_url($image, PHP_URL_PATH));
                if (!$filename || !preg_match('/\.(jpg|jpeg|png|webp|gif|svg)$/i', $filename)) {
                    $ext = 'jpg';
                    $filename = ($slug ? Str::slug($slug) : 'post_' . time()) . '.' . $ext;
                }

                $destPath = $targetDir . '/' . $filename;

                $ch = curl_init($image);
                $fp = @fopen($destPath, 'wb');
                if ($fp) {
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 12);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $host = parse_url($image, PHP_URL_HOST);
                    if ($host === 'cms.fxnstudio.com' || $host === 'strapi.fxnstudio.com') {
                        curl_setopt($ch, CURLOPT_RESOLVE, ["{$host}:443:51.161.208.188"]);
                    }
                    curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                    fclose($fp);

                    if ($httpCode >= 200 && $httpCode < 300 && file_exists($destPath) && filesize($destPath) > 500) {
                        @chmod($destPath, 0644);
                        @chown($destPath, 'www-data');
                        return $appUrl . '/assets/img/posts/' . $filename;
                    } else {
                        @unlink($destPath);
                    }
                }
            } catch (\Throwable $e) {
                // fall through to return original on failure
            }
        }

        return $image;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    public function page_categories() {
        return $this->belongsTo(PageCategory::class, 'category_id');
    }

    public function category() {
        return $this->belongsTo(PageCategory::class, 'category_id');
    }
}
