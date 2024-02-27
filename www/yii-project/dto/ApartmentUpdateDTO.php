<?php

namespace app\dto;

class ApartmentUpdateDTO extends BaseDTO
{
    public int $id;
    public int $number;
    public float $square;
    public int $rooms;
    public bool $is_studio;
    public int $residence_id;
    public string $status;

    public function __construct(mixed $apartmentData)
    {
        $this->id = $apartmentData->id;
        $this->number = $apartmentData->number;
        $this->square = $apartmentData->square;
        $this->rooms = $apartmentData->rooms;
        $this->is_studio = $apartmentData->isStudio;
        $this->residence_id = $apartmentData->residenceId;
        $this->status = $apartmentData->status;
    }

    public function rules(){
        return [
            [['id', 'number', 'square', 'rooms', 'is_studio', 'residence_id', 'status'], 'required'],
            ['status', 'match', 'pattern' => '/^[a-z]+$/'],
        ];
    }

}