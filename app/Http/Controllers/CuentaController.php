<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CuentaRequest;
use App\Models\Cuenta;

class CuentaController extends Controller
{
    /**
     * Devuelve una lista del recurso transformado en un objeto JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuentas = Cuenta::orderBy('nombre', 'asc')->get();
        return response()->json($cuentas);
    }

    /**
     * Store a new record.
     *
     * @param  \Illuminate\Http\CuentaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CuentaRequest $request)
    {
        try {
            $cuenta = new Cuenta();
            $cuenta->nombre = $request->nombre;
            $cuenta->email = $request->email;
            $cuenta->telefono = $request->telefono;
            $cuenta->save();

            return response()->json('Se creó la cuenta con código: '. $cuenta->id);
        } catch (\Throwable $e){
            return response()->json($e->getMessage(),'500');
        }
    }

    /**
     * Actualizar el recurso especificado.
     *
     * @param  \Illuminate\Http\CuentaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CuentaRequest $request, $id)
    {
        try {
            $validated = $request->validated();
            $cuenta = Cuenta::find($id);
            $cuenta->nombre = $request->nombre;
            $cuenta->email = $request->email;
            $cuenta->telefono = $request->telefono;
            $cuenta->save();

            return response()->json('Se modificó la cuenta con código: '. $cuenta->id);
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(),'500');
        }
    }

    /**
     * Eliminar el recurso especificado de forma lógica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cuenta = Cuenta::find($id);
            $cuenta->delete();
            return Response()->json('Cuenta con código '.$cuenta->id.' eliminada correctamente.');
        } catch (\Throwable $e) {
            return response()->json($e->getMessage(),'500');
        }

    }
}
