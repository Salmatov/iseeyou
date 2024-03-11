<?php

namespace app\controllers;

use app\dto\ApartmentCreationDTO;
use app\dto\ApartmentUpdateDTO;
use app\models\Apartment;
use app\service\ApartmentService;
use app\service\ContractService;
use app\service\ResidentialComplexService;
use Yii;
use yii\rest\Controller;

class ApartmentController extends Controller
{
    public static function actionCreate()
    {
        $apartmentData = json_decode(Yii::$app->request->getRawBody());
        try {
            $apartmentCreationDTO = new ApartmentCreationDTO($apartmentData);
            $residentialComplex = ResidentialComplexService::getById($apartmentCreationDTO->residenceId);
            $apartment = ApartmentService::create($apartmentCreationDTO);
        } catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
        return $apartment;
    }

    public static function actionUpdate()
    {
        $apartmentData = json_decode(Yii::$app->request->getRawBody());
        $apartmentUpdateDTO = new ApartmentUpdateDTO($apartmentData);
        try {
            $residentialComplex = ResidentialComplexService::getById($apartmentUpdateDTO->residenceId);
            return ApartmentService::update($apartmentUpdateDTO);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionUpdateStatus():array|Apartment
    {
        $apartmentData = json_decode(Yii::$app->request->getRawBody());
        try {
            return ApartmentService::updateStatus($apartmentData->id, $apartmentData->status);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionDelete($id):array|null
    {
        try {
            return ApartmentService::delete($id);
        } catch (\Exception $e){
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionAllApartments():array
    {
        try {
            return ApartmentService::getAll();
        }catch (\Exception $e){
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }
    public function actionApartmentList(int $number):array
    {
        return ApartmentService::getApartmentByNumber($number);
    }
}