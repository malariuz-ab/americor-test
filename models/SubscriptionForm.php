<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\HtmlPurifier;
use common\models\Subscription;

class SubscriptionForm extends Model
{
    public $name;
    public $email;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required', 'message' => Yii::t('app', 'Необходимо заполнить')],

            ['name', 'string', 'max' => 255],

            ['email', 'email'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Ваше имя'),
            'email' => Yii::t('app', 'Email'),
        ];
    }

    /**
     * Saves a subscription
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $subscription = new Subscription([
            'name' => HtmlPurifier::process($this->name),
            'email' => HtmlPurifier::process($this->email),
        ]);
        $subscription->generateSubscriptionHash();

        if ($subscription->save()) {
            return Yii::$app->mailer
                ->compose('subscription-subscriber-html', ['subscription' => $subscription])
                ->setTo($this->email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setSubject(Yii::t('app','Подтверждение подписки на Industry Hunter'))
                ->send();
        }

        return false;
    }
}