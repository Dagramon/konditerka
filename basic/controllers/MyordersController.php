<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderSearch;
use app\models\Product;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class MyordersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            $this->redirect('/site/login');
            return false;
        }
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->searchForUser($this->request->queryParams, Yii::$app->user->identity->id_user);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id_user Id User
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_order)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_order),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Order();

        $products = Product::find()->all();
        $products = ArrayHelper::map($products, 'id_product', 'name_product');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->id_user = Yii::$app->user->identity->id_user;
                $model->save();
                return $this->redirect(['/myorders']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'products' => $products,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_user Id User
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_user)
    {
        $model = $this->findModel($id_user);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_user' => $model->id_user]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_user Id User
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_order)
    {
        if ($this->findModel($id_order)->order_status == 'Новый') {
            $this->findModel($id_order)->delete();
            Yii::$app->session->setFlash('success', 'Заявка удалена');
        } else {
            Yii::$app->session->setFlash('danger', 'Заявка не может быть удалена, так как её статус был изменён администратором');
        }

        return $this->redirect(['index']);
    }
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_user Id User
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_order)
    {
        if (($model = Order::findOne(['id_order' => $id_order])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не существует');
    }
}