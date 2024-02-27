<?php

namespace app\dto;


class ResidentialComplexUpdateDTO extends BaseDTO
{
    public int $id;
    public string $name;
    public string $installmentCompletionDate;

    public function __construct($complexData)
    {
        $this->id = $complexData->id;
        $this->name = $complexData->name;
        $this->installmentCompletionDate = $complexData->installmentCompletionDate;
    }

    public function rules()
    {
        return [
            [['name', 'installmentCompletionDate', 'id'], 'required'],
            ['name', 'string', 'max' => 50],
            ['installmentCompletionDate', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

}