<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CompraResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fornecedor_id' => $this->fornecedor_id,
            'fornecedor_nome' => $this->fornecedor->nome,
            'produto_id' => $this->produto_id,
            'produto_nome' => $this->produto->nome,
            'quantidade' => $this->quantidade,
            'data_compra' => Carbon::parse($this->data_compra)->format('d/m/Y'),
            'preco' => $this->preco,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
