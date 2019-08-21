<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AgendaRequest extends FormRequest
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
            'inicio_periodo' => 'required',
            'fim_periodo' => 'required',
            'tempo_consulta' => 'required',
            'inicio_horario_1' => 'required',
            'fim_horario_1' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'profissional_id.required'=> 'Profissional é um campo obrigatório',
            'inicio_periodo.required'=> 'Período Início é um campo obrigatório',
            'fim_periodo.required'=> 'Período Fim é um campo obrigatório',
            'tempo_consulta.required'=> 'Profissional é um campo obrigatório',
            'inicio_horario_1.required'=> '1º Horário Início é um campo obrigatório',
            'fim_horario_1.required'=> '1º Horário Fim é um campo obrigatório',
        ];
    }
}
