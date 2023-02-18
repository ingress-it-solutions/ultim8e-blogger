# Ultim8eBlogger

Plug-and-play flat file markdown blog tool for your Laravel-project. Create an article or blog-section on your site without the hassle of setting up tables, models or your own flat file-system.

Built upon [spatie/sheets](https://github.com/spatie/sheets) to handle the markdown-files and YAML-front matter parsing.

> Note: This package is built for quick and easy setup and use – don't expect a fully featured CMS.

### 🛠 Install and configure

Require package:

```
$ composer require ingress-it-solutions/ultim8e-blogger
```

Publish config-files and views:

```
$ php artisan vendor:publish --provider="IngressITSolutions\Ultim8eBlogger\Ultim8eBloggerServiceProvider"
```

In `config/ultim8e-blogger.php` you can now customize the settings to your liking. Views are available at `resources/views/vendor/ultim8e-blogger`

### ✏️ Writing posts

#### Filename format

All posts should be stores in your `posts_path`-directory with the filename format of `2021-03-30.my-post.md`, i.e. `{date:Y-m-d}.{slug}.md`.

The slug is what determins at what URL your post will be available at.

#### Artisan command

You can quickly create a new post via the artisan command:

```
php artisan ultim8e-blogger:new
```

#### YAML front matter

Posts can contain any number of attributes via YAML-front matter:

```
---
title: This is a new post
date: '2020-01-01 20:00:01'
cover: https://ultim8e.com/my-cover.jpg
---

My post in **Markdown**
```

### 🖥 Displaying posts

Two views are shipped with this package; an index-view and a show-view (used for single posts). They are located in `/resources/vendor/views/ultim8e-blogger` after installation and are fully customizable.

In `index.blade.php` a collection of post-objects is available via the `$posts`-variable. It behaves much as a standard Eloquent-collection.

```php
@foreach ($posts as $post)
    <h2>{{ $post->title }}</h2>
    <div>
        {!! $post->contents !!}
    </div>
@endforeach
```

Pagination-links are also available:

```php
{{ $posts->links() }}
```

The Post-object contains all your front matter attributes as well as `slug`, `date` and `contents`.

```php
{{ $post->slug }} // my-post
{{ $post->date->format('Y-m-d') }} // 2021-03-30
{{ $post->contents }} // <p>My post in <strong>markdown</strong></p>
{{ $post->cover }} // https://ultim8e.com/my-cover.jpg
```

#### Retrieve posts in your application

You can retrieve posts and filter them as a collection anywhere in your application using the Post-model:

```php
use IngressITSolutions\Ultim8eBlogger\Models\Post;

// Reject posts where is_draft is true or has a date in the future
$posts = Post::all()->reject(function ($item) {
  return $item->is_draft || $post->date->lessThan(now());
});
```

The posts are sorted by descending date per default, so to get the latest post:

```php
// Get first post
$post = Post::all()->first();
```

### 🚦 Routes

The package routes are `ultim8e-blogger.index` and `ultim8e-blogger.show`:

```php
{{ route('ultim8e-blogger.index') }} // http://mysite.test/blog

@foreach ($posts as $post)
    // The show-route accepts either a IngressITSolutions\Ultim8eBlogger\Models\Post-object
    // or a string; the post's slug
    {{ route('ultim8e-blogger.show', $post) }} // http://mysite.test/blog/post-slug
    {{ route('ultim8e-blogger.show', 'post-slug') }} // http://mysite.test/blog/post-slug
@endforeach
```

#### Defining your own routes

The default routes are registered with the ultim8e-blogger-name and the default web-middleware group.

If you by any reason want to override this (for example if you want to have your articles behind a login or maybe you don't use the standard web-middleware group), you may set `register_routes` to `false` in ultim8e-blogger.php, and then register them yourself:

```php
// /routes/web.php
use IngressITSolutions\Ultim8eBlogger\Http\Controllers\PostController;

Route::group(['middleware' => 'can:read', function() {
    Route::get('/articles', [PostController::class, 'index'])->name('article.index');
    Route::get('/articles/{post}', [PostController::class, 'show'])->name('article.show');
}]);

// A link to the blog index in some view
{{ route('article.index') }} // http://mysite.test/articles
```

### See it in action

Sites in the wild that uses Ultim8eBlogger

Ingress IT Solutions has developed various Laravel Products and we would like to but together everything under 1 roof so we decided to launch [Ultim8e Apps](https://ultim8e.com)

This Ultim8eBlogger package is currently used at [Ultim8e.com](https://ultim8e.com)

_Do you use Ultim8eBlogger and want your site featured here? Submit a PR!_

### License

The MIT License (MIT). Please see the [LICENSE.md](LICENSE.md) for more information.

© 2023 [Ingress IT Solutions](https://www.ingressit.com).
