<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html

/* @var $model \app\models\search\HistorySearch */
?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    'options' => [
        'class' => 'some-class'
    ],
]); ?>

<?= $form->field($model, 'globalSearch', [
    'options' => ['class' => 'input-group input-group-sm'],
    'template' => "{label}\n{input}"
        . Html::beginTag('div', ['class' => 'input-group-append'])
        . Html::submitButton(Yii::t('ih/backend', 'Найти'), ['class' => 'btn btn-outline-primary'])
        . Html::resetButton(Yii::t('ih/backend', 'Сбросить'), ['class' => 'btn btn-outline-secondary'])
        . Html::endTag('div')
        ."\n{hint}\n{error}",
])->label(false) ?>

<?php ActiveForm::end(); ?>