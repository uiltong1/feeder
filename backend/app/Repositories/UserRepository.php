<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     *
     * @param array $params
     */
    public function index(array $criteria): Collection|LengthAwarePaginator
    {
        $criteria = collect($criteria);

        $query = app(User::class)
            ->newQuery();

        if ($email = $criteria->get('email')) {
            $query->where('email', 'LIKE', "%{$email}%");
        }

        if ($name = $criteria->get('name')) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        if ($criteria->get('page')) {
            return $query->paginate(10);
        }

        return $query->get();
    }

    /**
     *
     * @param array $params
     * @return User
     */
    public function create(array $params): User
    {
        return User::create($params);
    }

    /**
     *
     * @param array $params
     * @return User
     */
    public function getById(int $id): User
    {
        return User::where('id', $id)->firstOrFail();
    }

    /**
     *
     * @param array $params
     * @return User
     */
    public function update(int $id, array $params): User
    {
        $user = $this->getById($id);
        $user->update($params);
        return $user;
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $user = $this->getById($id);
        $user->delete();
    }
}
