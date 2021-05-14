<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obtenga las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cuenta' => 'required|numeric',
            'producto' => 'required',
            'cantidad' => 'required|numeric',
            'valor' => 'required|numeric',
        ];
    }

    /**
     * Obtenga atributos personalizados para los errores del validador.
     *
     * @return array
     */
    public function attributes(){
        return [
            'cuenta' => 'Cuenta',
            'producto' => 'Producto',
            'cantidad' => 'Cantidad',
            'valor' => 'Valor',

        ];
    }

    /**
     * Obtenga los mensajes de error para las reglas de validación definidas.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cuenta.required' => 'Debe ingresar la cuenta',
            'producto.required' => 'Debe ingresar el producto',
            'cantidad.required' => 'Debe ingresar la cantidad',
            'valor.required' => 'Debe ingresar el valor',
        ];
    }
}
