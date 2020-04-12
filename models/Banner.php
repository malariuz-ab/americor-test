<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use app\helpers\Constant;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property int $id
 * @property string $path
 * @property string $where_used
 * @property string $weblink
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Banner extends \yii\db\ActiveRecord
{
    const WHERE_USED_NEWS_MAIN_PAGE = 1;
    const WHERE_USED_RUSSIAN_FAIRS_MAIN_PAGE = 2;
    const WHERE_USED_FOREIGN_FAIRS_MAIN_PAGE = 3;
    const WHERE_USED_SEMINARS_MAIN_PAGE = 4;
    const WHERE_USED_DIRECTION_ELECTRON_PAGE = 5;
    const WHERE_USED_DIRECTION_MICROELECTRON_PAGE = 6;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['where_used', 'filter', 'filter' => function($value) {
                if (is_array($value)) {
                    $string = '';
                    foreach ($value as $number) {
                        if (!is_numeric($number)) continue;
                        $string .= $number;
                        if (next($value)) {
                            $string .= ',';
                        }
                    }
                    if (isset($string)) return $string;
                } else if (is_string($value)) {
                    return $value;
                } else if (empty($value)) {
                    return '';
                }
            }],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['path', 'where_used', 'weblink'], 'string', 'max' => 255],

            ['status', 'default', 'value' => Constant::STATUS_ON],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'path' => Yii::t('app', 'Изображение'),
            'where_used' => Yii::t('app', 'Где отображается'),
            'weblink' => Yii::t('app', 'Cсылка'),
            'status' => Yii::t('app', 'Сатус'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    public function preparedSelectedUsedPlaceForOutput()
    {
        if (!empty($this->where_used)) {
            $this->where_used = explode(',', $this->where_used);
        }
    }

    /**
     * {@inheritdoc}
     * @return BannerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BannerQuery(get_called_class());
    }
}
