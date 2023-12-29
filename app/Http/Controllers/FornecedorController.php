<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Http\Resources\FornecedorResource;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        return FornecedorResource::collection(Fornecedor::orderBy('id', 'desc')->get());
    }

    public function show($id)
    {
        $fornecedor = Fornecedor::find($id);
        return new FornecedorResource($fornecedor);
    }

    public function store(Request $request)
    {
        $requestData = $request->only([
            'nome',
            'nome_fantasia',
            'telefone',
            'email',
        ]);

        $fornecedor = Fornecedor::create($requestData);
        return new FornecedorResource($fornecedor);
    }

    public function update(Request $request, Fornecedor $fornecedor)
    {
        $requestData = $request->only([
            'nome',
            'nome_fantasia',
            'telefone',
            'email',
        ]);

        $fornecedor->update($requestData);
        return new FornecedorResource($fornecedor);
    }

    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();
        return response()->json(null, 204);
    }
}
