<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ref_number') ?>

    <?= $form->field($model, 'iban') ?>

    <?= $form->field($model, 'bic') ?>

    <?= $form->field($model, 'from_iban') ?>

    <?php // echo $form->field($model, 'bic_sender') ?>

    <?php // echo $form->field($model, 'name_sender') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'balance_after') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'transaction_reference') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('transaction', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('transaction', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
