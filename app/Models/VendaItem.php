<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendaItem extends Model
{
    use HasFactory;

    protected $table = 'vendas_itens';
    
    protected $fillable = [
        'venda_id',
        'produto_id',
        'quantidade',
        'preco',
        'total'
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class)->withTrashed();
    }

    public function getTotal()
    {
        return $this->quantidade * $this->preco;
    }
}
