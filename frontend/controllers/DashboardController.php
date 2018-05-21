<?php

namespace frontend\controllers;

class DashboardController extends \frontend\components\FrontendController
{
    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

}
