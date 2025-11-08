<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Address\AddressRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Auth
{

    /**
     * @param array $credentials
     * @return JsonResponse
     */

    public static function attempt(array $credentials): JsonResponse
    {

        if (!auth()->attempt($credentials)) {

            return response()->json([
                'meta' => [
                    'code' => Response::HTTP_UNAUTHORIZED,
                    'status' => 'fail',
                    'message' => 'The provided credentials are incorrect.',
                ],
                'data' => [
                    'user' => []
                ],
                'access_token' => [
                    'token' => '',
                    'type' => 'Bearer'
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }

        static::revokingTokens();

        return response()->json([
            'meta' => [
                'code' => Response::HTTP_ACCEPTED,
                'status' => 'success',
                'message' => 'Login success.',
            ],
            'data' => [
                'user' => auth()->user()
            ],
            'access_token' => [
                'token' => auth()->user()->createToken($credentials['email'])->plainTextToken,
                'type' => 'Bearer'
            ],
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public static function register(array $data): JsonResponse
    {


        $user = User::create($data);

        /** @var User $user */

        return response()->json([
            'meta' => [
                'code' => Response::HTTP_CREATED,
                'status' => 'success',
                'message' => 'User created successfully!',
            ],
            'data' => [
                'user' => $user,
            ],
            'access_token' => [
                'token' => $user->createToken($user->email)->plainTextToken,
                'type' => 'Bearer'
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    public static function logout(): JsonResponse
    {
        static::revokingTokens();

        return response()->json([
            'meta' => [
                'code' => Response::HTTP_ACCEPTED,
                'status' => 'success',
                'message' => 'Successfully logged out',
            ],
            'data' => [],
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * @return JsonResponse
     */
    public static function user(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'meta' => [
                'code' => Response::HTTP_ACCEPTED,
                'status' => 'success',
            ],
            'data' => [
                'user' => $user
            ],
            'access_token' => [
                'token' => $user->createToken($user->email)->plainTextToken,
                'type' => 'Bearer'
            ],
        ], Response::HTTP_ACCEPTED);
    }

    /**
     * @param int|null $id
     * @return void
     */
    public static function revokingTokens(?int $id = null): void
    {
        if ($id) {
            auth()->user()->tokens('id', $id)->delete();
        }
        auth()->user()->tokens()->delete();
    }
}
