<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use App\Models\Pedido;
use App\Models\Cuenta;
use App\Events\NotifyMessage;
use MessagePack\MessagePack;
use Redis;

class PedidoController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest');
    }

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
     * Guardar un nuevo pedido en la tabla pedidos,
     * envio de notificación con información del pedido y de la cuenta asociada.
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

            $data = [
                "client" => $cliente,
                "pedido" => $pedido,
            ];

            //Envio de notificación con información del pedido y del cliente
            //Uso de Redis para el envio de la data
            Redis::publish("clientes", json_encode(['event' => 'match', 'message' => $data]));

            return response()->json('Se creó el pedido con código: '. $pedido->id);
        } catch (\Throwable $e){
            return response()->json($e->getMessage(),'500');
        }
    }

    /**
     * Modificar un registro de la tabla pedidos.
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
     * Cancelar producto, eliminación logica usando el campo fecha_cancelacion.
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
