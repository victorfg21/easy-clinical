<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ConsultaRequest extends FormRequest
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
            'profissional_id' => 'required',
            'paciente_id' => 'required',
            'data_consulta' => 'required',
            'horario_consulta' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'profissional_id.required'=> 'Profissional é um campo obrigatório',
            'paciente_id.required'=> 'Paciente é um campo obrigatório',
            'data_consulta.required'=> 'Data é um campo obrigatório',
            'horario_consulta.required'=> 'Horário é um campo obrigatório'
        ];
    }
}
