<?php

namespace common\models\core\ar;

use yii\data\ActiveDataProvider;

/**
 * Class for search and filtering redirects
 *
 * @property string $from Closed url
 * @property string $to Url to redirect
 *
 * @package common\models\core\ar
 */
class RedirectSearch extends Redirect
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'to'], 'string'],
            [['status'], 'integer'],
        ];
    }

    /**
     * Search redirects
     *
     * @param array $params Search params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Redirect::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->status)) {
            $query->andWhere([
                'status' => $this->status,
            ]);
        }

        $query->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'to', $this->to]);

        return $dataProvider;
    }
}
