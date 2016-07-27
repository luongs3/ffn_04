<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\Post\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    protected $postRepository ;
    
    public function __construct(Post $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    
    public function index()
    {
        return Post::latest('published_at')->published()
            ->orderBy('published_at', 'desc')
            ->paginate(config('news.posts_per_page'));
    }

    public function find($id)
    {
        return $this->postRepository->find($id);
    }

    public function findBy($slug)
    {
        return $this->postRepository->whereSlug($slug)->firstOrFail();
    }

    public function latestPosts()
    {
        return Post::latest('published_at')->published()->take(config('news.latest_posts'))->get();
    }
}
