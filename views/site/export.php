<?php

/**
 * @var $this yii\web\View
 * @var $model \app\models\search\HistorySearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $exportType string
 */

use yii\grid\GridView;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;
use app\models\History;
use app\widgets\{
    Export\Export,
    HistoryList\helpers\HistoryListHelper
};

$filename = 'history' . '-' . time();

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');
?>

<?= Export::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'ins_ts',
            'label' => Yii::t('app', 'Date'),
            'format' => 'datetime'
        ],
        [
            'label' => Yii::t('app', 'User'),
            'value' => function (History $model) {
                return isset($model->user) ? $model->user->username : Yii::t('app', 'System');
            }
        ],
        [
            'label' => Yii::t('app', 'Type'),
            'value' => function (History $model) {
                return $model->object;
            }
        ],
        [
            'label' => Yii::t('app', 'Event'),
            'value' => function (History $model) {
                return $model->eventText;
            }
        ],
        [
            'label' => Yii::t('app', 'Message'),
            'value' => function (History $model) {
                return strip_tags(HistoryListHelper::getBodyByModel($model));
            }
        ]
    ],
    'exportType' => $exportType,
    'batchSize' => 2000,
    'filename' => $filename
]) ?>

<?= $this->render('_search', ['model' => $model]) ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'headerRowOptions' => ['class' => 'thead-dark'],
    'pager' => [
        'options' => ['class' => 'pagination'],
        'linkContainerOptions' => ['class' => 'page-item'],
        'linkOptions' => ['class' => 'page-link'],
        'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' => 'ins_ts',
            'label' => Yii::t('app', 'Date'),
            'value' => function($model) {
                return Yii::$app->formatter->asDatetime($model->ins_ts, 'php:d-m-Y');
            }
        ],
        [
            'label' => Yii::t('app', 'User'),
            'format' => 'html',
            'value' => function($model) {
                return isset($model->user) ? HtmlPurifier::process($model->user->username) : Yii::t('app', 'System');
            }
        ],
        [
            'label' => Yii::t('app', 'Type'),
            'headerOptions' => ['style' => 'width: 10px;'],
            'value' => function($model) {
                return HtmlPurifier::process($model->object);
            },
        ],
        [
            'label' => Yii::t('app', 'Event'),
            'format' => 'html',
            'value' => function($model) {
                return $model->eventTextByEvent;
            },
        ],
        [
            'label' => Yii::t('app', 'Message'),
            'value' => function($model) {
                return StringHelper::truncate(HtmlPurifier::process($model->message), 100);
            },
        ],
    ],
]); ?>