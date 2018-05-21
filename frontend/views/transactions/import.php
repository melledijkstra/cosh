<?php

/**
 * @var $this \yii\web\View
 * @var $importForm \frontend\models\ImportForm
 */

?>
<h3>Import Transactions</h3>
<div>
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>

    <?= $form->field($importForm, 'uploadedFile')->fileInput(); ?>

    <?= \yii\helpers\Html::submitButton('Import'); ?>

    <?php \yii\widgets\ActiveForm::end(); ?>

</div>
