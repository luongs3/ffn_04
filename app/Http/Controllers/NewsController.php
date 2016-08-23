<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;

class NewsController extends Controller
{
    protected $postRepository;
    protected $commentRepository;

    public function __construct(
        PostRepositoryInterface $postRepository,
        CommentRepositoryInterface $commentRepository
    )
    {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
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
        $comments = $this->commentRepository->get($post->id);

        return view('news.show', [
            'latestPosts' => $latestPosts,
            'post' => $post,
            'comments' => $comments,
            'message' => isset($post['error']) ? $post['error'] : '',
        ]);
    }
}
