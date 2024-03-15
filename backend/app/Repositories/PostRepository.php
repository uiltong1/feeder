<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostRepository implements PostRepositoryInterface
{
    /**
     *
     * @param array $params
     */
    public function index(array $criteria): Collection|LengthAwarePaginator
    {
        $criteria = collect($criteria);

        $query = app(Post::class)->with('user', 'tags')
            ->newQuery();

        if ($title = $criteria->get('title')) {
            $query->where('title', 'LIKE', "%{$title}%");
        }

        if ($body = $criteria->get('body')) {
            $query->where('body', 'LIKE', "%{$body}%");
        }

        if ($userId = $criteria->get('user_id')) {
            $query->where('user_id', 'LIKE', "%{$userId}%");
        }

        if ($criteria->get('page')) {
            return $query->paginate(10);
        }

        return $query->get();
    }

    /**
     *
     * @param array $params
     * @return Post
     */
    public function create(array $params): Post
    {
        $post = Post::create($params);
        $post->tags()->sync($params['tags']);
        return $this->getById($post->id);
    }

    /**
     *
     * @param array $params
     * @return Post
     */
    public function getById(int $id): Post
    {
        return Post::where('id', $id)->with('user', 'tags')->firstOrFail();
    }

    /**
     *
     * @param array $params
     * @return Post
     */
    public function update(int $id, array $params): Post
    {
        $post = $this->getById($id);
        $post->tags()->sync($params['tags']);
        $post->update($params);
        return $this->getById($id);
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $post = $this->getById($id);
        $post->delete();
    }
}
