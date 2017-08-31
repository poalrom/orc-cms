<?php

namespace common\models\pages;

use yii\data\ActiveDataProvider;

/**
 * Page filter model
 *
 * @property int    $parent_id Parent ID. 0 if page hasn't parent
 * @property int    $is_active Page active flag
 * @property string $title Page title
 * @package common\models\pages
 */
class PageSearch extends Page
{

    /**
     * @var string Page title on current language
     */
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            ['is_active', 'boolean'],
            [['title'], 'string'],
        ];
    }

    /**
     * Filter pages
     *
     * @param array $params Filter params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Page::find()
            ->joinWith(['parent parent', 'currentTranslation']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $dataProvider->sort->attributes['title'] = [
            'asc'  => ['currentTranslation.title' => SORT_ASC],
            'desc' => ['currentTranslation.title' => SORT_DESC],
        ];
        $query->andFilterWhere([
            'page.parent_id' => $this->parent_id,
            'page.is_active' => $this->is_active,
        ]);
        $query->andFilterWhere(['like', 'currentTranslation.title', $this->title]);

        return $dataProvider;
    }
}
