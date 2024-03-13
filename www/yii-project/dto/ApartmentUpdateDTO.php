<?php

namespace app\dto;

class ApartmentUpdateDTO extends BaseDTO
{
    public int $id;
    public int $number;
    public float $square;
    public int $rooms;
    public bool $isStudio;
    public int $residenceId;
    public string $status;

    public function __construct(mixed $apartmentData)
    {
        $this->id = $apartmentData->id;
        $this->number = $apartmentData->number;
        $this->square = $apartmentData->square;
        $this->rooms = $apartmentData->rooms;
        $this->isStudio = $apartmentData->isStudio;
        $this->residenceId = $apartmentData->residenceId;
        $this->status = $apartmentData->status;
    }

    public function rules(){
        return [
            [['id', 'number', 'square', 'rooms', 'is_studio', 'residence_id', 'status'], 'required'],
            ['status', 'match', 'pattern' => '/^[a-z]+$/'],
        ];
    }

}