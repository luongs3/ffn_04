<?php

namespace App\Repositories\Post;

interface PostRepositoryInterface
{
    public function index();

    public function find($id);

    public function findBy($slug);

    public function latestPosts();
}
