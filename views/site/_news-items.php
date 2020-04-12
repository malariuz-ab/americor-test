<?php

use yii\bootstrap4\Html;

/* @var $model common\models\Event */
/* @var $banners common\models\Banner */

?>

<?php $size = sizeof($model); ?>
<?php foreach ($model as $key => $event): ?>
    <div class="col-md-4 mb-5">
        <?php $path = Yii::getAlias('@webroot').$event->cover_image; ?>
        <?php $isImageExist = is_file($path) && file_exists($path); ?>
        <?php if ($isImageExist): ?>
            <?php $img = Html::img(Yii::getAlias('@web').$event->cover_image, ['class' => 'img-fluid']); ?>
        <?php else: ?>
            <?php $img = Html::img('@web/img/empty-photo.png', ['class' => 'img-fluid']); ?>
        <?php endif; ?>
        <?= Html::a($img, ['/event/single', 'slug' => $event->slug]) ?>
        <p class="mb-0 pb-2 pt-2 text-muted">
            <?= Yii::$app->formatter->asDatetime($event->publish_date, 'php:d-m-Y H:i') ?>
            <span class="float-right"><i class="far fa-eye"></i> <?= $event->views_number ?></span>
        </p>
        <h2 class="h5">
            <?= Html::a($event->title, ['/event/single', 'slug' => $event->slug], ['class' => 'text-reset']) ?>
        </h2>
        <?= Html::a($event->annotation, ['/event/single', 'slug' => $event->slug], ['class' => 'text-reset']) ?>
    </div>
    <?php if (!Yii::$app->request->isAjax): ?>
        <?php if ($size > 6 && $key == 5 && !empty($banners) || $size <= 6 && !next($model) && !empty($banners)): ?>
            <?php foreach ($banners as $banner): ?>
                <?php $bannerPath = Yii::getAlias('@webroot') . $banner->path; ?>
                <?php if (is_file($bannerPath) && file_exists($bannerPath)): ?>
                    <div class="col-12">
                        <?php $img = Html::img(Yii::getAlias('@web') . $banner->path, ['class' => 'img-fluid shadow-lg mb-5']) ?>
                        <?= Html::a($img, $banner->weblink, ['target' => '_blank']) ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>