<?php

namespace App\Repositories\Comment;


use App\Repositories\BaseRepository;
use App\Models\Comment;
use Exception;
use Auth;
use DB;


class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }

    public function get($postId)
    {
        $limit = isset($options['limit']) ? $options['limit'] : config('common.limit.page_limit');
        $order = isset($options['order']) ? $options['order'] : ['key' => 'id', 'aspect' => 'DESC'];

        $comments = $this->model->where('commentable_type', config('common.comment.commentable_type.post_id'))
            ->where('commentable_id', $postId)
            ->orderBy($order['key'], $order['aspect'])
            ->paginate($limit);

        return $comments;
    }
}
