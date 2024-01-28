<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthServiceFactory;
use App\Traits\ApiResponseTrait;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * MovieController constructor.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $login = $request->input('login');
            $password = $request->input('password');
            //Authenticate the client
            $token = AuthServiceFactory::login($login, $password);
            return $this->successResponse(['status' => 'success', 'token' => $token]);
        } catch (Exception $e) {
            return $this->failureResponse();
        }
    }


}
