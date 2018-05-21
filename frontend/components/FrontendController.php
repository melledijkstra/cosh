<?php

/**
 * Created by PhpStorm.
 * User: melle
 * Date: 2-11-2016
 * Time: 22:59
 */

namespace frontend\components;

use yii\filters\AccessControl;
use yii\web\Controller;

class FrontendController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}