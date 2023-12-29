<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Produto;
use App\Http\Resources\CompraResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        return CompraResource::collection(Compra::with('produto', 'fornecedor')->get());
    }

    public function show($id)
    {
        $compra = Compra::find($id)->with('produto', 'fornecedor');
        return new CompraResource($compra);
    }

    public function store(Request $request)
    {
        $requestData = $request->only([
            'id',
            'produto_id',
            'fornecedor_id',
            'quantidade',
            'preco',
        ]);

        $requestData['data_compra'] = Carbon::now();

        $produto = Produto::find($requestData['produto_id']);
        $produto->quantidade += $requestData['quantidade'];
        $produto->save();

        $compra = Compra::create($requestData);
        return new CompraResource($compra);
    }

    public function update(Request $request)
    {
        $requestData = $request->only([
            'id',
            'produto_id',
            'fornecedor_id',
            'quantidade',
            'preco',
        ]);

        $compra = Compra::find($requestData['id']);
        $produto = Produto::find($requestData['produto_id']);

        $produto->quantidade -= $compra->quantity;
        $produto->quantidade += $requestData['quantidade'];
        $produto->save();

        $compra->update($requestData);
        return new CompraResource($compra);
    }

    public function destroy(Compra $compra)
    {
        $produto = Produto::find($compra->produto_id);
        $produto->quantidade -= $compra->quantidade;
        $produto->save();

        $compra->delete();
        return response()->json(null, 204);
    }
}
