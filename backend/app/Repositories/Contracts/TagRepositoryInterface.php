<?php

namespace App\Repositories\Contracts;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    /**
     *
     * @param array $params
     */
    public function index(array $params): Collection|LengthAwarePaginator;

    /**
     *
     * @param array $params
     * @return Tag
     */
    public function create(array $criteria): Tag;

    /**
     *
     * @param array $params
     * @return Tag
     */
    public function getById(int $id): Tag;

    /**
     *
     * @param integer $id
     * @param array $params
     * @return Tag
     */
    public function update(int $id, array $params): Tag;

    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void;
}
