@php
    \romanzipp\Seo\Facades\Seo::setSchemes(
        \App\Support\PublicStructuredData::build(
            $page ?? null,
            $pageTrans ?? null,
            $header ?? null,
            $post_category ?? null
        )
    );
@endphp

{{-- Romanzipp Laravel SEO owns all site-wide JSON-LD output. --}}
{!! \romanzipp\Seo\Facades\Seo::render() !!}
