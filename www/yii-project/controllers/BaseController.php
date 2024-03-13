<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;


class BaseController extends Controller
{

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],

            /*

            'authenticator' => [
                'class' => \yii\filters\auth\HttpBearerAuth::class,
                'except' => ['login', 'all-users'], // Исключаем действие login из аутентификации
            ],

            */
/*
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['all-users'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
*/


        ];
    }

}