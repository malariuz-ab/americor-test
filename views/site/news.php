<?php

use yii\helpers\Url;
use yii\bootstrap4\Html;
use common\helpers\Constant;

/* @var $model common\models\Event */
/* @var $subscriptionForm frontend\models\forms\SubscriptionForm */
/* @var $banners common\models\Banner */

$this->title = Yii::t('ih', 'Новости электроники и микроэлектроники');
$this->registerMetaTag(['name' => 'description', 'content' => Yii::t('ih', 'Наиболее полная лента новостей по производству электроники и микроэлектроники, аналитика, технологии, анонсы событий и выставок, вакансии компаний.')]);
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::t('ih', 'Новости электроники, новости микроэлектроники, лента новостей, аналитика, новостной портал, высокие технологии, хай-тек, производство электроники, полупроводниковое производство, поверхностный монтаж, электронный компонент, микросхемы, печатная плата, печатный монтаж, основы электроники, время электроники, фабричка, электроника схемы.')]);
$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['/event/news'], true)], 'news-canonical-link');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="event-news">
    <?php $this->beginBlock('contentHead'); ?>
    <div class="d-flex flex-column align-items-center justify-content-center text-white bg-head-global height-20 subscription-container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_subscription-form', ['subscriptionForm' => $subscriptionForm]) ?>
    </div>
    <?php $this->endBlock(); ?>

    <div class="container mb-5">
        <div class="row">

            <?= $this->render('_news-items', ['model' => $model, 'banners' => $banners]) ?>

            <?php if (count($model) >= Constant::AJAX_UPLOAD_LIMIT) : ?>
                <div class="col-12">
                    <?= Html::button(Yii::t('ih', 'Ещё') . '<i class="fas fa-angle-down ml-2"></i>', [
                        'class' => 'btn btn-green d-block w-25 mx-auto',
                        'data' => [
                            'object' => 'show-more-button',
                            'url' => Url::to(),
                            'next-page' => '1',
                        ],
                    ]) ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
