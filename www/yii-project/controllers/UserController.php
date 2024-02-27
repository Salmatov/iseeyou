<?php

namespace app\controllers;

use app\models\Mytable;
use app\models\User;
use Yii;
use yii\rest\Controller;
use app\dto\UserCreationDTO;
use app\dto\UserUpdateDTO;
use app\service\UserService;

class UserController extends Controller
{

    public function actionAllUsers(){
        try {
            return UserService::getAll();
        }catch (\Exception $e) {
            //Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }}

    public function actionCreate(){
        $requestData = json_decode(Yii::$app->request->getRawBody());
        $userCreationDTO = new UserCreationDTO($requestData);
        try {
            return UserService::createUser($userCreationDTO);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public function actionUpdate(){
        $userData = json_decode(Yii::$app->request->getRawBody());
        $userUpdateDTO = new UserUpdateDTO($userData);
        try {
            return UserService::updateUser($userUpdateDTO);
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }

    public function actionDelete($id)
    {
        try {
            $user = UserService::getById($id);
            return UserService::deleteUser($user);
        } catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }
    }
}