<?php
/**
 * Created by PhpStorm.
 * User: Melle
 * Date: 25-3-2018
 * Time: 21:02
 */

namespace frontend\controllers;


use frontend\components\FrontendController;

class ImportController extends FrontendController
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