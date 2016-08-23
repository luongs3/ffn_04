<?php

namespace App\Repositories\Comment;

interface CommentRepositoryInterface
{
    public function index($subject, $options = []);
    public function show($id);
    public function store($data);
    public function all($filters = []);
    public function update($data, $id);
    public function delete($id);
}
