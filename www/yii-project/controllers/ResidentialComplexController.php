<?php

namespace app\controllers;

use app\dto\ResidentialComplexCreationDTO;
use app\dto\ResidentialComplexUpdateDTO;
use app\service\ResidentialComplexService;
use app\service\TimeService;
use DateTime;
use Yii;
use yii\rest\Controller;

class ResidentialComplexController extends Controller
{

    public function actionCreate()
    {
        $complexData = json_decode(Yii::$app->request->getRawBody());
        try {
            $complexData->installmentCompletionDate = TimeService::setDateTime($complexData->installmentCompletionDate);
            $residentialComplexCreationDTO = new ResidentialComplexCreationDTO($complexData);
            $residentialComplex = ResidentialComplexService::create($residentialComplexCreationDTO);
        }catch (\Exception $e){
            //Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
        return $residentialComplex;
    }

    public function actionUpdate()
    {
        $complexData = json_decode(Yii::$app->request->getRawBody());
        try {
            $complexData->instalmentCompletionDate = new DateTime($complexData->installmentCompletionDate);
            $residentialComplexUpdateDTO = new ResidentialComplexUpdateDTO($complexData);
            $residentialComplex = ResidentialComplexService::update($residentialComplexUpdateDTO);
        }catch (\Exception $e){
            //Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
        return $residentialComplex;
    }


    public function actionDelete($id)
    {
        try {
            ResidentialComplexService::delete($id);
        }catch (\Exception $e){
//            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public function actionAllResidentialComplexes(): array
    {
            return ResidentialComplexService::getAll();
    }
}