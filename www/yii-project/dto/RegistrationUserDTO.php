<?php

namespace app\dto;

class RegistrationUserDTO extends BaseDTO
{
    public ?string $username;
    public ?string $email;
    public ?string $password;

    public function __construct($requestData)
    {
        $this->username = $requestData->username??null;
        $this->email = $requestData->email??null;
        $this->password = $requestData->password??null;
    }
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required', 'message' => 'Поле обязательное для заполнения небыло введено'],
            ['email', 'email','message' => 'Неверный формат email'],];
    }
}