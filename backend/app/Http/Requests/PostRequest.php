<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
        $userId = $this->user_id ?? null;
        $tagsIds = $this->tags ?? [];

        return [
            'title'     => ['required', 'max:50'],
            'body'      => ['required'],
            'user_id'   => ['required', Rule::exists('users', 'id')->where('id', $userId)],
            'tags'      => ['required', Rule::exists('tags', 'id')->whereIn('id', $tagsIds)],
        ];
    }

    /**
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required'      => ':attribute é obrigatório.',
            'max'           => 'O tamanho :attribute excedeu o limite do campo.',
            'exists'        => 'O :attribute é inválido',
            'tags.exists'   => 'Existe uma ou mais tags inválidas'
        ];
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'title'     => 'Titulo',
            'body'      => 'Texto',
            'user_id'   => 'Usuário',
            'tags'      => 'Tags',
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
