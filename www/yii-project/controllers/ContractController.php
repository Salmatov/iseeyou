<?php

namespace app\controllers;

use app\dto\ContractCreationDTO;
use app\dto\ContractUpdateDTO;
use app\service\ContractService;
use DateTime;
use Yii;
use yii\rest\Controller;

class ContractController extends Controller
{
    public static function actionCreate()
    {
        $contractData = json_decode(Yii::$app->request->getRawBody());
        try {
            $contractData->createdAt = new DateTime($contractData->createdAt);
            $contractData->installmentCompletionDate = new DateTime($contractData->installmentCompletionDate);
            $contractCreationDTO = new ContractCreationDTO($contractData);
            return ContractService::create($contractCreationDTO);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionUpdate()
    {
        $contractData = json_decode(Yii::$app->request->getRawBody());
        try {
            $contractData->createdAt = new DateTime($contractData->createdAt);
            $contractData->installmentCompletionDate = new DateTime($contractData->installmentCompletionDate);
            $contractUpdateDTO = new ContractUpdateDTO($contractData);
            return ContractService::update($contractUpdateDTO);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionUpdateStatus()
    {
        $contractData = json_decode(Yii::$app->request->getRawBody());
        try {
            return ContractService::updateStatus($contractData->id, $contractData->status);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionDelete($id)
    {
        try {
            return ContractService::delete($id);
        }catch (\Exception $e){
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionAllContracts():array
    {
        try {
            return ContractService::getAll();
        }catch (\Exception $e){
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public function actionStatusList()
    {
        return ContractService::getStatusList();
    }

}