<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @subgroup  Tags
 * @subgroupDescription Tags management
 */
class TagController extends Controller
{
    /**
     *
     * @param TagService $service
     */
    public function __construct(
        private TagService $service
    ) {
    }

    /**
     * Get list of tags
     * @queryParam slug string
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
     * Create a new tag
     *
     * @param TagRequest $request
     * @return Response
     */
    public function store(TagRequest $request): Response
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
     * Get a tag
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
     * Update a tag
     * @urlParam id integer required 
     * 
     * @param TagRequest $request
     * @return Response
     */
    public function update(int $id, TagRequest $request): Response
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
     * Update a tag
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
