<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use app\helpers\Constant;

/**
 * This is the model class for table "{{%event}}".
 *
 * @property int $id
 * @property int $company_id
 * @property int $direction_id
 * @property int $event_type
 * @property string $title
 * @property string $annotation
 * @property string $content
 * @property string $cover_image
 * @property string $location
 * @property string $event_date
 * @property int $publish_date
 * @property int $datetime_from
 * @property int $datetime_to
 * @property int $views_number
 * @property string $slug
 * @property int $status
 * @property bool $is_shown_on_main_page
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 */
class Event extends \yii\db\ActiveRecord
{
    const SCENARIO_UPDATE_WITH_UPLOAD = 'update_with_upload';

    const IS_SHOWN_ON_MAIN_PAGE_YES = 1;
    const IS_SHOWN_ON_MAIN_PAGE_NO = 0;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%event}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['direction_id', 'event_type', 'title', 'annotation', 'content', 'publish_date'], 'required'],
            [['title', 'annotation', 'content', 'event_date', 'location', 'slug'], 'trim'],
            [['content'], 'string'],
            ['annotation', 'string', 'max' => 400],
            [['company_id', 'direction_id', 'event_type', 'views_number', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title', 'event_date', 'cover_image', 'location', 'slug'], 'string', 'max' => 255],
            ['is_shown_on_main_page', 'boolean'],

            ['publish_date', 'date', 'format' => 'php:d-m-Y H:i', 'timestampAttribute' => 'publish_date', 'on' => self::SCENARIO_DEFAULT],
            ['datetime_from', 'date', 'format' => 'php:d-m-Y H:i', 'timestampAttribute' => 'datetime_from', 'on' => self::SCENARIO_DEFAULT],
            ['datetime_to', 'date', 'format' => 'php:d-m-Y H:i', 'timestampAttribute' => 'datetime_to', 'on' => self::SCENARIO_DEFAULT],
            [['publish_date', 'datetime_from', 'datetime_to'], 'integer', 'on' => self::SCENARIO_UPDATE_WITH_UPLOAD],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::class, 'targetAttribute' => ['company_id' => 'id']],
            
            ['status', 'default', 'value' => Constant::STATUS_PUBLISHED],
            ['views_number', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE_WITH_UPLOAD] = ['company_id', 'direction_id', 'event_type', 'title', 'annotation', 'content', 'cover_image', 'location', 'event_date', 'publish_date', 'datetime_from', 'datetime_to', 'views_number', 'status', 'slug', 'is_shown_on_main_page', 'created_at', 'created_by', 'updated_at', 'updated_by'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Компания'),
            'direction_id' => Yii::t('app', 'Направление'),
            'event_type' => Yii::t('app', 'Тип'),
            'title' => Yii::t('app', 'Заголовок на странице'),
            'annotation' => Yii::t('app', 'Аннотация'),
            'content' => Yii::t('app', 'Содержимое'),
            'cover_image' => Yii::t('app', 'Обложка'),
            'location' => Yii::t('app', 'Где происходило'),
            'event_date' => Yii::t('app', 'Дата проведения события'),
            'publish_date' => Yii::t('app', 'Дата публикации'),
            'datetime_from' => Yii::t('app', 'Когда начинается'),
            'datetime_to' => Yii::t('app', 'Когда заканчивается'),
            'views_number' => Yii::t('app', 'Количество просмотров'),
            'status' => Yii::t('app', 'Статус'),
            'slug' => Yii::t('app', 'Постоянная ссылка'),
            'is_shown_on_main_page' => Yii::t('app', 'Отображать на главной странице?'),
            'created_at' => Yii::t('app', 'Когда создано'),
            'created_by' => Yii::t('app', 'Кем создано'),
            'updated_at' => Yii::t('app', 'Когда обновлено'),
            'updated_by' => Yii::t('app', 'Кем обновлено'),
        ];
    }

    /**
     * Checks either it is a news or not
     * @return bool
     */
    public function isAnyTypeOfNews()
    {
        return $this->event_type === Constant::EVENT_TYPE_RUSSIAN_NEWS || $this->event_type === Constant::EVENT_TYPE_FOREIGN_NEWS;
    }

    /**
     * Prepares constants of types for the drop-down list
     * @return array
     */
    public function getAllTypesForDropDownList()
    {
        return [
            Constant::EVENT_TYPE_RUSSIAN_NEWS => Yii::t('app', 'Российская новость'),
            Constant::EVENT_TYPE_FOREIGN_NEWS => Yii::t('app', 'Зарубежная новость'),
            Constant::EVENT_TYPE_RUSSIAN_FAIR => Yii::t('app', 'Выставка в России'),
            Constant::EVENT_TYPE_FOREIGN_FAIR => Yii::t('app', 'Зарубежная выставка'),
            Constant::EVENT_TYPE_SEMINAR => Yii::t('app', 'Семинар или конференция'),
        ];
    }

    /**
     * Prepares constants of types for the drop-down list of a news type of events
     * @return array
     */
    public function getTypesForNewsDropDownList()
    {
        return [
            Constant::EVENT_TYPE_RUSSIAN_NEWS => Yii::t('app', 'Российская новость'),
            Constant::EVENT_TYPE_FOREIGN_NEWS => Yii::t('app', 'Зарубежная новость'),
        ];
    }

    /**
     * Prepares constants of types for the drop-down list of a not news type of events
     * @return array
     */
    public function getTypesForNotNewsDropDownList()
    {
        return [
            Constant::EVENT_TYPE_RUSSIAN_FAIR => Yii::t('app', 'Выставка в России'),
            Constant::EVENT_TYPE_FOREIGN_FAIR => Yii::t('app', 'Зарубежная выставка'),
            Constant::EVENT_TYPE_SEMINAR => Yii::t('app', 'Семинар или конференция'),
        ];
    }

    /**
     * Uses on a direction page
     * @param $model
     * @param $key
     * @return array
     */
    public static function getItemWithTag($model, $key)
    {
        $array = [];
        $i = 0;
        if (isset($key) && !empty($model)) {
            foreach ($model as $item) {
                if (!empty($item->tags)) {
                    foreach ($item->tags as $tag) {
                        if ($tag->tag->tag_key === $key) {
                            $array[$i] = $item;
                            if (count($array) > 9) break;
                            $i++;
                        }
                    }
                }
            }
        }
        return $array;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(CompanyData::class, ['account_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventComments()
    {
        return $this->hasMany(Comment::class, ['owner_id' => 'id'])->andWhere(['owner_class' => __CLASS__])->active()->with('account');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeo()
    {
        return $this->hasOne(Seo::class, ['related_id' => 'id'])->andWhere(['related_name' => __CLASS__]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(TagAssignment::class, ['related_id' => 'id'])->andWhere(['related_name' => __CLASS__]);
    }

    /**
     * {@inheritdoc}
     * @return EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventQuery(get_called_class());
    }
}
