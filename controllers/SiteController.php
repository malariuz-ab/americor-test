<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use app\models\Event;
use app\models\Banner;
use app\models\SubscriptionForm;
use app\models\VerifySubscriptionHashForm;
use app\helpers\Constant;

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
            throw new NotFoundHttpException(Yii::t('app', 'Sorry! Страница не найдена'));
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
	
	/**
     * Saves a subscription
     * @return array|bool
     */
    public function actionSaveSubscription()
    {
        $model = new SubscriptionForm();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model->save()) {
                    return ['message' => Yii::t('app', 'Спасибо за подписку.')];
                } else {
                    return ['errors' => $model->getErrors(), 'message' => Yii::t('ih', 'Упс! Что-то пошло не так...')];
                }
            }
        }
        return false;
    }
	
	/**
     * Approves a subscription
     * @param string $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionApproveSubscription($token)
    {
        try {
            $model = new VerifySubscriptionHashForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyHash()) {
            Yii::$app->session->setFlash('success', Yii::t('ih', 'Ваша подписка успешно подтерждена'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('ih', 'К сожалению, мы не можем подтвердить Ваш email'));
        }

        return $this->goHome();
    }
	
	/**
     * @param $name
     * @return array|Banner[]
     */
    private function getBanners($name) : array
    {
        return Banner::find()
            ->active()
            ->where(['like', 'where_used', '%'. $name .'%'])
            ->orWhere(['like', 'where_used', $name .'%'])
            ->orWhere(['like', 'where_used', $name])
            ->all();
    }
}
