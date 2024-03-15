<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     *
     * @param array $params
     */
    public function index(array $params): Collection|LengthAwarePaginator;

    /**
     *
     * @param array $params
     * @return User
     */
    public function create(array $criteria): User;

    /**
     *
     * @param array $params
     * @return User
     */
    public function getById(int $id): User;

    /**
     *
     * @param integer $id
     * @param array $params
     * @return User
     */
    public function update(int $id, array $params): User;

    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void;
}
