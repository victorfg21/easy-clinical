<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class MedicamentoRequest extends FormRequest
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
            'nome_fabrica' => 'required|max:150'
        ];
    }

    public function messages()
    {
        return [
            'nome_generico.required'=> 'Nome Genérico é um campo obrigatório',
            'nome_generico.max' => 'Nome Genérico deve conter até :max caracteres',
            'nome_fabrica.required'=> 'Nome de Fábrica é um campo obrigatório',
            'nome_fabrica.max' => 'Nome de Fábrica deve conter até :max caracteres'
        ];
    }
}
