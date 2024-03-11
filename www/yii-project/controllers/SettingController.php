<?php

namespace app\controllers;

use yii\rest\Controller;

class SettingController extends Controller
{

    public static function actionIndex()
    {
        $settings = [
            'installmentMax' => 60,
        ];

        return $settings;
    }

}