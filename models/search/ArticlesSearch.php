<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Articles;

/**
 * ArticlesSearch represents the model behind the search form of `app\models\Articles`.
 */
class ArticlesSearch extends Articles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'status'], 'integer'],
            [['title', 'created_at', 'updated_at', 'published_at'], 'safe'],
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
        $query = Articles::find();

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

        if (!empty($this->created_at)) {
            $query->andFilterWhere(
                [
                    'between',
                    'created_at',
                    strtotime($this->created_at),
                    strtotime($this->created_at . ' 23:59:59')
                ]
            );
        }

        if (!empty($this->updated_at)) {
            $query->andFilterWhere(
                [
                    'between',
                    'updated_at',
                    strtotime($this->updated_at),
                    strtotime($this->updated_at . ' 23:59:59')
                ]
            );
        }

        if (!empty($this->published_at)) {
            $query->andFilterWhere(
                [
                    'between',
                    'published_at',
                    strtotime($this->published_at),
                    strtotime($this->published_at . ' 23:59:59')
                ]
            );
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_by' => $this->created_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
