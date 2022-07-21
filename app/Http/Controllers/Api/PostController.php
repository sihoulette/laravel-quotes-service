<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Requests\PostCreateRequest;
use App\Http\Resources\PostResource;
use App\Services\Post\PostService;
use App\Http\Controllers\Controller;

/**
 * Class PostController
 *
 * @package App\Http\Controllers\Api
 */
final class PostController extends Controller
{
    /**
     * @var PostService $service
     */
    public PostService $service;

    /**
     * @param PostService $service
     */
    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return PostResource
     */
    public function index(Request $request)
    {
        $posts = $this->service->index($request->all());

        return new PostResource($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCreateRequest $request
     *
     * @return JsonResponse
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();
        $resp = $this->service->create($data);

        return response()->json($resp);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostUpdateRequest $request
     * @param int               $id
     *
     * @return JsonResponse
     */
    public function update(PostUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $resp = $this->service->update($id, $data);

        return response()->json($resp);
    }
}
