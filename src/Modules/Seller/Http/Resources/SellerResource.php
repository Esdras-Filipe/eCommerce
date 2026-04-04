<?php

namespace Modules\Seller\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Seller\Domain\Seller;

class SellerResource extends JsonResource
{
    public function __construct(private Seller $seller) {}

    public function toArray($request): array
    {
        return [
            'id'          => $this->seller->id,
            'name'        => $this->seller->name,
            'slug'        => $this->seller->slug,
            'document'    => $this->seller->document,
            'email'       => $this->seller->email,
            'is_active'   => $this->seller->is_active,
            'is_verified' => $this->seller->is_verified,
            'logo_url'    => $this->seller->logo_url,
            'banner_url'  => $this->seller->banner_url,
            'description' => $this->seller->description,
            'currency'    => $this->seller->currency
        ];
    }
}
