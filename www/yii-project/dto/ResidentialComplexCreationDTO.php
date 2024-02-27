<?php

namespace app\dto;

use DateTime;

class ResidentialComplexCreationDTO extends BaseDTO
{
    public ?string $name;
    public ?DateTime $installmentCompletionDate;

    public function __construct($complexData)
    {
        $this->name = $complexData->name ?? null;
        $this->installmentCompletionDate = $complexData->installmentCompletionDate ?? null;
    }

    public function rules()
    {
        return [
            [['name', 'installmentCompletionDate'], 'required', 'message' => 'Поле обязательно для заполнения.'],
            ['name', 'match', 'pattern' => '/^[a-zA-ZА-Яа-я0-9\s\-\.]+$/u', 'message' => 'Допустимы только буквы латинского и русского алфавита, цифры, пробелы, дефисы и точки.'],
            ['name', 'string', 'max' => 50],
        ];
    }

}