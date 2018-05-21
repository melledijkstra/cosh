<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\TransactionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('transaction', 'Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <a class="btn btn-primary pull-right" href="<?= \yii\helpers\Url::to(['transactions/import']) ?>">Import Transactions</a>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a(Yii::t('transaction', 'Create Transaction'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model) {
            /** @var $model \common\models\Transaction */
            return ['class' => $model->amount < 0 ? 'danger' : 'success'];
        },
        'columns' => [
            'id',
            'iban',
            'from_iban',
            'amount:currency',
            'name_sender',
            'currency',
            'date:date',
            'balance_after:currency',
            'description',
            'category.name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
