<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Http\Resources\VendaResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function index()
    {
        return VendaResource::collection(Venda::with('venda_itens', 'cliente')->get());
    }

    public function show($id)
    {
        $venda = Venda::with('venda_itens')->find($id);
        return new VendaResource($venda);
    }

    public function store(Request $request)
    {
        $validado = $request->validate([
            'cliente_id' => 'required|integer',
            'status' => 'required|boolean',
            'venda_itens' => 'sometimes|array',
        ]);

        DB::beginTransaction();
        try {
            $validado['data_venda'] = Carbon::now();

            $venda = Venda::create($validado);

            if (!empty($validado['venda_itens'])) {
                foreach ($validado['venda_itens'] as &$item) {
                    $produto = Produto::find($item['produto_id']);
                    $produto->quantidade -= $item['quantidade'];
                    $produto->save();
            
                    $item['total'] = $item['quantidade'] * $item['preco'];
                }
            
                foreach ($validado['venda_itens'] as $item) {
                    $venda->venda_itens()->create($item);
                }
            }
            DB::commit();
            return new VendaResource($venda->load('venda_itens'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, Venda $venda)
    {
        $validado = $request->validate([
            'cliente_id' => 'required|integer',
            'status' => 'required|boolean',
            'venda_itens' => 'sometimes|array'
        ]);

        DB::beginTransaction();

        try {
            $venda->update($validado);

            $vendaItensVelhas = $venda->venda_itens;
            foreach ($vendaItensVelhas as $item) {
                $produto = Produto::find($item['produto_id']);
                $produto->quantidade += $item['quantidade'];
                $produto->save();
            }

            $venda->venda_itens()->delete();

            foreach ($validado['venda_itens'] as $item) {
                $produto = Produto::find($item['produto_id']);
                $produto->quantidade -= $item['quantidade'];
                $produto->save();

                $item['total'] = $item['quantidade'] * $item['preco'];
                $venda->venda_itens()->create($item);
            }

            DB::commit();
            return new VendaResource($venda->load('venda_itens'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy(Venda $venda)
    {
        $venda->delete();
        return response()->json(null, 204);
    }
}
