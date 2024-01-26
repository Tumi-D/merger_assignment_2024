<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\AuthServiceFactory;
use App\Traits\ApiResponseTrait;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    use ApiResponseTrait;
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $login = $request->input('login');
            $password = $request->input('password');
            //Authenticate the client
            $token = AuthServiceFactory::login($login, $password);
            return $this->successResponse(['status' => 'success','token' => $token]);
        } catch (Exception $e) {
            return $this->failureResponse();
        }
    }


}
