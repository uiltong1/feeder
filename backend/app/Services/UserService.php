<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Error;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class UserService
{
    /**
     *
     * @param UserRepositoryInterface $repository
     */
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    /**
     *
     * @param array $params
     * @return Collection|LengthAwarePaginator
     */
    public function index(array $params): Collection|LengthAwarePaginator
    {
        try {
            return $this->repository->index($params);
        } catch (Throwable $e) {
            Log::error("Failed to list users", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'params'  => $params
            ]);
            throw $e;
        }
    }

    /**
     *
     * @param array $params
     * @return User
     */
    public function store(array $params): User
    {
        try {
            return $this->repository->create($params);
        } catch (Throwable $e) {
            Log::error("Failed to create user", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'params'  => $params
            ]);
            throw $e;
        }
    }


    /**
     *
     * @param integer $id
     * @return User
     */
    public function getById(int $id): User
    {
        try {
            return $this->repository->getById($id);
        } catch (Throwable $e) {
            Log::error("Failed to create user", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'id'  => $id
            ]);
            throw $e;
        }
    }

    /**
     *
     * @param integer $id
     * @param array $params
     * @return User
     */
    public function update(int $id, array $params): User
    {
        try {
            return $this->repository->update($id, $params);
        } catch (Throwable $e) {
            Log::error("Failed to update user", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'id'  => $id
            ]);
            throw $e;
        }
    }


    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        try {

            $user = $this->getById($id);
            if ($user?->posts->count()) {
                throw new Error("Não é possível excluir usuários que tem posts vinculados");
            }

            $this->repository->delete($id);
        } catch (Throwable $e) {
            Log::error("Failed to delete user", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'id'  => $id
            ]);
            throw $e;
        }
    }
}
