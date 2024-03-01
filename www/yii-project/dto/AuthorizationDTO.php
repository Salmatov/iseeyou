<?php

namespace app\dto;

class AuthorizationDTO extends BaseDTO
{
    public ?string $email;
    public ?string $password;

    public function __construct($requestData)
    {
        $this->email = $requestData->email??null;
        $this->password = $requestData->password??null;
    }
    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'message' => 'Поле обязательное для заполнения небыло введено'],
            ['email', 'email','message' => 'Неверный формат email'],];
    }
}