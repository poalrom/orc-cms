<?php

namespace admin\helpers;

use common\models\core\ar\EntityModel;
use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * GridView helper.
 *
 * @package admin\helpers
 */
class GridHelper extends Component
{

    /**
     * Print status column and transform statuses to icons
     *
     * @param null|string $class Full classname
     * @param bool|int    $status Selected status in filter
     *
     * @return array
     */
    public static function statusColumn($class = null, $status = false)
    {
        if ($class) {
            $class = substr($class, strrpos($class, '\\') + 1);
        }

        return [
            'attribute'      => 'is_active',
            'format'         => 'raw',
            'value'          => function ($data) {
                $icon = $data->is_active ? 'eye' : 'eye-slash';

                return '<span aria-hidden="true" class="fa fa-' . $icon . '"></span>';
            },
            'filter'         => $class && $status ? Html::dropDownList($class . '[is_active]',
                $status,
                EntityModel::getStatuses(),
                [
                    'prompt' => Yii::t('core/prompts', 'all'),
                    'class'  => 'form-control',
                ]) : false,
            'headerOptions'  => [
                'class' => 'text-center',
            ],
            'contentOptions' => [
                'class' => 'action-column',
            ],
        ];
    }

    /**
     * Get template column
     *
     * @param string $class Full classname
     * @param int    $template Template from filter
     * @param string $catalog Directory for finding templates
     *
     * @return array
     */
    public static function templateColumn($class, $template, $catalog)
    {
        $class = substr($class, strrpos($class, '\\') + 1);

        return [
            'attribute'     => 'template',
            'format'        => 'raw',
            'value'         => function ($data) {
                return $data->template;
            },
            'filter'        => Html::dropDownList($class . '[template]',
                $template,
                FileHelper::getTemplates($template),
                [
                    'prompt' => Yii::t('core/prompts', 'all'),
                    'class'  => 'form-control',
                ]),
            'headerOptions' => [
                'class' => 'text-center',
            ],
        ];
    }

    /**
     * Centering column header
     *
     * @@param string $attribute Attribute name
     * @param string|null $value Attribute value
     * @param string      $format Value format
     *
     * @return array
     */
    public static function headerCenteredColumn($attribute, $value = null, $format = "text")
    {
        if (!is_null($value)) {
            return [
                'attribute'     => $attribute,
                'value'         => $value,
                'headerOptions' => [
                    'class' => 'text-center',
                ],
                'format'        => $format,
            ];
        }

        return [
            'attribute'     => $attribute,
            'headerOptions' => [
                'class' => 'text-center',
            ],
        ];
    }

    /**
     * Centering column
     *
     * @param string      $attribute Attribute name
     * @param string|null $value Attribute value
     * @param string      $format Value format
     *
     * @return array
     */
    public static function centeredColumn($attribute, $value = null, $format = "text")
    {
        $column = self::headerCenteredColumn($attribute, $value, $format);
        $column['contentOptions'] = [
            'class' => 'text-center',
        ];

        return $column;
    }

    /**
     * Url column. Model should have relation to [[Route]] using 'getRoute' method
     *
     * @return array
     */
    public static function urlColumn()
    {
        return [
            'attribute'     => 'url',
            'format'        => 'raw',
            'value'         => function ($model) {
                /** @var \front\interfaces\core\FrontEntityInterface $model */
                if ($model->route->is_active) {
                    return Html::a(Url::base(true) . $model->getUrl(), $model->getUrl(),
                        ['target' => '_blank']);
                } else {
                    return null;
                }
            },
            'headerOptions' => [
                'class' => 'text-center',
            ],
            'filter'        => null,
        ];
    }
}
