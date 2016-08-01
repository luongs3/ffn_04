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

        return view('news.create', compact('catsList', 'leaguesList'));
    }

    public function store(Requests\PostRequest $request)
    {
        $createdPost = $this->postRepository->createOrUpdate($request);

        if ($createdPost) {
            Alert::success(trans('news.post_created_success'), trans('news.good_job'))->persistent(trans('news.close'));
        } else {
            Alert::error(trans('news.error_general'), trans('news.oops'));
        }

        return redirect()->action('NewsController@index');
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

        return redirect()->action('NewsController@index');
    }

    public function edit($id)
    {
        $post = $this->postRepository->find($id);

        if ($post->isOwnedBy(Auth::user())) {
            $catsList = Category::lists('name','id');
            $leaguesList = League::lists('name','id');

            $post = $this->postRepository->find($id);

            return view('news.edit', compact('post', 'catsList', 'leaguesList'));
        } else {
            abort(403, trans('general.403'));
        }
    }
}
