<?php

namespace admin\models\core\ar;

use common\models\core\ar\Lang;
use yii\data\ActiveDataProvider;

/**
 * Language search model
 *
 * @package admin\models\core\ar
 */
class LangSearch extends Lang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_default'], 'integer'],
            [['url', 'local', 'title'], 'string'],
        ];
    }

    /**
     * Filter language list
     *
     * @param array $params Params for filter
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Lang::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'            => $this->id,
            'is_default'       => $this->is_default,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'local', $this->local])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
