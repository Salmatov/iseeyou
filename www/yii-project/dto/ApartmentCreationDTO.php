<?php

namespace app\dto;

class ApartmentCreationDTO extends BaseDTO
{

    public int $number;
    public float $square;
    public int $rooms;
    public bool $isStudio;
    public int $residenceId;
    public string $status;

    public function __construct(mixed $apartmentData)
    {
        $this->number = $apartmentData->number;
        $this->square = $apartmentData->square;
        $this->rooms = $apartmentData->rooms;
        $this->isStudio = $apartmentData->isStudio;
        $this->residenceId = $apartmentData->residenceId;
        $this->status = $apartmentData->status;
    }

    public function rules(){
        return [
            [['number', 'square', 'rooms', 'isStudio', 'residenceId', 'status'], 'required'],
            ['status', 'match', 'pattern' => '/^[a-z]+$/'],
        ];

    }


}