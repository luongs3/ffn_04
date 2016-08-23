<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repositories\Comment\CommentRepositoryInterface;
use Auth;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->ajax()) {
            $comment = [
                'user_id' => Auth::user()->id,
                'content' => request()->get('content'),
                'commentable_id' => request()->get('postId'),
                'commentable_type' => config('common.comment.commentable_type.post_id'),
            ];

            $createComment = $this->commentRepository->store($comment);

            if (isset($createComment['errors'])) {
                session()->flash('error', $data['errors']['message']);

                return response()->json(['success' => false]);
            }

            return response()->json(['success' => true]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (request()->ajax()) {
            $comment = [
                'content' => request()->get('content'),
            ];

            $updateComment = $this->commentRepository->update($comment, request()->get('id'));

            $dataComment = [
                'content' => request()->get('content'),
            ];

            if (isset($updateComment['errors'])) {
                session()->flash('error', $data['errors']['message']);

                return response()->json(['success' => false]);
            }

            return response()->json(['dataComment' => $dataComment]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commentData = $this->commentRepository->delete($id);

        if (isset($commentData['errors'])) {
            session()->flash('error', $data['errors']['message']);

            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }
}
