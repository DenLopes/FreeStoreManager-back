<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VendaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cliente_nome' => $this->cliente->nome,
            'cliente_id' => $this->cliente->id,
            'data_venda' => Carbon::parse($this->data_venda)->format('d/m/Y'),
            'status' => $this->status,
            'itens_venda' => $this->venda_itens->count(),
            'quantidade_total' => $this->venda_itens->sum('quantidade'),
            'valor_total' => $this->venda_itens->sum('total'),
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y H:i:s'),
            'venda_itens' => VendaItemResource::collection($this->venda_itens),
        ];
    }
}

