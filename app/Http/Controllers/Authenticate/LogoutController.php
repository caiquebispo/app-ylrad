<?php

namespace App\Http\Controllers\Authenticate;

use App\Services\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LogoutController extends Controller implements HasMiddleware
{

    public function __construct(
        private Auth $authServices
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum')
        ];
    }
    public function logout(): JsonResponse
    {
        try {
            return $this->authServices->logout();
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
