<?php

namespace App\Http\Middleware;

use App\Models\Admin\Page;
use Closure;
use Illuminate\Http\Request;

class RedirectLegacyPost
{
    public function handle(Request $request, Closure $next)
    {
        $post = Page::with('translations')->where('slug', $request->route('slug'))
            ->where('type', 'post')->where('post_status', true)->first();

        if ($post) {
            $destination = $post->hasTranslation(app()->getLocale())
                ? route('public.blog', ['slug' => $post->slug])
                : url('/blog/' . $post->slug);

            return redirect()->to($destination, 301);
        }

        return $next($request);
    }
}
