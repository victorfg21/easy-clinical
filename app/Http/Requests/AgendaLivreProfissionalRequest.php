<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AgendaLivreProfissionalRequest extends FormRequest
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
            'data_livre' => 'required',
            'inicio_periodo' => 'required',
            'fim_periodo' => 'required',
            'motivo' => 'required|max:200',
        ];
    }

    public function messages()
    {
        return [
            'profissional_id.required'=> 'Profissional é um campo obrigatório',
            'data_livre.required'=> 'Profissional é um campo obrigatório',
            'inicio_periodo.required'=> 'Período Início é um campo obrigatório',
            'fim_periodo.required'=> 'Período Fim é um campo obrigatório',
            'motivo.required'=> 'Motivo é um campo obrigatório',
            'motivo.max'=> 'Motivo deve conter até :max caracteres'
        ];
    }
}
