<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Post\PostRepositoryInterface;

use App\Http\Requests;

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

        return view('news.show', compact('latestPosts', 'post'));
    }
}
