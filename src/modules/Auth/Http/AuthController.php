<?php

namespace Modules\Auth\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Application\DTOs\RegisterUserDTO;
use Modules\Auth\Application\DTOs\UpdateUserDTO;
use Modules\Auth\Application\UseCases\LoginUser;
use Modules\Auth\Application\UseCases\RegisterUser;
use Modules\Auth\Application\UseCases\UpdateUser;
use Modules\Auth\Domain\Exceptions\UserNotFoundException;
use Modules\Auth\Domain\Exceptions\InvalidCredentialsException;
use Modules\Auth\Domain\Exceptions\UserAlreadyExistsException;
use Modules\Auth\Domain\Exceptions\DatabaseException;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\UpdateRequest;
use Modules\Auth\Http\Resources\UserResource;
use Modules\Shared\Http\ApiResponse;

class AuthController extends Controller
{
    public function __construct(private LoginUser $loginUser, private RegisterUser $registerUser, private UpdateUser $updateUser) {}

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
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $dto  = new RegisterUserDTO(name: $request->name, email: $request->email, password: $request->password);
            $user = $this->registerUser->execute($dto);

            return ApiResponse::success(data: new UserResource($user), message: 'Usuário criado com sucesso', status: 201);
        } catch (UserAlreadyExistsException) {
            return response()->json(['message' => 'E-mail Já Cadastrado'], 409);
        } catch (DatabaseException $e) {
            Log::error('Erro ao criar usuário', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Erro interno', 500);
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $dtoUpdate = new UpdateUserDTO(
                id: $request->id,
                name: $request->input('name'),
                email: $request->input('email'),
                email_verified_at: $request->input('email_verified_at'),
                role: $request->input('role'),
                remember_token: $request->input('remember_token'),
            );

            $user = $this->updateUser->execute($dtoUpdate);

            return ApiResponse::success(data: [], message: 'Usuário atualizado com sucesso', status: 200);
        } catch (UserNotFoundException) {
            return response()->json(['message' => 'ID do Usuário Informado não Existe'], 404);
        } catch (DatabaseException $e) {
            Log::error('Erro ao Atualizar o usuário', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return ApiResponse::error('Erro interno', 500);
        }
    }
}
