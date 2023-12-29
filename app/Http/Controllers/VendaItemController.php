<?php

namespace App\Http\Controllers;

use App\Models\VendaItem;
use App\Http\Resources\VendaItemResource;
use Illuminate\Http\Request;

class VendaItemController extends Controller
{

    public function index()
    {
        return VendaItemResource::collection(VendaItem::all());
    }

    public function show(VendaItem $vendaItem)
    {
        return new VendaItemResource($vendaItem);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'venda_id' => 'required|exists:vendas,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer',
            'preco' => 'required|numeric'
        ]);

        $vendaItem = VendaItem::create($validatedData);
        return new VendaItemResource($vendaItem);
    }

    public function update(Request $request, VendaItem $vendaItem)
    {
        $validatedData = $request->validate([
            'venda_id' => 'required|exists:vendas,id',
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer',
            'preco' => 'required|numeric'
        ]);

        $vendaItem->update($validatedData);
        return new VendaItemResource($vendaItem);
    }

    public function destroy(VendaItem $vendaItem)
    {
        $vendaItem->delete();
        return response()->json(null, 204);
    }
}

