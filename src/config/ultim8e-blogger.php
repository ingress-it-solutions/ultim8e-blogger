<?php

return [
    // Storage location for the posts
    'posts_path' => base_path('posts'),

    'url' => 'blog',

    'per_page' => 10,

    // In pagination, what parameter is displayed for page number
    // i.e. http://mysite.test/blog?page=1
    'page_indicator' => 'page',

    // Register the ultim8e-blogger.index and ultim8e-blogger.show-routes
    // within the default web-middleware
    'register_routes' => true,
];
