<?php

namespace Modules\Seller\Http;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

use Modules\Seller\Http\Resources\SellerResource;
use Modules\Shared\Services\UploadAchieveS3Service;

use Modules\Auth\Domain\Exceptions\DatabaseException;
use Modules\Seller\Domain\Exceptions\SellerAlreadyExistsException;
use Modules\Seller\Domain\Exceptions\SellerEmailAlreadyExistsException;
use Modules\Seller\Domain\Exceptions\SellerSlugAlreadyExistsException;
use Modules\Seller\Domain\Exceptions\SellerNotExistsException;

use Modules\Seller\Application\DTOs\DeleteSellerDTO;
use Modules\Seller\Application\DTOs\RegisterSellerDTO;
use Modules\Seller\Application\DTOs\UpdateSellerDTO;
use Modules\Seller\Application\DTOs\ListSellerDTO;

use Modules\Seller\Application\UseCases\RegisterSeller;
use Modules\Seller\Application\UseCases\UpdateSeller;
use Modules\Seller\Application\UseCases\DeleteSeller;

use Modules\Seller\Http\Requests\SellersRequests;
use Modules\Seller\Http\Requests\UpdateRequest;
use Modules\Seller\Http\Requests\DeleteRequest;
use Modules\Seller\Http\Requests\ListSellerRequest;

class SellerController extends Controller
{
    public function __construct(
        private RegisterSeller $sellerRegister,
        private UploadAchieveS3Service $uploadArchive,
        private UpdateSeller $updateSeller,
        private DeleteSeller $deleteSeller
    ) {}

    public function index(ListSellerRequest $request)
    {
        try {
            $dto = new ListSellerDTO(
                page: $request->input('page', 1),
                perPage: $request->input('perPage', 15),
                sortBy: $request->input('sortBy', 'slug'),
                sortDirection: $request->input('sortDirection', 'asc'),
                name: $request->input('name'),
                slug: $request->input('slug'),
                document: $request->input('document'),
                email: $request->input('email'),
                is_active: $request->input('is_active'),
                is_verified: $request->input('is_verified'),
                description: $request->input('description'),
                currency: $request->input('currency'),
            );

            return response()->json(['message' => 'Lojas Consultadas com Sucesso!'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao Criar Loja', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Ocorreu um Erro Interno'], 500);
        }
    }

    public function register(SellersRequests $request)
    {
        try {
            $logo_url   = null;
            $banner_url = null;
            if ($request->hasFile('logo_url')) {
                $logo_url = $this->uploadArchive->upload($request->file('logo_url'));
            }

            if ($request->hasFile('banner_url')) {
                $banner_url = $this->uploadArchive->upload($request->file('banner_url'));
            }

            $sellerDto = new RegisterSellerDTO(
                name: $request->name,
                slug: $request->slug,
                document: $request->document,
                email: $request->email,
                password: $request->password,
                logo_url: $logo_url,
                banner_url: $banner_url,
                description: $request->description,
                currency: $request->currency ?? "BRL",
            );

            $sellerCreated = $this->sellerRegister->execute($sellerDto);

            return response()->json(['message' => 'Loja Cadastrada com Sucesso', 'data' => new SellerResource($sellerCreated)], 201);
        } catch (SellerAlreadyExistsException $e) {
            return response()->json(['data' => 'CNPJ Informado Já Está em Uso'], 409);
        } catch (SellerSlugAlreadyExistsException $e) {
            return response()->json(['data' => 'Nome da Marca Informada Já Está em Uso'], 409);
        } catch (SellerEmailAlreadyExistsException $e) {
            return response()->json(['data' => 'E-mail Informado Já Está em Uso'], 409);
        } catch (DatabaseException $e) {
            Log::error('Erro ao Criar Loja', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Ocorreu um Erro Interno'], 500);
        }
    }

    public function update(UpdateRequest $request)
    {
        try {
            $logo_url   = null;
            $banner_url = null;
            if ($request->hasFile('logo_url')) {
                $logo_url = $this->uploadArchive->upload($request->file('logo_url'));
            }

            if ($request->hasFile('banner_url')) {
                $banner_url = $this->uploadArchive->upload($request->file('banner_url'));
            }

            $updateDTO = new UpdateSellerDTO(
                id: $request->id,
                name: $request->input('name', ''),
                logo_url: $logo_url,
                banner_url: $banner_url,
                description: $request->input('description', ''),
            );

            $this->updateSeller->execute($updateDTO);
        } catch (\Exception $e) {
            Log::error('Erro ao Atualizar Loja', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Ocorreu um Erro Interno'], 500);
        }
    }

    public function delete(DeleteRequest $request)
    {
        try {
            $sellerDTO = new DeleteSellerDTO($request->id);

            $this->deleteSeller->execute($sellerDTO);

            return response()->json([], 204);
        } catch (SellerNotExistsException $e) {
            return response()->json(['message' => 'Código do Vendedor Não Encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Erro ao Excluir a Loja', [
                'message'  => $e->getMessage(),
                'previous' => $e->getPrevious()?->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Ocorreu um Erro Interno'], 500);
        }
    }
}
