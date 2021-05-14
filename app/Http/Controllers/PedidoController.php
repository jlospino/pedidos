<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use App\Models\Pedido;
use App\Models\Cuenta;

class PedidoController extends Controller
{
    /**
     * Mostrar un listado de pedidos transformados a un objeto JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = Pedido::orderBy('created_at', 'desc')
        ->where('fecha_cancelacion', null)
        ->with('cuenta')
        ->get();
        return response()->json($pedidos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PedidoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PedidoRequest $request)
    {
        try {
            $pedido = new Pedido();
            $pedido->cuenta_id = $request->cuenta;
            $pedido->producto = $request->producto;
            $pedido->cantidad = $request->cantidad;
            $pedido->valor = $request->valor;
            $pedido->total = $request->valor * $request->cantidad;
            $pedido->save();

            // Consultar información del cliente
            $cliente = Cuenta::find($pedido->cuenta_id);

            // Se debe notificar desde socket
            //

            return response()->json('Se creó el pedido con código: '. $pedido->id);
        } catch (\Throwable $e){
            return response()->json($e->getMessage(),'500');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PedidoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PedidoRequest $request, $id)
    {
        try {
            $pedido = Pedido::find($id);
            $pedido->cuenta_id = $request->cuenta;
            $pedido->producto = $request->producto;
            $pedido->cantidad = $request->cantidad;
            $pedido->valor = $request->valor;
            $pedido->total = $request->valor * $request->cantidad;
            $pedido->save();

            return response()->json('Se modificó el pedido con código: '. $pedido->id);
        } catch (\Throwable $e){
            return response()->json($e->getMessage(),'500');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        try {
            $pedido = Pedido::find($id);
            $pedido->fecha_cancelacion = date('Y-m-d H:i:s');
            $pedido->save();

            return response()->json('Se canceló el pedido con código: '. $pedido->id);
        } catch (\Throwable $e){
            return response()->json($e->getMessage(),'500');
        }

    }
}
