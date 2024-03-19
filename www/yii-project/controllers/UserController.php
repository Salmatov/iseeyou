<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\dto\UserCreationDTO;
use app\dto\UserUpdateDTO;
use app\service\UserService;
use yii\filters\AccessControl;
use yii\rest\Controller;

class UserController extends BaseController
{

    public function actionAllUsers(){
        try {
            $users = UserService::getAll();
            return $users;
        }catch (\Exception $e) {
            Yii::$app->response->setStatusCode($e->getCode());
            return ['error' => $e->getMessage()];
        }}

    public function actionError(){
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $exception->getMessage();
        }
    }

    public function actionCreate(){
        $requestData = json_decode(Yii::$app->request->getRawBody());
        $userCreationDTO = new UserCreationDTO($requestData);
        try {
            return UserService::createUser($userCreationDTO);
        }catch (\Exception $e) {
            //Yii::$app->response->setStatusCode($e->getCode());
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