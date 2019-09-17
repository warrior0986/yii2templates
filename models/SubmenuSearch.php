<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Submenu;

/**
 * SubmenuSearch represents the model behind the search form of `app\models\Submenu`.
 */
class SubmenuSearch extends Submenu
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'menu_id', 'order'], 'integer'],
            [['label', 'icon', 'url'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Submenu::find();

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
            'menu_id' => $this->menu_id,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }

    public function searchByMenuId($menuId)
    {
        $query = Submenu::find()->where(['menu_id' => $menuId]);

        // add conditions that should always apply here
        $query->joinWith('menu');
        $query->orderBy([
            'menu.order' => SORT_ASC,
            'submenu.order'=>SORT_ASC
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     // return $dataProvider;
        // }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'menu_id' => $this->menu_id,
        //     'order' => $this->order,
        // ]);

        // $query->andFilterWhere(['like', 'label', $this->label])
        //     ->andFilterWhere(['like', 'icon', $this->icon])
        //     ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
