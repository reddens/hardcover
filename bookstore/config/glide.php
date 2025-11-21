<?php

return [
    'source' => storage_path('app/public'),
    'cache' => storage_path('app/glide'),
    'base_url' => 'img',
    'max_image_size' => 2000 * 2000,
    'presets' => [
        'small' => [
            'w' => 200,
            'h' => 300,
            'fit' => 'crop',
        ],
        'medium' => [
            'w' => 400,
            'h' => 600,
            'fit' => 'crop',
        ],
        'large' => [
            'w' => 800,
            'h' => 1200,
            'fit' => 'crop',
        ],
    ],
];