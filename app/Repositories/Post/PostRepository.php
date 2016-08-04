<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Auth;
use Request;
use App\Repositories\Post\PostRepositoryInterface;
use Carbon\Carbon;

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

    public function createOrUpdate($request, $id = null)
    {
        $post = Post::findOrNew($id);
        
        $post->user_id = $request->user_id;
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->league_id = $request->league_id;
        $post->content = $request->content;
        $post->published_at = Carbon::now();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = str_slug($post->title) . '-' . $image->getClientOriginalName();
            $request->file('image')->move(public_path(config('news.posts_image_path')), $filename);
            $post->image = config('news.posts_image_path') . $filename;
        } else {
            if (Request::isMethod('post')) {
                $post->image = config('news.posts_image_default');
            }
        }

        return $post->save();
    }
}
