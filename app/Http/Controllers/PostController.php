<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Post\PostService;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

/**
 * Class PostController
 *
 * @package App\Http\Controllers
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
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data['items'] = $this->service->index($request->all());

        return view('post.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCreateRequest $request
     *
     * @return RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        $request->validated();
        $resp = $this->service->create($request->all());

        return $resp['success']
            ? redirect()->route('post.index')->with(['resp' => $resp])
            : redirect()->back()->with(['resp' => $resp])->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function edit(int $id)
    {
        $data['entity'] = $this->service->getUpdateModel($id);
        if (!$data['entity']) {
            abort(404, 'The Quote was not found');
        }
        return view('post.update', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostUpdateRequest $request
     * @param int               $id
     *
     * @return RedirectResponse
     */
    public function update(PostUpdateRequest $request, int $id)
    {
        $request->validated();
        $resp = $this->service->update($id, $request->all());

        return $resp['success']
            ? redirect()->route('post.index')->with(['resp' => $resp])
            : redirect()->back()->with(['resp' => $resp])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
