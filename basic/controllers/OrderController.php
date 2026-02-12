<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\OrderCancelForm;
use app\models\OrderSendingForm;
use app\models\OrderFinishForm;
use app\models\OrderSearch;
use app\models\Product;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
        if (Yii::$app->user->identity->user_role != 1) {
            $this->redirect('/site/login');
            return false;
        }
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    }

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id_order Id Order
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
     * Creates a new Order model.
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
                return $this->redirect(['/order']);
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
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_order Id Order
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_order)
    {
        $model = $this->findModel($id_order);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_order' => $model->id_order]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_order Id Order
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_order)
    {
        $this->findModel($id_order)->delete();

        return $this->redirect(['index']);
    }

    public function actionSend($id_order)
    {
        $model = OrderSendingForm::findOne($id_order);

        $product = Product::findOne([$model->id_product]);

        if ($this->request->isPost) {

            if ($model->load($this->request->post()) && ($product->amount - $model->amount >= 0)) {
                $product->amount -= $model->amount;
                $model->order_status = 'В пути';
                $model->save();
                $product->save();
                return $this->redirect(['/order']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('send', [
            'model' => $model,
        ]);
    }
    public function actionFinish($id_order)
    {
        $model = OrderSendingForm::findOne($id_order);

        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $model->order_status = 'Выполнен';
                $model->save();
                return $this->redirect(['/order']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('finish', [
            'model' => $model,
        ]);
    }

    public function actionCancel($id_order)
    {
        $model = OrderCancelForm::findOne($id_order);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->order_status = 'Отклонён';
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('cancel', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_order Id Order
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_order)
    {
        if (($model = Order::findOne(['id_order' => $id_order])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
