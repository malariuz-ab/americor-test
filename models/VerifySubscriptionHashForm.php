<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\base\InvalidArgumentException;
use app\models\Subscription;
use app\helpers\Constant;

/**
 * @author Alexander Bulatov <alexander.leon.bulatov@gmail.com>
 */
class VerifySubscriptionHashForm extends Model
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var Subscription
     */
    private $_subscription;


    /**
     * Creates a form model with given token.
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Verify email token cannot be blank.');
        }
        $this->_subscription = Subscription::findByHash($token);
        if (!$this->_subscription) {
            throw new InvalidArgumentException('Wrong verify email token.');
        }
        parent::__construct($config);
    }

    /**
     * Verifies the subscription
     * @return bool the saved model or null if saving fails
     */
    public function verifyHash()
    {
        $subscription = $this->_subscription;
        $subscription->status = Constant::STATUS_ON;
        if ($subscription->save()) {
            return Yii::$app->mailer
                ->compose('subscription-admin-html', ['subscription' => $subscription])
                ->setTo(Yii::$app->params['adminEmail'])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setSubject(Yii::t('app','Подтверждена подписка'))
                ->send();
        }
        return false;
    }
}