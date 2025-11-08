<?php

namespace App\Http\Controllers\Authenticate;

use App\Services\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authenticate\RegisterRequest;

class RegisterController extends Controller
{
    public function __construct(
        private Auth $authServices
    ) {}

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            return $this->authServices->register($request->validated());
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
