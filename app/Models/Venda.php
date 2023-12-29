<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    protected $fillable =
    [
        'cliente_id',
        'data_venda',
        'status'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function venda_itens()
    {
        return $this->hasMany(VendaItem::class);
    }

    public function getValorTotal()
    {
        $valorTotal = 0;
        foreach ($this->venda_itens as $vendaItem) {
            $valorTotal += $vendaItem->quantidade * $vendaItem->preco;
        }
        return $valorTotal;
    }
}
