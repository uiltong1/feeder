<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @subgroup  Users
 * @subgroupDescription User management
 */

class UserController extends Controller
{
    /**
     *
     * @param UserService $service
     */
    public function __construct(
        private UserService $service
    ) {
    }

    /**
     * Get list of users
     * @queryParam email string
     * @queryParam name string
     * @queryParam page integer
     * 
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        try {
            return response($this->service->index($request->all()), Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response([
                'title' => 'Error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], $e->getCode() !== 0 ?
                $e->getCode() : Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Create a new user
     * 
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request): Response
    {
        try {
            return response(
                $this->service->store($request->all()),
                Response::HTTP_CREATED
            );
        } catch (\Throwable $e) {
            return response([
                'title' => 'Error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], $e->getCode() !== 0 ?
                $e->getCode() : Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get a user
     * @urlParam id integer required
     * 
     * @param Request $request
     * @return Response
     */
    public function show(int $id): Response
    {
        try {
            return response($this->service->getById($id), Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response([
                'title' => 'Error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], $e->getCode() !== 0 ?
                $e->getCode() : Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update a user
     * @urlParam id integer required 
     * 
     * @param UserRequest $request
     * @return Response
     */
    public function update(int $id, UserRequest $request): Response
    {
        try {
            return response(
                $this->service->update(
                    $id,
                    $request->all()
                ),
                Response::HTTP_OK
            );
        } catch (\Throwable $e) {
            return response([
                'title' => 'Error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], $e->getCode() !== 0 ?
                $e->getCode() : Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete a user
     * @urlParam id integer required
     * 
     * @return Response
     */
    public function destroy(int $id): Response
    {
        try {
            $this->service->delete(
                $id
            );
            return response(
                null,
                Response::HTTP_NO_CONTENT
            );
        } catch (\Throwable $e) {
            return response([
                'title' => 'Error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
            ], $e->getCode() !== 0 ?
                $e->getCode() : Response::HTTP_BAD_REQUEST);
        }
    }
}
