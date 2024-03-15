<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class PostService
{
    /**
     *
     * @param PostRepositoryInterface $repository
     */
    public function __construct(
        private PostRepositoryInterface $repository
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
            Log::error("Failed to list posts", [
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
     * @return Post
     */
    public function store(array $params): Post
    {
        try {
            return $this->repository->create($params);
        } catch (Throwable $e) {
            Log::error("Failed to create post", [
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
     * @return Post
     */
    public function getById(int $id): Post
    {
        try {
            return $this->repository->getById($id);
        } catch (Throwable $e) {
            Log::error("Failed to create post", [
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
     * @return Post
     */
    public function update(int $id, array $params): Post
    {
        try {
            return $this->repository->update($id, $params);
        } catch (Throwable $e) {
            Log::error("Failed to update post", [
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
            $this->repository->delete($id);
        } catch (Throwable $e) {
            Log::error("Failed to delete post", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'id'  => $id
            ]);
            throw $e;
        }
    }
}
