<?php

namespace app\dto;

class UserUpdateDTO extends BaseDTO
{
    public ?int $id;
    public ?string $username;
    public ?string $email;
    public ?string $password;

    public function __construct($userData){
        $this->id = $userData->id??null;
        $this->username = $userData->username??null;
        $this->email = $userData->email??null;
        $this->password = $userData->password??null;
    }

    public function rules()
    {
        return [
            [['id','username','email','password'], 'required', 'message' => 'Поле обязательное для заполнения небыло введено'],
            ['email', 'email','message' => 'Неверный формат email'],
            ['id', 'integer', 'max' => 11, 'message' => 'Неверный формат id'],
            [['username','email', 'password'],'string', 'max' => 255, 'message' => 'Неверный формат'],
        ];
    }

}