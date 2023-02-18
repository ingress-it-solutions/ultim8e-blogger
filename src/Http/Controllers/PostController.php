<?php

namespace IngressITSolutions\Ultim8eBlogger\Http\Controllers;

use IngressITSolutions\Ultim8eBlogger\Models\Post;
use IngressITSolutions\Ultim8eBlogger\Repositories\PostRepository;

class PostController
{
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        return view('ultim8e-blogger::index', [
            'posts' => $this->postRepository->paginate(
                config('ultim8e-blogger.per_page'),
                config('ultim8e-blogger.page_indicator')
            ),
        ]);
    }

    public function show(Post $post)
    {
        return view('ultim8e-blogger::show', [
            'post' => $post,
        ]);
    }
}
