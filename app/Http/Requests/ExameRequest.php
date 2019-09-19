<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ExameRequest extends FormRequest
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
            'nome' => 'required|max:150'
        ];
    }

    public function messages()
    {
        return [
            'nome.required'=> 'Descrição é um campo obrigatório',
            'nome.max' => 'Descrição deve conter até :max caracteres',
            'exame_metodo_id.required'=> 'Método é um campo obrigatório',
            'exame_material_id.required'=> 'Material é um campo obrigatório',
            'exame_grupo_id.required'=> 'Material é um campo obrigatório',
        ];
    }
}
