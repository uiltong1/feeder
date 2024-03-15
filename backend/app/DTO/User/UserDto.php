<?php

namespace App\DTO\User;

use App\DTO\AbstractClassDto;
use Illuminate\Validation\Rule;

class UserDto extends AbstractClassDto
{
    /**
     *
     * @param integer|null $id
     * @param string $name
     * @param string $email
     * @param string $created_at
     * @param string $updated_at
     */
    public function __construct(
        public ?int $id = null,
        public string $name,
        public string $email,
        string $created_at = '',
        string $updated_at = '',
    ) {
        $this->validate();
    }

    /**
     *
     * @return array
     */
    public function rules(): array
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
}
