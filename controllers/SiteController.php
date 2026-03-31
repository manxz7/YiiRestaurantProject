<?php

namespace app\controllers;

use app\models\Booking;
use app\models\ContactForm;
use Yii;
use app\models\LoginForm;
use app\models\Menu;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
        $featuredMenus = [];
        $menusByCategory = [];
        $bookingCount = 0;
        $availableMenuCount = 0;
        $confirmedBookingCount = 0;

        try {
            $featuredMenus = Menu::find()
                ->where(['is_available' => 1])
                ->orderBy(['id' => SORT_DESC])
                ->limit(6)
                ->all();

            $allMenus = Menu::find()
                ->where(['is_available' => 1])
                ->orderBy(['category' => SORT_ASC, 'id' => SORT_DESC])
                ->all();

            foreach ($allMenus as $menu) {
                $menusByCategory[$menu->category][] = $menu;
            }

            $availableMenuCount = count($allMenus);
        } catch (\Throwable $e) {
            $featuredMenus = [];
            $menusByCategory = [];
            $availableMenuCount = 0;
        }

        try {
            $bookingCount = (int) Booking::find()->count();
            $confirmedBookingCount = (int) Booking::find()->where(['status' => 'confirmed'])->count();
        } catch (\Throwable $e) {
            $bookingCount = 0;
            $confirmedBookingCount = 0;
        }

        return $this->render('index', [
            'featuredMenus' => $featuredMenus,
            'menusByCategory' => $menusByCategory,
            'bookingCount' => $bookingCount,
            'availableMenuCount' => $availableMenuCount,
            'confirmedBookingCount' => $confirmedBookingCount,
        ]);
    }

    /**
     * Displays cart page.
     *
     * @return string
     */
    public function actionCart()
    {
        return $this->render('cart');
    }

    /**
     * Displays checkout page and stores confirmed order.
     *
     * @return Response|string
     */
    public function actionCheckout()
    {
        $model = new Booking();
        $model->status = 'confirmed';

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if ($model->load($post)) {
                $cartData = Yii::$app->request->post('cart_data');
                $totalPrice = Yii::$app->request->post('total_price');

                if (!empty($cartData)) {
                    $orderNote = "Order cart data: " . $cartData;

                    if (!empty($totalPrice)) {
                        $orderNote .= "\nTotal: RM " . $totalPrice;
                    }

                    $existingMessage = trim((string) $model->message);
                    $model->message = $existingMessage === ''
                        ? $orderNote
                        : $existingMessage . "\n\n" . $orderNote;
                }

                if ($model->save()) {
                    return $this->redirect(['order-confirmed', 'id' => $model->id]);
                }
            }
        }

        return $this->render('checkout', [
            'model' => $model,
        ]);
    }

    /**
     * Displays confirmed order page.
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOrderConfirmed($id)
    {
        $booking = Booking::findOne($id);

        if ($booking === null) {
            throw new NotFoundHttpException('The requested order confirmation does not exist.');
        }

        return $this->render('order-confirmed', [
            'booking' => $booking,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
