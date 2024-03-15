<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @subgroup  Posts
 * @subgroupDescription Post management
 */
class PostController extends Controller
{
    /**
     *
     * @param PostService $service
     */
    public function __construct(
        private PostService $service
    ) {
    }

    /**
     * Get list of posts
     * @queryParam title string
     * @queryParam body string
     * @queryParam user_id integer
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
     * Create a new post
     * 
     * @param PostRequest $request
     * @return Response
     */
    public function store(PostRequest $request): Response
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
     * Get a post
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
     * Update a post
     * @urlParam id integer required 
     * 
     * @param PostRequest $request
     * @return Response
     */
    public function update(int $id, PostRequest $request): Response
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
     * Delete a post
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
