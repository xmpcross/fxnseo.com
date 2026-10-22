<?php

use romanzipp\Seo\Builders\StructBuilder;

return [
    /*
     * fxnSEO's standard meta, Open Graph, and X/Twitter tags are rendered by
     * Meta Manager. Keep Romanzipp's shorthand disabled to prevent duplicate
     * tags; this package is the single renderer for JSON-LD structured data.
     */
    'shorthand' => [
        'title' => [
            'tag' => false,
            'opengraph' => false,
            'twitter' => false,
            'embedx' => false,
        ],
        'description' => [
            'meta' => false,
            'opengraph' => false,
            'twitter' => false,
            'embedx' => false,
        ],
        'image' => [
            'meta' => false,
            'opengraph' => false,
            'twitter' => false,
            'embedx' => false,
        ],
    ],

    'tag_syntax' => StructBuilder::TAG_SYNTAX_HTML5,
];
