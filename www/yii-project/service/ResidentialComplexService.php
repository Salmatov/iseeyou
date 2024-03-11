<?php

namespace app\service;

use app\dto\ResidentialComplexCreationDTO;
use app\dto\ResidentialComplexUpdateDTO;
use app\models\ResidentialComplex;

class ResidentialComplexService
{

    public static function create(ResidentialComplexCreationDTO $residentialComplexCreationDTO):ResidentialComplex|array
    {
        $residentialComplexCreationDTO->validateOrException();
        $residentialComplex = new ResidentialComplex();
        $residentialComplex->setAttributes($residentialComplexCreationDTO->attributes, false);
        $residentialComplex->installmentCompletionDate = TimeService::formatDateTimeForDatabase($residentialComplexCreationDTO->installmentCompletionDate);
        $residentialComplex->save();
        return $residentialComplex;
    }

    public static function update(ResidentialComplexUpdateDTO $residentialComplexUpdateDTO):ResidentialComplex|array
    {
        $residentialComplexUpdateDTO->validateOrException();
        $residentialComplex = self::getById($residentialComplexUpdateDTO->id);
        $residentialComplex->setAttributes($residentialComplexUpdateDTO->attributes, false);
        $residentialComplex->save();
        return $residentialComplex;
    }

    public static function delete($id):array|null
    {
        $residentialComplex = self::getById($id);
        $residentialComplex->delete();
        return null;
    }

    public static function getById(int $id, bool $throwExceptionIfNotFound = true):ResidentialComplex|array|null
    {
         $residentialComplex = ResidentialComplex::getById($id);
         if ($residentialComplex == null && $throwExceptionIfNotFound) {
             throw new \Exception("Жилой комплекс не найден", 404);
         }
         return $residentialComplex;
    }

    public static function getByName(string $name, bool $throwExceptionIfNotFound = true):ResidentialComplex|array|null
    {
        $residentialComplex = ResidentialComplex::getByName($name);
        if ($residentialComplex == null && $throwExceptionIfNotFound) {
            throw new \Exception("Жилой комплекс не найден", 404);
        }
        return $residentialComplex;
    }

    public static function getAll():array
    {
        $residentialComplexes = ResidentialComplex::getAll();
        if ($residentialComplexes === null) {
            return [];
        }
        return $residentialComplexes;
    }


}
