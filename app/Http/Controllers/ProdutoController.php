<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Resources\ProdutoResource;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('fornecedor')->get();
        return ProdutoResource::collection($produtos);
    }

    public function show($id)
    {
        $produto = Produto::find($id)->with('fornecedor');
        return new ProdutoResource($produto);
    }

    public function store(Request $request)
    {
        $requestData = $request->only([
            'nome',
            'descricao',
            'preco',
            'quantidade',
            'fornecedor_id'
        ]);

        $produto = Produto::create($requestData);
        return new ProdutoResource($produto);
    }

    public function update(Request $request, Produto $produto)
    {
        $requestData = $request->only([
            'nome',
            'descricao',
            'preco',
            'quantidade',
            'fornecedor_id'
        ]);

        $produto->update($requestData);
        return new ProdutoResource($produto);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return response()->json(null, 204);
    }
}
