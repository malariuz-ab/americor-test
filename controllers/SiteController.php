<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Event;
use app\models\SubscriptionForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string|array
     * @throws NotFoundHttpException
     */
    public function actionNews()
    {
        $nextPage = Yii::$app->request->post('nextPage');
		$query = Event::find()->news()->active()->with('seo')->orderByFreshness();
        if (!empty($nextPage)) {
            $model = $query->offset($nextPage * Constant::AJAX_UPLOAD_LIMIT + 30)
                ->limit(Constant::AJAX_UPLOAD_LIMIT)
                ->all();
        } else {
            $model = $query->limit(30)->all();
        }
        $subscriptionForm = new SubscriptionForm();
        $banners = $this->getBanners(Banner::WHERE_USED_NEWS_MAIN_PAGE);

        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'Страница не найдена'));
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'isNextPageExist' => count($model) >= Constant::AJAX_UPLOAD_LIMIT,
                'content' => $this->renderPartial('_news-items', ['model' => $model, 'banners' => $banners]),
            ];
        } else {
            return $this->render('news', ['model' => $model, 'subscriptionForm' => $subscriptionForm, 'banners' => $banners]);
        }
    }
}
