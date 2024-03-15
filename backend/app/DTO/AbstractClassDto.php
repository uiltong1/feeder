<?php

namespace App\DTO;

use Illuminate\Contracts\Validation\Validator;

class AbstractClassDto implements InterfaceDto
{
    /**
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     *
     * @return array
     */
    public function all(): array
    {
        return get_object_vars($this);
    }

    /**
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->all();
    }

    /**
     *
     * @return Validator
     */
    public function validator(): Validator
    {
        return validator($this->toArray(), $this->rules(), $this->messages());
    }

    /**
     *
     * @return array
     */
    public function validate(): array
    {
        return $this->validator()->validate();
    }
}
