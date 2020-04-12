<?php

namespace app\models;

use app\helpers\Constant;

/**
 * This is the ActiveQuery class for [[Banner]].
 *
 * @see Banner
 */
class BannerQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => Constant::STATUS_ON]);
    }

    /**
     * {@inheritdoc}
     * @return Banner[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Banner|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
