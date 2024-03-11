<?php

namespace app\dto;

class GetContractsWithDebtDTO extends BaseDTO
{

    public $residenceId;
    public $status;
    public $roomsFilter;

    public function __construct($config)
    {
        $this->residenceId = $config['residenceId'];
        $this->status = $config['status'];
        $this->roomsFilter = $config['roomsFilter'];
    }
}