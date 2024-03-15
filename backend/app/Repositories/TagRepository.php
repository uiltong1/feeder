<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TagRepository implements TagRepositoryInterface
{
    /**
     *
     * @param array $params
     */
    public function index(array $criteria): Collection|LengthAwarePaginator
    {
        $criteria = collect($criteria);

        $query = app(Tag::class)
            ->newQuery();

        if ($slug = $criteria->get('slug')) {
            $query->where('slug', 'LIKE', "%{$slug}%");
        }

        if ($criteria->get('page')) {
            return $query->paginate(10);
        }

        return $query->get();
    }

    /**
     *
     * @param array $params
     * @return Tag
     */
    public function create(array $params): Tag
    {
        return Tag::create($params);
    }

    /**
     *
     * @param array $params
     * @return Tag
     */
    public function getById(int $id): Tag
    {
        return Tag::where('id', $id)->firstOrFail();
    }

    /**
     *
     * @param array $params
     * @return Tag
     */
    public function update(int $id, array $params): Tag
    {
        $tag = $this->getById($id);
        $tag->update($params);
        return $tag;
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $tag = $this->getById($id);
        $tag->delete();
    }
}
