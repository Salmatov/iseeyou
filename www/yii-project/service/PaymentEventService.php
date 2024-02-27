<?php

namespace app\service;

use app\dto\PaymentEventCreateDTO;
use app\models\Apartment;
use app\models\Contract;
use app\models\PaymentEvent;

class PaymentEventService
{

    /**
     * @throws \Exception
     */
    public static function create(PaymentEventCreateDTO $paymentEventCreateDTO): PaymentEvent|array
    {
        $paymentEvent = new PaymentEvent();
        $paymentEvent->setAttributes($paymentEventCreateDTO->attributes, false);
        try {
            Contract::getById($paymentEventCreateDTO->contractId);
        } catch (\Exception $e) {
            throw new \Exception("Невозможно создать событие платежа. Договор не найден",400);
        }
        if(!in_array($paymentEvent->paymentType, PaymentEvent::getEventTypeList())){
            throw new \Exception("Недопустимый тип события",400);
        }
        $paymentEvent->createdAt = $paymentEvent->createdAt->format('Y-m-d H:i:s');
        if (!$paymentEvent->save()) {
            throw new \Exception("Ошибка при создании события платежа",500);
        }
        return $paymentEvent;
    }

    public static function update(PaymentEventCreateDTO $paymentEventUpdateDTO)
    {
        $paymentEvent = PaymentEvent::getById($paymentEventUpdateDTO->id);
        if (!$paymentEvent) {
            throw new \Exception("Событие платежа не найдено",404);
        }
        $paymentEvent->setAttributes($paymentEventUpdateDTO->attributes, false);
        $paymentEvent->createdAt = $paymentEvent->createdAt->format('Y-m-d H:i:s');
        if(!in_array($paymentEvent->paymentType, PaymentEvent::getEventTypeList())){
            throw new \Exception("Недопустимый тип события",400);
        }
        if (!$paymentEvent->save()) {
            throw new \Exception("Ошибка при обновлении события платежа",500);
        }
        return $paymentEvent;

    }

    public static function updateEventType($id, $eventType)
    {
        $paymentEvent = PaymentEvent::getById($id);
        if (!$paymentEvent) {
            throw new \Exception("Событие платежа не найдено",404);
        }

        if(!in_array($eventType, PaymentEvent::getEventTypeList())){
            throw new \Exception("Недопустимый тип события платежа",400);
        }
        $paymentEvent->eventType = $eventType;
        if (!$paymentEvent->save()) {
            throw new \Exception("Ошибка при обновлении типа события платежа",500);
        }
        return $paymentEvent;
    }

    public static function delete($id)
    {
        $paymentEvent = PaymentEvent::getById($id);
        try {
            $paymentEvent->delete();
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private static function getById(int $contractId): PaymentEvent|array
    {
        $paymentEvent = PaymentEvent::getById($contractId);
        if(!$paymentEvent){
            throw new \Exception("Событие платежа не найдено",404);
        }
        return $paymentEvent;
    }

    public static function getAll(): array|null
    {
        $paymentEvents = PaymentEvent::getAll();
        if ($paymentEvents === null) {
            throw new \Exception("События платежей не найдены",404);
        }
        return $paymentEvents;
    }

    public static function getSumAmount ($paymentEventsArray): float
    {
        $sumAmount = 0;
        foreach ($paymentEventsArray as $paymentEvent) {
            $sumAmount += $paymentEvent->amount;
        }
        return $sumAmount;
    }

}