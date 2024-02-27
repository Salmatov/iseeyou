<?php

namespace app\dto;

use yii\base\Model;

class BaseDTO extends Model
{
    /**
     * Проверяет валидацию объекта и выбрасывает исключение с сообщением об ошибке, если валидация не прошла.
     * @throws \Exception если валидация не прошла
     */
    public function validateOrException()
    {
        if (!$this->validate()) {
            $errorMessage = 'Ошибка валидации: ';
            foreach ($this->getErrors() as $attributeErrors) {
                $errorMessage .= implode(', ', $attributeErrors) . '. ';
            }
            throw new \Exception($errorMessage, 400);
        }
    }
}
