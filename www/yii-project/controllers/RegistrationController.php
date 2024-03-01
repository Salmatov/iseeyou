<?php

namespace app\controllers;

use app\dto\RegistrationUserDTO;
use app\service\UserService;
use Yii;
use yii\rest\Controller;

class RegistrationController extends Controller
{
    public function actionRegistration(){
        $requestData = json_decode(Yii::$app->request->getRawBody());
        $registrationUserDTO = new RegistrationUserDTO($requestData);
        try {
            return UserService::registration($registrationUserDTO);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }
}