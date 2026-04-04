<?php

namespace Modules\User\Http;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

use Modules\User\Application\DTOs\RegisterUserDTO;
use Modules\User\Application\DTOs\UpdateUserDTO;
use Modules\User\Application\DTOs\DeleteUserDTO;
use Modules\User\Application\DTOs\ListUsersDTO;
use Modules\User\Application\DTOs\UserDTO;
use Modules\User\Http\Resources\UserResource;

use Modules\User\Application\UseCases\RegisterUser;
use Modules\User\Application\UseCases\UpdateUser;
use Modules\User\Application\UseCases\DeleteUser;
use Modules\User\Application\UseCases\ListUsers;
use Modules\User\Application\UseCases\GetUser;

use Modules\User\Domain\Exceptions\UserNotFoundException;
use Modules\User\Domain\Exceptions\UserAlreadyExistsException;
use Modules\User\Domain\Exceptions\DatabaseException;
use Modules\User\Domain\Exceptions\UserPermissionDeniedException;

use Modules\User\Http\Requests\RegisterRequest;
use Modules\User\Http\Requests\UpdateRequest;
use Modules\User\Http\Requests\DeleteRequest;
use Modules\User\Http\Requests\ListUserRequest;
use Modules\User\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function __construct(
        private RegisterUser $registerUser,
        private UpdateUser $updateUser,
        private DeleteUser $deleteUser,
        private ListUsers $listUsers,
        private GetUser $getUser
    ) {}

    public function index(ListUserRequest $request)
    {
        try {
            $userLogin = $request->attributes->get('auth_user');
            $dto = new ListUsersDTO(
                name: $request->input('name'),
                email: $request->input('email'),
                role: $request->input('role'),
                page: (int) $request->input('page', 1),
                perPage: (int) $request->input('perPage', 15),
                sortBy: $request->input('sortBy'),
                sortDirection: $request->input('sortDirection', 'asc')
            );

            $result = $this->listUsers->execute($dto, $userLogin);

            return response()->json([
                'message' => 'Usuários Consultados com Sucesso!',
                'data' => UserResource::collection($result->items),
                'meta' => [
                    'total' => $result->total,
                    'perPage' => $result->perPage,
                    'currentPage' => $result->currentPage,
                ]
            ], 200);
        } catch (UserPermissionDeniedException $e) {
            return response()->json(['message' => 'Usuário Não Possui Permissão'], 401);
        } catch (\Exception $e) {
            Log::error('Erro ao Listar os usuários', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function show(UserRequest $request)
    {
        try {
            $userLogin = $request->attributes->get('auth_user');
            $userDto   = new UserDTO(id: $request->input('id', ''));
            $result    = $this->getUser->execute($userDto, $userLogin);

            return response()->json(['message' => 'Usuário Consultado com Sucesso!', 'data' => $result], 200);
        } catch (UserPermissionDeniedException $e) {
            return response()->json(['message' => 'Usuário Não Possui Permissão'], 401);
        } catch (UserNotFoundException) {
            return response()->json(['message' => 'ID do Usuário Informado não Existe'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao Listar o usuário', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function store(RegisterRequest $request)
    {
        try {
            $userLogin = $request->attributes->get('auth_user');
            $dto       = new RegisterUserDTO(name: $request->name, email: $request->email, password: $request->password);
            $user      = $this->registerUser->execute($dto, $userLogin);

            return response()->json(['message' => 'Usuário criado com sucesso', 'data' => new UserResource($user)], 201);
        } catch (UserPermissionDeniedException $e) {
            return response()->json(['message' => 'Usuário Não Possui Permissão'], 401);
        } catch (UserAlreadyExistsException) {
            return response()->json(['message' => 'E-mail Já Cadastrado'], 409);
        } catch (DatabaseException $e) {
            Log::error('Erro ao criar usuário', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $userLogin = $request->attributes->get('auth_user');

            $dtoUpdate = new UpdateUserDTO(
                id: $request->id,
                name: $request->input('name'),
                email: $request->input('email'),
                email_verified_at: $request->input('email_verified_at'),
                role: $request->input('role'),
                remember_token: $request->input('remember_token'),
            );

            $user = $this->updateUser->execute($dtoUpdate, $userLogin);

            return response()->json(['message' => 'Usuário atualizado com sucesso', 'data' => new UserResource($user)], 200);
        } catch (UserPermissionDeniedException $e) {
            return response()->json(['message' => 'Usuário Não Possui Permissão'], 401);
        } catch (UserNotFoundException) {
            return response()->json(['message' => 'ID do Usuário Informado não Existe'], 404);
        } catch (DatabaseException $e) {
            Log::error('Erro ao Atualizar o usuário', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Erro interno'], 500);
        }
    }

    public function delete(DeleteRequest $request)
    {
        try {
            $userLogin = $request->attributes->get('auth_user');
            $dtoDelete = new DeleteUserDTO($request->id);

            if ($this->deleteUser->execute($dtoDelete, $userLogin))
                return response()->json(null, 204);
        } catch (UserPermissionDeniedException $e) {
            return response()->json(['message' => 'Usuário Não Possui Permissão'], 401);
        } catch (UserNotFoundException $e) {
            return response()->json(['message' => 'Usuário Informado não Existe'], 404);
        } catch (DatabaseException $e) {
            Log::critical('Erro ao Deletear o usuário', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Ocorreu um Erro Interno'], 500);
        }
    }
}
