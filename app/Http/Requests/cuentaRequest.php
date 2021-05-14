<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class cuentaRequest extends FormRequest
{
    /**
     * Determine si el usuario está autorizado para realizar esta solicitud.
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
            'nombre' => 'required',
            'email' => 'required',
            'telefono' => 'required',
        ];
    }

    /**
     * Obtenga atributos personalizados para los errores del validador.
     *
     * @return array
     */
    public function attributes(){
        return [
            'nombre' => 'Nombre',
            'email' => 'Correo Electrónico',
            'telefono' => 'Teléfono',

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
            'nombre.required' => 'Debe ingresar el nombre',
            'email.required' => 'Debe ingresar el correo electónico',
            'telefono.required' => 'Debe ingresar el teléfono',
        ];
    }
}
