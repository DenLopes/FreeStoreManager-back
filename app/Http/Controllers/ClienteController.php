<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Resources\ClienteResource;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return ClienteResource::collection(Cliente::all());
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);
        return new ClienteResource($cliente);
    }

    public function store(Request $request)
    {
        $requestData = $request->only([
            'nome',
            'email',
            'telefone',
        ]);

        $cliente = Cliente::create($requestData);
        return new ClienteResource($cliente);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $requestData = $request->only([
            'nome',
            'email',
            'telefone',
        ]);

        $cliente->update($requestData);
        return new ClienteResource($cliente);
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return response()->json(null, 204);
    }
}
