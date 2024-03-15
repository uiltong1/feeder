<?php

namespace App\DTO;

use Illuminate\Contracts\Validation\Validator;

interface InterfaceDto
{
    /**
     *
     * @return array
     */
    public function rules(): array;

    /**
     *
     * @return array
     */
    public function messages(): array;

    /**
     *
     * @return array
     */
    public function attributes(): array;

    /**
     *
     * @return Validator
     */
    public function validator(): Validator;

    /**
     *
     * @return array
     */
    public function validate(): array;
}
