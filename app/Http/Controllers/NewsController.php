<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests;
use App\Repositories\Post\PostRepositoryInterface;

class NewsController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->index();

        return view('news.index', compact('posts'));
    }

    public function show($slug)
    {
        $latestPosts = $this->postRepository->latestPosts();

        $post = $this->postRepository->findBy($slug);

        return view('news.show', [
            'latestPosts' => $latestPosts,
            'post' => $post,
            'message' => isset($post['error']) ? $post['error'] : '',
        ]);
    }
}
