<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use Error;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class TagService
{
    /**
     *
     * @param TagRepositoryInterface $repository
     */
    public function __construct(
        private TagRepositoryInterface $repository
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
            Log::error("Failed to list tags", [
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
     * @return Tag
     */
    public function store(array $params): Tag
    {
        try {
            return $this->repository->create($params);
        } catch (Throwable $e) {
            Log::error("Failed to create tag", [
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
     * @return Tag
     */
    public function getById(int $id): Tag
    {
        try {
            return $this->repository->getById($id);
        } catch (Throwable $e) {
            Log::error("Failed to create tag", [
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
     * @return Tag
     */
    public function update(int $id, array $params): Tag
    {
        try {
            return $this->repository->update($id, $params);
        } catch (Throwable $e) {
            Log::error("Failed to update tag", [
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
            $tag = $this->getById($id);
            if ($tag->posts->count()) {
                throw new Error("A tag não pode ser excluído, pois está em uso.");
            }

            $this->repository->delete($id);
        } catch (Throwable $e) {
            Log::error("Failed to delete tag", [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'id'  => $id
            ]);
            throw $e;
        }
    }
}
