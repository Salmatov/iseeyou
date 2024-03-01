<?php

namespace app\controllers;

use app\models\User;
use yii\filters\AccessControl;
use yii\rest\Controller;

class BaseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['all-users'],
                'denyCallback' => function () {
                    die('Доступ запрещен!');
                },
                'rules' => [
                    [
                        'allow'   => true,
                        'controllers' => ['user'],
                        'actions' => ['all-users'],
                        'roles'   => [User::ADMIN_ROLE],
                    ],
                ],
            ],
        ];
    }
}