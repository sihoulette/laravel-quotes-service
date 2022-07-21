<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

/**
 * Class PassportAuthController
 *
 * @package App\Http\Controllers\Api
 */
final class PassportAuthController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     * @author sihoullete
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        DB::beginTransaction();
        try {
            $resp['success'] = true;
            $user = User::create($data);
            event(new Registered($user));
            $resp['user'] = $user;
            $resp['token'] = $user->createToken('Laravel9PassportAuth')->accessToken;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $resp['success'] = false;
            $resp['exception'] = $e->getMessage();
        }

        return response()->json($resp, $resp['success'] ? 200 : 401);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     * @author sihoullete
     */
    public function login(LoginRequest $request)
    {
        $resp['success'] = false;
        $data = $request->only(['email', 'password']);
        if (auth()->attempt($data)) {
            $resp['success'] = true;
            $resp['token'] = auth()->user()
                ->createToken('Laravel9PassportAuth')->accessToken;
        } else {
            $resp['error'] = 'Unauthorised';
        }

        return response()->json($resp, $resp['success'] ? 200 : 401);
    }
}
