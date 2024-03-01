<?php

namespace app\controllers;

use app\dto\AuthorizationDTO;
use app\service\UserService;
use Yii;
use yii\rest\Controller;

class AuthorizationController extends Controller
{
    public static function actionAuthorization(){
        $requestData = json_decode(Yii::$app->request->getRawBody());
        $authorizationDTO = new AuthorizationDTO($requestData);
        try {
            return UserService::authorization($authorizationDTO);
        }catch (\Exception $e) {
            //Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public static function actionLogout(){
        $authKey = Yii::$app->request->headers->get('authkey');
        try {
            return UserService::logout($authKey);
        } catch (\Exception $e) {
            //Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

}