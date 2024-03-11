<?php

namespace app\service;

use app\dto\ApartmentCreationDTO;
use app\dto\ApartmentUpdateDTO;
use app\models\Apartment;

class ApartmentService
{

    public static function create(ApartmentCreationDTO $apartmentCreationDTO): Apartment|array
    {
        $apartment = new Apartment();
        $apartment->setAttributes($apartmentCreationDTO->attributes, false);
        if (!$apartment->save()) {
            throw new \Exception("Ошибка при сохранении квартиры", 500);
        }
        return $apartment;
    }

    public static function update(ApartmentUpdateDTO $apartmentUpdateDTO): Apartment|array
    {
        $apartment = Apartment::getById($apartmentUpdateDTO->id);
        if (!$apartment) {
            throw new \Exception("Квартира не найдена",404);
        }
        $apartment->setAttributes($apartmentUpdateDTO->attributes, false);
        if (!$apartment->save()) {
            throw new \Exception("Ошибка при обновлении квартиры", 500);
        }
        return $apartment;
    }

    public static function updateStatus(int $id, string $status): Apartment|array
    {
        $apartment = Apartment::getById($id);
        if (!$apartment) {
            throw new \Exception("Квартира не найдена",404);
        }
        if(!in_array($status, Apartment::getStatusList())){
            throw new \Exception("Недопустимый статус квартиры",400);
        }
        $apartment->status = $status;
        if (!$apartment->save()) {
            throw new \Exception("Ошибка при обновлении статуса квартиры", 500);
        }
        return $apartment;
    }

    public static function delete($id): array|null
    {
        $apartment = Apartment::getById($id);
        if (!$apartment) {
            throw new \Exception("Квартира не найдена",404);
        }
        if (!$apartment->delete()) {
            throw new \Exception("Ошибка при удалении квартиры", 500);
        }
        return null;
    }

    public static function getAll(): array|null
    {
        $apartments = Apartment::getAll();
        if ($apartments == null) {
            throw new \Exception("Квартиры не найдены", 404);
        }
        return $apartments;
    }

    public static function getStatusList(): array
    {
        return Apartment::getStatusList();
    }

}