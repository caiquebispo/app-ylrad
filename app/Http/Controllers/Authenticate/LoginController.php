<?php

namespace App\Http\Controllers\Authenticate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate\LoginRequest;
use App\Services\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{

    public function __construct(
        private Auth $authServices
    ) {}

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            return $this->authServices->attempt($request->validated());
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
