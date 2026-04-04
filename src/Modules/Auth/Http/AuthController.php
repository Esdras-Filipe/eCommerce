<?php

namespace Modules\Auth\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Application\UseCases\LoginUser;
use Modules\Auth\Application\UseCases\RegisterUser;
use Modules\Auth\Application\UseCases\UpdateUser;
use Modules\Auth\Domain\Exceptions\UserNotFoundException;
use Modules\Auth\Domain\Exceptions\InvalidCredentialsException;
use Modules\Auth\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function __construct(private LoginUser $loginUser) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->loginUser->execute(
                email: $request->email,
                password: $request->password
            );

            return response()->json(['token' => $token]);
        } catch (UserNotFoundException | InvalidCredentialsException) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        } catch(\Exception $e){
            Log::critical($e->getMessage(), $e->getTrace() ?? []);
            return response()->json(['message'=> 'Ocorreu um Erro Interno'], 500);
        }
    }

}
