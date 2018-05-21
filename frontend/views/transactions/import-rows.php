<?php

use \yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this \yii\web\View
 * @var $importForm \frontend\models\ImportForm
 */

$this->registerCss(<<<CSS
table td {
    border: 1px solid black;
}
CSS
);

function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    $string = mb_strtolower($string);

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

$rows = $importForm->rows;
$headings = $rows[0];
$rowCount = count($rows);

?>
<div>
    <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['transactions/import-rows'])]); ?>
    <p>Total rows: <?= $rowCount - 1; // - the total row ?></p>
    <table class="table table-condensed table-responsive">
        <thead>
        <tr>
            <th>Select</th>
            <th></th>
            <th></th>
            <?php foreach ($headings as $heading): ?>
                <th><?= Html::encode($heading) ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 1; $i < $rowCount; $i++): ?>
            <tr>
                <td><?= Html::checkbox("rows[$i][selected]", true); ?></td>
                <td><?= Html::hiddenInput("rows[$i][id]", $i); ?></td>
                <td>#<?= $i ?></td>
                <?php
                $dataCount = count($rows[$i]);

                for ($j = 0; $j < $dataCount; $j++):
                    $heading = clean($headings[$j]);
                    ?>
                    <td><?= Html::textInput("rows[$i][$heading]", Html::encode($rows[$i][$j]), ['readonly' => 'readonly']); ?></td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>

    <?= Html::submitButton('Import Rows'); ?>

    <?php ActiveForm::end() ?>
</div>
