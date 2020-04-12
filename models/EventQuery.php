<?php

namespace app\models;

use app\helpers\Constant;

/**
 * This is the ActiveQuery class for [[Event]].
 *
 * @see Event
 */
class EventQuery extends \yii\db\ActiveQuery
{
    /**
     * @return EventQuery
     */
    public function news()
    {
        return $this->andWhere([
            'or',
            [Event::tableName().'.event_type' => Constant::EVENT_TYPE_RUSSIAN_NEWS],
            [Event::tableName().'.event_type' => Constant::EVENT_TYPE_FOREIGN_NEWS]
        ]);
    }

    /**
     * @return EventQuery
     */
    public function russianFair()
    {
        return $this->andWhere(['event_type' => Constant::EVENT_TYPE_RUSSIAN_FAIR]);
    }

    /**
     * @return EventQuery
     */
    public function foreignFair()
    {
        return $this->andWhere(['event_type' => Constant::EVENT_TYPE_FOREIGN_FAIR]);
    }

    /**
     * @return EventQuery
     */
    public function seminar()
    {
        return $this->andWhere(['event_type' => Constant::EVENT_TYPE_SEMINAR]);
    }

    /**
     * @return EventQuery
     */
    public function notNews()
    {
        return $this->andWhere(['not in', 'event_type', [Constant::EVENT_TYPE_RUSSIAN_NEWS, Constant::EVENT_TYPE_FOREIGN_NEWS]]);
    }

    /**
     * @return EventQuery
     */
    public function upcoming()
    {
        return $this->andWhere(['>', 'datetime_to', mktime(0, 0, 0, date("m"), date("d") + 1)]);
    }

    /**
     * @return EventQuery
     */
    public function past()
    {
        return $this->andWhere(['<', 'datetime_to', mktime(0, 0, 0, date("m"), date("d") + 1)]);
    }

    /**
     * @return EventQuery
     */
    public function active()
    {
        return $this->andWhere([Event::tableName().'.status' => Constant::STATUS_PUBLISHED]);
    }

    /**
     * @return EventQuery
     */
    public function orderByDatetimeFrom()
    {
        return $this->orderBy('datetime_from ASC');
    }

    /**
     * @return EventQuery
     */
    public function orderByFreshness()
    {
        return $this->orderBy(Event::tableName().'.publish_date DESC');
    }

    /**
     * {@inheritdoc}
     * @return Event[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Event|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
