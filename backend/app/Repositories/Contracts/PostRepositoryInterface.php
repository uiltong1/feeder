<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    /**
     *
     * @param array $params
     */
    public function index(array $params): Collection|LengthAwarePaginator;

    /**
     *
     * @param array $params
     * @return Post
     */
    public function create(array $criteria): Post;

    /**
     *
     * @param array $params
     * @return Post
     */
    public function getById(int $id): Post;

    /**
     *
     * @param integer $id
     * @param array $params
     * @return Post
     */
    public function update(int $id, array $params): Post;

    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void;
}
