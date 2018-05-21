<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `common\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['id', 'ref_number', 'amount', 'balance_after', 'transaction_reference', 'category_id'], 'integer'],
            [['iban', 'bic', 'from_iban', 'bic_sender', 'name_sender', 'currency', 'date', 'description', 'code'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transaction::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ref_number' => $this->ref_number,
            'date' => $this->date,
            'amount' => $this->amount,
            'balance_after' => $this->balance_after,
            'transaction_reference' => $this->transaction_reference,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'iban', $this->iban])
            ->andFilterWhere(['like', 'bic', $this->bic])
            ->andFilterWhere(['like', 'from_iban', $this->from_iban])
            ->andFilterWhere(['like', 'bic_sender', $this->bic_sender])
            ->andFilterWhere(['like', 'name_sender', $this->name_sender])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
