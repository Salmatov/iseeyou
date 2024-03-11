<?php

namespace app\service;

use app\dto\ContractCreationDTO;
use app\dto\ContractUpdateDTO;
use app\models\Contract;
use Exception;

class ContractService
{

    public static function create(ContractCreationDTO $contractCreationDTO):Contract|array
    {
        $contract = new Contract();
        $contract->setAttributes($contractCreationDTO->attributes, false);
        $contract->createdAt = $contract->createdAt->format('Y-m-d H:i:s');
        $contract->installmentCompletionDate = $contract->installmentCompletionDate->format('Y-m-d H:i:s');
        if (!$contract->save()) {
            throw new \Exception("Ошибка при создании договора");
        }
        return $contract;
    }

    public static function update(ContractUpdateDTO $contractUpdateDTO):Contract|array
    {
        $contract = self::getById($contractUpdateDTO->id);
        if (!$contract) {
            throw new \Exception("Договор не найден");
        }
        $check = Contract::getByContractNumber($contractUpdateDTO->contractNumber);
        if ($check && $check->id != $contract->id) {
            throw new \Exception("Договор с таким номером уже существует");
        }
        $contract->setAttributes($contractUpdateDTO->attributes, false);
        $contract->createdAt = $contract->createdAt->format('Y-m-d H:i:s');
        $contract->installmentCompletionDate = $contract->installmentCompletionDate->format('Y-m-d H:i:s');
        if (!$contract->save()) {
            throw new \Exception("Ошибка при обновлении договора");
        }
        return $contract;
    }

    public static function updateStatus(int $id, string $status):Contract|array
    {
        $contract = self::getById($id);
        if (!$contract) {
            throw new \Exception("Договор не найден");
        }
        if(!in_array($status, Contract::getStatusList())){
            throw new \Exception("Недопустимый статус договора");
        }
        $contract->status = $status;
        if (!$contract->save()) {
            throw new \Exception("Ошибка при обновлении статуса договора");
        }
        return $contract;
    }

    public static function delete($id):array|null
    {
        $contract = self::getById($id);
        if (!$contract) {
            throw new \Exception("Договор не найден");
        }
        if (!$contract->delete()) {
            throw new \Exception("Ошибка при удалении договора");
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public static function getById(int $id):Contract|array
    {
        $contract = Contract::getById($id);
        if (!$contract) {
            throw new Exception("Договор не найден", 404);
        }
        return $contract;
    }

    public static function getAll():array|null
    {
        $contracts = Contract::getAll();
        if ($contracts == null) {
            throw new Exception("Договоры не найдены", 404);
        }
        return $contracts;
    }

    public static function getStatusList():array
    {
        return Contract::getStatusList();
    }

    public static function getContractByNumber(int $number):array|null
    {
        $contractList = Contract::getListByNumber($number);
        if ($contractList == null) {
            return [];
        }
        return $contractList;
    }


}