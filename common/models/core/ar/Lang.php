<?php

namespace common\models\core\ar;

use Yii;

/**
 * Front language AR model
 *
 * @property int    $id Language ID
 * @property string $url Url to site version using this language. Isn't displayed in url if there is default language
 * @property string $local Language locale
 * @property string $title Language title
 * @property string $icon Language icon
 * @property bool   $is_default Is this language default for site
 *
 * @package common\models\core\ar
 */
class Lang extends EntityModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'local', 'title', 'icon'], 'required'],
            [['is_default'], 'integer'],
            [['url', 'local', 'title', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('core/attributes', 'id'),
            'url'        => Yii::t('core/attributes', 'url'),
            'local'      => Yii::t('core/attributes', 'local'),
            'title'      => Yii::t('core/attributes', 'title'),
            'is_default' => Yii::t('core/attributes', 'is_default'),
            'icon'       => Yii::t('core/attributes', 'icon'),
        ];
    }

    /**
     * Is language setted up as current?
     *
     * @return bool
     */
    public function isCurrent()
    {
        return $this->local === Yii::$app->language;
    }

    /**
     * Full save language
     *
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function fullSave()
    {
        if ($this->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($this->is_default == 1) {
                    Yii::$app->db->createCommand("UPDATE `lang` SET `is_default` = 0")->execute();
                }
                $this->save(false);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Full delete language. If language was default, first language in list set as default
     *
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function fullDelete()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->delete();
            if (Lang::find()->where(['is_default' => 1])->count() === 0) {
                /** @var static $model */
                $model = static::find()->one();
                $model->is_default = 1;
                $model->save();
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return true;
    }

    public static function getIconList()
    {
        return [
            'af' => Yii::t("core/countries",'Afghanistan'),
            'ax' => Yii::t("core/countries",'Aland Islands'),
            'al' => Yii::t("core/countries",'Albania'),
            'dz' => Yii::t("core/countries",'Algeria'),
            'as' => Yii::t("core/countries",'American Samoa'),
            'ad' => Yii::t("core/countries",'Andorra'),
            'ao' => Yii::t("core/countries",'Angola'),
            'ai' => Yii::t("core/countries",'Anguilla'),
            'ag' => Yii::t("core/countries",'Antigua and Barbuda'),
            'ar' => Yii::t("core/countries",'Argentina'),
            'am' => Yii::t("core/countries",'Armenia'),
            'aw' => Yii::t("core/countries",'Aruba'),
            'au' => Yii::t("core/countries",'Australia'),
            'at' => Yii::t("core/countries",'Austria'),
            'az' => Yii::t("core/countries",'Azerbaijan'),
            'bs' => Yii::t("core/countries",'Bahamas'),
            'bh' => Yii::t("core/countries",'Bahrain'),
            'bd' => Yii::t("core/countries",'Bangladesh'),
            'bb' => Yii::t("core/countries",'Barbados'),
            'by' => Yii::t("core/countries",'Belarus'),
            'be' => Yii::t("core/countries",'Belgium'),
            'bz' => Yii::t("core/countries",'Belize'),
            'bj' => Yii::t("core/countries",'Benin'),
            'bm' => Yii::t("core/countries",'Bermuda'),
            'bt' => Yii::t("core/countries",'Bhutan'),
            'bo' => Yii::t("core/countries",'Bolivia (Plurinational State of)'),
            'bq' => Yii::t("core/countries",'Bonaire, Sint Eustatius and Saba'),
            'ba' => Yii::t("core/countries",'Bosnia and Herzegovina'),
            'bw' => Yii::t("core/countries",'Botswana'),
            'br' => Yii::t("core/countries",'Brazil'),
            'io' => Yii::t("core/countries",'British Indian Ocean Territory'),
            'bn' => Yii::t("core/countries",'Brunei Darussalam'),
            'bg' => Yii::t("core/countries",'Bulgaria'),
            'bf' => Yii::t("core/countries",'Burkina Faso'),
            'bi' => Yii::t("core/countries",'Burundi'),
            'cv' => Yii::t("core/countries",'Cabo Verde'),
            'kh' => Yii::t("core/countries",'Cambodia'),
            'cm' => Yii::t("core/countries",'Cameroon'),
            'ca' => Yii::t("core/countries",'Canada'),
            'ky' => Yii::t("core/countries",'Cayman Islands'),
            'cf' => Yii::t("core/countries",'Central African Republic'),
            'td' => Yii::t("core/countries",'Chad'),
            'cl' => Yii::t("core/countries",'Chile'),
            'cn' => Yii::t("core/countries",'China'),
            'cx' => Yii::t("core/countries",'Christmas Island'),
            'cc' => Yii::t("core/countries",'Cocos (Keeling) Islands'),
            'co' => Yii::t("core/countries",'Colombia'),
            'km' => Yii::t("core/countries",'Comoros'),
            'ck' => Yii::t("core/countries",'Cook Islands'),
            'cr' => Yii::t("core/countries",'Costa Rica'),
            'hr' => Yii::t("core/countries",'Croatia'),
            'cu' => Yii::t("core/countries",'Cuba'),
            'cw' => Yii::t("core/countries",'Curaçao'),
            'cy' => Yii::t("core/countries",'Cyprus'),
            'cz' => Yii::t("core/countries",'Czech Republic'),
            'ci' => Yii::t("core/countries","Côte d'Ivoire"),
            'cd' => Yii::t("core/countries",'Democratic Republic of the Congo'),
            'dk' => Yii::t("core/countries",'Denmark'),
            'dj' => Yii::t("core/countries",'Djibouti'),
            'dm' => Yii::t("core/countries",'Dominica'),
            'do' => Yii::t("core/countries",'Dominican Republic'),
            'ec' => Yii::t("core/countries",'Ecuador'),
            'eg' => Yii::t("core/countries",'Egypt'),
            'sv' => Yii::t("core/countries",'El Salvador'),
            'gq' => Yii::t("core/countries",'Equatorial Guinea'),
            'er' => Yii::t("core/countries",'Eritrea'),
            'ee' => Yii::t("core/countries",'Estonia'),
            'et' => Yii::t("core/countries",'Ethiopia'),
            'fk' => Yii::t("core/countries",'Falkland Islands'),
            'fo' => Yii::t("core/countries",'Faroe Islands'),
            'fm' => Yii::t("core/countries",'Federated States of Micronesia'),
            'fj' => Yii::t("core/countries",'Fiji'),
            'fi' => Yii::t("core/countries",'Finland'),
            'mk' => Yii::t("core/countries",'Former Yugoslav Republic of Macedonia'),
            'fr' => Yii::t("core/countries",'France'),
            'gf' => Yii::t("core/countries",'French Guiana'),
            'pf' => Yii::t("core/countries",'French Polynesia'),
            'tf' => Yii::t("core/countries",'French Southern Territories'),
            'ga' => Yii::t("core/countries",'Gabon'),
            'gm' => Yii::t("core/countries",'Gambia'),
            'ge' => Yii::t("core/countries",'Georgia'),
            'de' => Yii::t("core/countries",'Germany'),
            'gh' => Yii::t("core/countries",'Ghana'),
            'gi' => Yii::t("core/countries",'Gibraltar'),
            'gr' => Yii::t("core/countries",'Greece'),
            'gl' => Yii::t("core/countries",'Greenland'),
            'gd' => Yii::t("core/countries",'Grenada'),
            'gp' => Yii::t("core/countries",'Guadeloupe'),
            'gu' => Yii::t("core/countries",'Guam'),
            'gt' => Yii::t("core/countries",'Guatemala'),
            'gg' => Yii::t("core/countries",'Guernsey'),
            'gn' => Yii::t("core/countries",'Guinea'),
            'gw' => Yii::t("core/countries",'Guinea-Bissau'),
            'gy' => Yii::t("core/countries",'Guyana'),
            'ht' => Yii::t("core/countries",'Haiti'),
            'va' => Yii::t("core/countries",'Holy See'),
            'hn' => Yii::t("core/countries",'Honduras'),
            'hk' => Yii::t("core/countries",'Hong Kong'),
            'hu' => Yii::t("core/countries",'Hungary'),
            'is' => Yii::t("core/countries",'Iceland'),
            'in' => Yii::t("core/countries",'India'),
            'id' => Yii::t("core/countries",'Indonesia'),
            'ir' => Yii::t("core/countries",'Iran (Islamic Republic of)'),
            'iq' => Yii::t("core/countries",'Iraq'),
            'ie' => Yii::t("core/countries",'Ireland'),
            'im' => Yii::t("core/countries",'Isle of Man'),
            'il' => Yii::t("core/countries",'Israel'),
            'it' => Yii::t("core/countries",'Italy'),
            'jm' => Yii::t("core/countries",'Jamaica'),
            'jp' => Yii::t("core/countries",'Japan'),
            'je' => Yii::t("core/countries",'Jersey'),
            'jo' => Yii::t("core/countries",'Jordan'),
            'kz' => Yii::t("core/countries",'Kazakhstan'),
            'ke' => Yii::t("core/countries",'Kenya'),
            'ki' => Yii::t("core/countries",'Kiribati'),
            'kw' => Yii::t("core/countries",'Kuwait'),
            'kg' => Yii::t("core/countries",'Kyrgyzstan'),
            'la' => Yii::t("core/countries",'Laos'),
            'lv' => Yii::t("core/countries",'Latvia'),
            'lb' => Yii::t("core/countries",'Lebanon'),
            'ls' => Yii::t("core/countries",'Lesotho'),
            'lr' => Yii::t("core/countries",'Liberia'),
            'ly' => Yii::t("core/countries",'Libya'),
            'li' => Yii::t("core/countries",'Liechtenstein'),
            'lt' => Yii::t("core/countries",'Lithuania'),
            'lu' => Yii::t("core/countries",'Luxembourg'),
            'mo' => Yii::t("core/countries",'Macau'),
            'mg' => Yii::t("core/countries",'Madagascar'),
            'mw' => Yii::t("core/countries",'Malawi'),
            'my' => Yii::t("core/countries",'Malaysia'),
            'mv' => Yii::t("core/countries",'Maldives'),
            'ml' => Yii::t("core/countries",'Mali'),
            'mt' => Yii::t("core/countries",'Malta'),
            'mh' => Yii::t("core/countries",'Marshall Islands'),
            'mq' => Yii::t("core/countries",'Martinique'),
            'mr' => Yii::t("core/countries",'Mauritania'),
            'mu' => Yii::t("core/countries",'Mauritius'),
            'yt' => Yii::t("core/countries",'Mayotte'),
            'mx' => Yii::t("core/countries",'Mexico'),
            'md' => Yii::t("core/countries",'Moldova'),
            'mc' => Yii::t("core/countries",'Monaco'),
            'mn' => Yii::t("core/countries",'Mongolia'),
            'me' => Yii::t("core/countries",'Montenegro'),
            'ms' => Yii::t("core/countries",'Montserrat'),
            'ma' => Yii::t("core/countries",'Morocco'),
            'mz' => Yii::t("core/countries",'Mozambique'),
            'mm' => Yii::t("core/countries",'Myanmar'),
            'na' => Yii::t("core/countries",'Namibia'),
            'nr' => Yii::t("core/countries",'Nauru'),
            'np' => Yii::t("core/countries",'Nepal'),
            'nl' => Yii::t("core/countries",'Netherlands'),
            'nc' => Yii::t("core/countries",'New Caledonia'),
            'nz' => Yii::t("core/countries",'New Zealand'),
            'ni' => Yii::t("core/countries",'Nicaragua'),
            'ne' => Yii::t("core/countries",'Niger'),
            'ng' => Yii::t("core/countries",'Nigeria'),
            'nu' => Yii::t("core/countries",'Niue'),
            'nf' => Yii::t("core/countries",'Norfolk Island'),
            'kp' => Yii::t("core/countries",'North Korea'),
            'mp' => Yii::t("core/countries",'Northern Mariana Islands'),
            'no' => Yii::t("core/countries",'Norway'),
            'om' => Yii::t("core/countries",'Oman'),
            'pk' => Yii::t("core/countries",'Pakistan'),
            'pw' => Yii::t("core/countries",'Palau'),
            'pa' => Yii::t("core/countries",'Panama'),
            'pg' => Yii::t("core/countries",'Papua New Guinea'),
            'py' => Yii::t("core/countries",'Paraguay'),
            'pe' => Yii::t("core/countries",'Peru'),
            'ph' => Yii::t("core/countries",'Philippines'),
            'pn' => Yii::t("core/countries",'Pitcairn'),
            'pl' => Yii::t("core/countries",'Poland'),
            'pt' => Yii::t("core/countries",'Portugal'),
            'pr' => Yii::t("core/countries",'Puerto Rico'),
            'qa' => Yii::t("core/countries",'Qatar'),
            'cg' => Yii::t("core/countries",'Republic of the Congo'),
            'ro' => Yii::t("core/countries",'Romania'),
            'ru' => Yii::t("core/countries",'Russia'),
            'rw' => Yii::t("core/countries",'Rwanda'),
            're' => Yii::t("core/countries",'Réunion'),
            'bl' => Yii::t("core/countries",'Saint Barthélemy'),
            'sh' => Yii::t("core/countries",'Saint Helena, Ascension and Tristan da Cunha'),
            'kn' => Yii::t("core/countries",'Saint Kitts and Nevis'),
            'lc' => Yii::t("core/countries",'Saint Lucia'),
            'mf' => Yii::t("core/countries",'Saint Martin'),
            'pm' => Yii::t("core/countries",'Saint Pierre and Miquelon'),
            'vc' => Yii::t("core/countries",'Saint Vincent and the Grenadines'),
            'ws' => Yii::t("core/countries",'Samoa'),
            'sm' => Yii::t("core/countries",'San Marino'),
            'st' => Yii::t("core/countries",'Sao Tome and Principe'),
            'sa' => Yii::t("core/countries",'Saudi Arabia'),
            'sn' => Yii::t("core/countries",'Senegal'),
            'rs' => Yii::t("core/countries",'Serbia'),
            'sc' => Yii::t("core/countries",'Seychelles'),
            'sl' => Yii::t("core/countries",'Sierra Leone'),
            'sg' => Yii::t("core/countries",'Singapore'),
            'sx' => Yii::t("core/countries",'Sint Maarten'),
            'sk' => Yii::t("core/countries",'Slovakia'),
            'si' => Yii::t("core/countries",'Slovenia'),
            'sb' => Yii::t("core/countries",'Solomon Islands'),
            'so' => Yii::t("core/countries",'Somalia'),
            'za' => Yii::t("core/countries",'South Africa'),
            'gs' => Yii::t("core/countries",'South Georgia and the South Sandwich Islands'),
            'kr' => Yii::t("core/countries",'South Korea'),
            'ss' => Yii::t("core/countries",'South Sudan'),
            'es' => Yii::t("core/countries",'Spain'),
            'lk' => Yii::t("core/countries",'Sri Lanka'),
            'ps' => Yii::t("core/countries",'State of Palestine'),
            'sd' => Yii::t("core/countries",'Sudan'),
            'sr' => Yii::t("core/countries",'Suriname'),
            'sj' => Yii::t("core/countries",'Svalbard and Jan Mayen'),
            'sz' => Yii::t("core/countries",'Swaziland'),
            'se' => Yii::t("core/countries",'Sweden'),
            'ch' => Yii::t("core/countries",'Switzerland'),
            'sy' => Yii::t("core/countries",'Syrian Arab Republic'),
            'tw' => Yii::t("core/countries",'Taiwan'),
            'tj' => Yii::t("core/countries",'Tajikistan'),
            'tz' => Yii::t("core/countries",'Tanzania'),
            'th' => Yii::t("core/countries",'Thailand'),
            'tl' => Yii::t("core/countries",'Timor-Leste'),
            'tg' => Yii::t("core/countries",'Togo'),
            'tk' => Yii::t("core/countries",'Tokelau'),
            'to' => Yii::t("core/countries",'Tonga'),
            'tt' => Yii::t("core/countries",'Trinidad and Tobago'),
            'tn' => Yii::t("core/countries",'Tunisia'),
            'tr' => Yii::t("core/countries",'Turkey'),
            'tm' => Yii::t("core/countries",'Turkmenistan'),
            'tc' => Yii::t("core/countries",'Turks and Caicos Islands'),
            'tv' => Yii::t("core/countries",'Tuvalu'),
            'ug' => Yii::t("core/countries",'Uganda'),
            'ua' => Yii::t("core/countries",'Ukraine'),
            'ae' => Yii::t("core/countries",'United Arab Emirates'),
            'gb' => Yii::t("core/countries",'United Kingdom'),
            'um' => Yii::t("core/countries",'United States Minor Outlying Islands'),
            'us' => Yii::t("core/countries",'United States of America'),
            'uy' => Yii::t("core/countries",'Uruguay'),
            'uz' => Yii::t("core/countries",'Uzbekistan'),
            'vu' => Yii::t("core/countries",'Vanuatu'),
            've' => Yii::t("core/countries",'Venezuela (Bolivarian Republic of)'),
            'vn' => Yii::t("core/countries",'Vietnam'),
            'vg' => Yii::t("core/countries",'Virgin Islands (British)'),
            'vi' => Yii::t("core/countries",'Virgin Islands (U.S.)'),
            'wf' => Yii::t("core/countries",'Wallis and Futuna'),
            'eh' => Yii::t("core/countries",'Western Sahara'),
            'ye' => Yii::t("core/countries",'Yemen'),
            'zm' => Yii::t("core/countries",'Zambia'),
            'zw' => Yii::t("core/countries",'Zimbabwe'),
        ];
    }
}
