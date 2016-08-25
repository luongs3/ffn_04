<?php

namespace App\Http\Controllers\Admin;

use Alert;
use App\Models\Category;
use App\Models\League;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Post\PostRepositoryInterface;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function create()
    {
        $catsList = Category::lists('name','id');
        $leaguesList = League::lists('name','id');
        $optionPost = $this->postRepository->optionPost();

        return view('news.create', compact('catsList', 'leaguesList', 'optionPost'));
    }

    public function store(Requests\PostRequest $request)
    {
        $createdPost = $this->postRepository->createOrUpdate($request);

        if ($createdPost) {
            Alert::success(trans('news.post_created_success'), trans('news.good_job'))->persistent(trans('news.close'));
        } else {
            Alert::error(trans('news.error_general'), trans('news.oops'));
        }

        return redirect()->route('admin.posts.index');
    }

    public function update(Requests\PostRequest $request, $id)
    {
        $post = $this->postRepository->find($id);

        if ($post->isOwnedBy(Auth::user())) {
            $updatedPost = $this->postRepository->createOrUpdate($request, $id);

            if ($updatedPost) {
                Alert::success(trans('news.post_updated_success'),
                    trans('news.good_job'))->persistent(trans('news.close'));
            } else {
                Alert::error(trans('news.error_general'), trans('news.oops'));
            }
        } else {
            abort(403, trans('general.403'));
        }

        return redirect()->route('admin.posts.index');
    }

    public function edit($id)
    {
        $post = $this->postRepository->find($id);
        $optionPost = $this->postRepository->optionPost();

        if ($post->isOwnedBy(Auth::user())) {
            $catsList = Category::lists('name','id');
            $leaguesList = League::lists('name','id');
            $post = $this->postRepository->find($id);

            return view('news.edit', compact('post', 'catsList', 'leaguesList', 'optionPost'));
        } else {
            abort(403, trans('general.403'));
        }
    }

    public function index()
    {
        $posts = $this->postRepository->lists();
        $optionPost = $this->postRepository->optionPost();

        return view('admin.post.index', [
            'posts' => $posts,
            'optionPost' => $optionPost,
        ]);
    }

    public function destroy($id)
    {
        if (request()->has('ids')) {
            $ids = request()->get('ids');
            $data = $this->postRepository->destroy($ids);

            if (isset($data['errors'])) {
                session()->flash('error', $data['errors']['message']);

                return response()->json(['success' => false, 'ids' => []]);
            }

            return response()->json(['ids' => $ids]);
        }

        session()->flash('error', trans('message.item_not_exist'));

        return response()->json(['success' => false, 'ids' => []]);
    }

    public function show($id)
    {
        $post = $this->postRepository->findPost($id);
        $optionPost = $this->postRepository->optionPost();

        return view('admin.post.show', [
            'post' => $post,
            'optionPost' => $optionPost,
            'message' => isset($post['error']) ? $post['error'] : '',
        ]);
    }
}
