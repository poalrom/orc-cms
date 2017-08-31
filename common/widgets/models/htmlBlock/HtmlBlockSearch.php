<?php

namespace common\widgets\models\htmlBlock;

use yii\data\ActiveDataProvider;

/**
 * Class for search html blocks
 *
 * @property int    $is_active Is block active
 * @property string $alias Block alias
 *
 * @package common\widgets\models\htmlBlock
 */
class HtmlBlockSearch extends HtmlBlock
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_active'], 'boolean'],
            [['alias'], 'safe'],
        ];
    }

    /**
     * Search html blocks
     *
     * @param array $params search params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = HtmlBlock::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}
