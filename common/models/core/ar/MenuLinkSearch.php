<?php
namespace common\models\core\ar;

use yii\data\ActiveDataProvider;

/**
 * Класс для поиска и фильтрации пунктов меню.
 *
 * @property int    $menu_id menu ID
 * @property int    $parent_id Parent item ID
 * @property string $title Item title
 * @property string $link item link
 *
 * @package common\models\core\ar
 */
class MenuLinkSearch extends MenuLink
{

    /**
     * @var int Parent ID
     */
    public $parent_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'parent_id'], 'integer'],
            [['is_active'], 'boolean'],
            [['title', 'link', 'target'], 'string', 'max' => 255],
        ];
    }

    /**
     * Filter menu items
     *
     * @param array $params filter params
     * @param int   $langID Language ID
     * @param int   $menuID Menu ID
     *
     * @return ActiveDataProvider
     */
    public function search($params, $langID, $menuID)
    {
        $query = MenuLink::find()->joinWith('parent AS parent');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'menu_link.menu_id'   => $menuID,
            'menu_link.lang_id'   => $langID,
            'menu_link.parent_id' => $this->parent_id,
            'menu_link.is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'menu_link.title', $this->title])
            ->andFilterWhere(['like', 'menu_link.link', $this->link])
            ->andFilterWhere(['like', 'menu_link.target', $this->target]);

        return $dataProvider;
    }
}
