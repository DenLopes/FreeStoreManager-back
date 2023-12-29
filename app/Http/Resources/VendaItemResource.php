<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendaItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'venda_id' => $this->venda_id,
            'produto_id' => $this->produto_id,
            'quantidade' => $this->quantidade,
            'preco' => $this->preco,
            'total' => $this->total,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
