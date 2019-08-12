<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class FabricanteRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome_generico' => 'required|max:150',
            'nome_fabricante' => 'required|max:150',
            'id_fabricante' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nome_generico.required'=> 'Descrição é um campo obrigatório',
            'nome_generico.max' => 'Descrição deve conter até :max caracteres',
            'nome_fabricante.required'=> 'Descrição é um campo obrigatório',
            'nome_fabricante.max' => 'Descrição deve conter até :max caracteres',
            'id_fabricante.required'=> 'Descrição é um campo obrigatório'
        ];
    }
}
