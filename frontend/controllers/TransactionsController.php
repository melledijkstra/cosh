<?php

namespace frontend\controllers;

use frontend\models\ImportForm;
use Yii;
use common\models\Transaction;
use common\models\TransactionSearch;
use frontend\components\FrontendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * TransactionsController implements the CRUD actions for Transaction model.
 */
class TransactionsController extends FrontendController
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Transaction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionImport(): string
    {
        $importForm = new ImportForm();

        if ($importForm->load(\Yii::$app->request->post())) {
            $importForm->uploadedFile = UploadedFile::getInstance($importForm, 'uploadedFile');
            if ($importForm->validate()) {
                $importForm->parseFile();
                return $this->render('import-rows', [
                    'importForm' => $importForm,
                ]);
            }
        }

        return $this->render('import', [
            'importForm' => $importForm,
        ]);
    }

    /**
     * max_input_vars php setting should be set high to parse all the given data
     * @throws \yii\base\InvalidConfigException
     */
    public function actionImportRows()
    {
        $rows = \Yii::$app->request->post('rows');
        if ($rows !== null) {
            foreach ($rows as $row) {
                // check if user wants to include the row
                if (isset($row['selected']) && $row['selected']) {
                    $description = (!empty($row['omschrijving-1'])) ? $row['omschrijving-1']
                        : !empty($row['omschrijving-2']) ? $row['omschrijving-2']
                            : !empty($row['omschrijving-3']) ? $row['omschrijving-3'] : '';
                    $transaction = new Transaction([
                        'iban' => $row['ibanbban'],
                        'bic' => !empty($row['bic']) ? $row['bic'] : null,
                        'bic_sender' => !empty($row['bic-tegenpartij']) ? $row['bic-tegenpartij'] : null,
                        'from_iban' => !empty($row['tegenrekening-ibanbban']) ? $row['tegenrekening-ibanbban'] : null,
                        'name_sender' => !empty($row['naam-tegenpartij']) ? $row['naam-tegenpartij'] : null,
                        'currency' => !empty($row['munt']) ? $row['munt'] : null,
                        'date' => \Yii::$app->formatter->asDate($row['datum'], 'Y-M-d'),
                        'amount' => $this->parseCurrency($row['bedrag']),
                        'balance_after' => $this->parseCurrency($row['saldo-na-trn']),
                        'description' => !empty($description) ? $description : null,
                        'code' => !empty($row['code']) ? $row['code'] : null,
                    ]);
                    if (!$transaction->validate()) {
                        \Yii::$app->session->removeAllFlashes();
                        foreach ($transaction->getFirstErrors() as $error) {
                            \Yii::$app->session->addFlash('danger', "($row[id]) $error");
                        }
                    } else {
                        $transaction->save();
                    }
                }
            }
            return $this->redirect(['transactions/index']);
        }
    }

    /**
     * Deletes an existing Transaction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws \yii\db\StaleObjectException
     * @throws \Exception
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('transaction', 'The requested page does not exist.'));
    }

    /**
     * @param $str
     * @return float
     */
    private function parseCurrency($str)
    {
        $str = str_replace(',', '.', $str);
        return (float)filter_var($str, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
