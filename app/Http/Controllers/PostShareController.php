<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostShareEmailRequest;
use App\Http\Requests\PostShareViberRequest;
use App\Http\Requests\PostShareTelegramRequest;
use App\Services\Post\PostSocialService;
use Illuminate\Http\JsonResponse;

/**
 * Class PostShareController
 *
 * @package App\Http\Controllers
 */
final class PostShareController extends Controller
{
    /**
     * @var PostSocialService service
     */
    public PostSocialService $service;

    /**
     * @param PostSocialService $service
     */
    public function __construct(PostSocialService $service)
    {
        $this->service = $service;
    }

    /**
     * @param PostShareTelegramRequest $request
     *
     * @return JsonResponse
     *
     * @author sihoullete
     */
    public function telegram(PostShareTelegramRequest $request): JsonResponse
    {
        $data = $request->validated();
        $resp = $this->service->telegram($data);

        return response()->json($resp);
    }

    /**
     * @param PostShareViberRequest $request
     *
     * @return JsonResponse
     *
     * @author sihoullete
     */
    public function viber(PostShareViberRequest $request): JsonResponse
    {
        $data = $request->validated();
        $resp = $this->service->viber($data);

        return response()->json($resp);
    }

    /**
     * @param PostShareEmailRequest $request
     *
     * @return JsonResponse
     *
     * @author sihoullete
     */
    public function email(PostShareEmailRequest $request): JsonResponse
    {
        $data = $request->validated();
        $resp = $this->service->email($data);

        return response()->json($resp);
    }
}
