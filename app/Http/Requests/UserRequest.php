<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;

class UserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'password' => 'required_without:id',
            'email' => Rule::unique('users')->ignore(Auth::id())//'unique:users,email,'. Auth::id() .',id',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=> 'Nome é um campo obrigatório',
            'name.max' => 'Nome deve conter até :max caracteres',
            'password.required'=> 'Senha é um campo obrigatório',
            'password.min' => 'Senha deve conter no mínimo :min caracteres',
            'email.required'=> 'Email é um campo obrigatório',
            'email.max' => 'Email deve conter até :max caracteres',
            'email.unique' => 'Email já está sendo utilizado',
        ];
    }

    public function validate($data)
    {
        $erros = "";
        $v = Validator::make($data, $this->rules(), $this->messages());
        if ($v->passes()) {
            return $erros;
        } else {
            $erros = $v->errors()->all();
            return $erros;
        }
    }
}
