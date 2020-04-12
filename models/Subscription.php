<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use app\helpers\Constant;

/**
 * This is the model class for table "{{%subscription}}".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $status
 * @property string $hash
 * @property int $created_at
 * @property int $updated_at
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'email', 'hash'], 'string', 'max' => 255],
            ['email', 'email'],

            ['status', 'default', 'value' => Constant::STATUS_OFF],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Generates the hash for approving the subscription
     * @throws \yii\base\Exception
     */
    public function generateSubscriptionHash()
    {
        $this->hash = Yii::$app->security->generateRandomString();
    }

    /**
     * @param string $hash
     * @return static|null
     */
    public static function findByHash($hash)
    {
        return static::findOne(['hash' => $hash, 'status' => Constant::STATUS_OFF]);
    }
}
