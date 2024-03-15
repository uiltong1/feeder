<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->id ?? null;

        return [
            'name' => ['required', 'max:255'],
            'email' => [Rule::unique('users', 'email')->ignore($id, 'id'), 'required', 'max:255', 'email'],
        ];
    }

    /**
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required'  => ':attribute é obrigatório.',
            'unique'    => ':attribute já foi cadastrado.',
            'max'       => 'O tamanho :attribute excedeu o limite do campo.',
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'email' => 'E-mail',
            'name' => 'Nome',
        ];
    }

    /**
     *
     * @param Validator $validator
     * @return HttpResponseException
     */
    protected function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(
            response()->json(
                $validator->errors(),
                Response::HTTP_NOT_ACCEPTABLE
            )
        );
    }
}
