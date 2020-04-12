<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $subscriptionForm frontend\models\forms\SubscriptionForm */

?>

<?php $form = ActiveForm::begin([
    'action' => Url::to(['/site/save-subscription']),
    'layout' => ActiveForm::LAYOUT_INLINE,
    'options' => ['class' => 'justify-content-md-center flex-column flex-md-row form-inline', 'data' => ['object' => 'subscription-form']],
]); ?>

<?= $form->field($subscriptionForm, 'name', ['enableError' => true])->textInput(['class' => 'form-control w-100 mr-2', 'maxlength' => true]) ?>

<?= $form->field($subscriptionForm, 'email', ['enableError' => true])->textInput(['class' => 'form-control w-100 mr-2', 'maxlength' => true]) ?>

<?= Html::submitButton(Yii::t('ih', 'Подписаться'), ['class' => 'btn btn-green']) ?>

<?php ActiveForm::end(); ?>

<div class="text-info h4" data-object="subscription-message"></div>

<div class="subscription-annotation">
    <?= Yii::t('ih', 'Подпишитесь на еженедельную рассылку сегодня!') ?>
</div>