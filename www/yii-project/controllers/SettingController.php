<?php

namespace app\controllers;

use yii\rest\Controller;

class SettingController extends Controller
{

    public static function actionIndex()
    {
        $settings = [
            'installmentMax' => 60,
            'contactStatusList' => [
                'active',
                'completed',
                'termination_process',
                'termination'
            ],
            'apartmentStatusList' => [
                'sold',
                'locked',
                'sell'
            ],
            'eventTypeList' => [
                'initial_payment',
                'monthly_payment',
                'refund'
            ],
            'userRoleList' => [
                'admin',
                'moderator',
                'user'
            ],
        ];

        return $settings;
    }

}