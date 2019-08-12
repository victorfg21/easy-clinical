<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class PacienteRequest extends FormRequest
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
            'nome' => 'required|max:150',
            'rg' => 'required|max:20|unique:pacientes,'.$this->get('id').',id',
            'cpf' => 'required|unique:pacientes,'.$this->get('id').',id',
            'dt_nasc' => 'required',
            'sexo' => 'required',
            'email' => 'email|max:200|unique:users,'.$this->get('user_id').',id',
            'celular' => 'required',
            'cep' => 'required',
            'endereco' => 'required|max:150',
            'numero' => 'required',
            'bairro' => 'required|max:150',
            'cidade' => 'required|max:150',
            'estado' => 'required|max:2',
        ];
    }

    public function messages()
    {
        return [
            'nome.required'=> 'Nome é um campo obrigatório',
            'nome.max' => 'Nome deve conter até :max caracteres',
            'cpf.required'=> 'CPF é um campo obrigatório',
            'cpf.unique' => 'CPF já cadastrado',
            'cpf.max' => 'CPF inválido',
            'cpf.min' => 'CPF inválido',
            'rg.max' => 'RG deve conter até :max caracteres',
            'rg.required'=> 'RG é um campo obrigatório',
            'rg.unique' => 'RG já cadastrado',
            'dt_nasc.required'=> 'Data nascimento é um campo obrigatório',
            'sexo.required'=> 'Sexo é um campo obrigatório',
            'celular.required'=> 'Celular é um campo obrigatório',
            'cep.required'=> 'CEP é um campo obrigatório',
            'endereco.required'=> 'Endereço é um campo obrigatório',
            'endereco.max'=> 'Endereço deve conter até :max caracteres',
            'numero.required'=> 'Número é um campo obrigatório',
            'bairro.required'=> 'Bairro é um campo obrigatório',
            'bairro.max'=> 'Bairro deve conter até :max caracteres',
            'cidade.required'=> 'Cidade é um campo obrigatório',
            'cidade.max'=> 'Cidade deve conter até :max caracteres',
            'estado.required'=> 'UF é um campo obrigatório',
        ];
    }
}
